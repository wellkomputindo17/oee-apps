<?php

namespace App\Http\Controllers;

use DateTime;
use App\Models\Line;
use App\Models\Mesin;
use App\Models\DoModel;
use App\Models\LogMesin;
use App\Models\NotifMesin;
use App\Models\OeeService;
use Illuminate\Http\Request;
use App\Models\RealTimeMesin;
use App\Models\ScheduleMesin;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Database\QueryException;

class DataAjaxController extends Controller
{
    public function ajax_get_mesin(Request $request)
    {
        $search = $request->q;

        $data = [];
        if ($request->ajax()) {
            if ($search == '') {
                $data = Mesin::limit(10)->get();
            } else {
                $data = Mesin::where('name', 'like', "%$search%")->orWhere('no_mesin', 'like', "%$search%")->limit(10)->get();
            }
        }

        return response()->json($data);
    }

    public function ajax_get_line(Request $request)
    {
        $search = $request->q;

        $data = [];
        if ($request->ajax()) {
            if ($search == '') {
                $data = Line::limit(10)->get();
            } else {
                $data = Line::where('name', 'like', "%$search%")->limit(10)->get();
            }
        }

        return response()->json($data);
    }

    public function ajax_get_do(Request $request)
    {
        $search = $request->q;
        $action = $request->action;
        // dd($action);
        $data = [];
        if ($request->ajax()) {
            if ($action == 'not_run') {
                if ($search == '') {
                    $data = DoModel::whereNull('log_time_start')->limit(10)->get();
                } else {
                    $data = DoModel::whereNull('log_time_start')->where(function ($query) use ($search) {
                        $query->where('name', 'like', "%$search%")
                            ->orWhere('no_do', 'like', "%$search%");
                    })->limit(10)->get();
                }
            } else {
                if ($search == '') {
                    $data = DoModel::whereNotNull('log_time_start')->limit(10)->get();
                } else {
                    $data = DoModel::whereNotNull('log_time_start')->where(function ($query) use ($search) {
                        $query->where('name', 'like', "%$search%")
                            ->orWhere('no_do', 'like', "%$search%");
                    })->limit(10)->get();
                }
            }
        }

        return response()->json($data);
    }

    public function ajax_change_mesin(Request $request)
    {
        $id = $request->id;
        $return = false;
        if ($request->ajax()) {
            $search = ScheduleMesin::where('mesin_id', $id)->where(function ($query) {
                $query->where('start', '<=', date('Y-m-d H:i:s'))
                    ->where('stop', '>=', date('Y-m-d H:i:s'));
            })->first();
            if ($search) {
                $return = true;
            } else {
                $return = false;
            }
        }
        return response()->json($return);
    }

    public function ajax_done_repair(Request $request)
    {
        $mesin_id = $request->mesin_id;
        $no_do = $request->no_do;
        $endpoint = env('ENDPOINT_URL');
        if ($request->ajax()) {
            DB::beginTransaction();
            try {
                Http::post("{$endpoint}/mesin?mesinId={$mesin_id}&mode=produksi");

                $response = Http::get("{$endpoint}/mesin?mesinId={$request->mesin_id}&nomorDo={$request->no_do}");

                $data = $response->object();

                $rtm = RealTimeMesin::with('do')->where('mesin_id', $mesin_id)->where('no_do', $no_do)->first();
                $lm = new LogMesin();
                $date_time = date('Y-m-d H:i:s');

                $lm_update = LogMesin::where('no_do', $no_do)->whereNull('log_time_stop')->first();
                $start = new DateTime($lm_update->log_time_start);
                $end = new DateTime($date_time);
                $durasi = $start->diff($end);
                $format_durasi = $durasi->format('%H:%i:%s');

                $rtm->status = 'produksi';
                $rtm->actual = $data->actual == null ? 0 : $data->actual;
                $rtm->ng = $data->notGood == 'NaN' ? 0 : $data->notGood;
                $rtm->cycle_time = $data->cycleTime;
                $rtm->update();

                $lm_update->log_time_stop = $date_time;
                $lm_update->duration = $format_durasi;
                $lm_update->update();

                $lm->realtime_mesin_id = $rtm->id;
                $lm->no_do = $no_do;
                $lm->log_time_start = date('Y-m-d H:i:s');
                $lm->desc_type = 'production';
                $lm->reason_desc = 'production';
                $lm->status = 'produksi';
                $lm->created_by = 'admin';
                $lm->save();

                DB::commit();
                return response()->json([
                    'msg' => 'success',
                    'desc' => 'This machine has been repaired.'
                ]);
            } catch (QueryException $th) {
                DB::rollback();

                return response()->json([
                    'msg' => 'error',
                    'desc' => $th->getMessage()
                ]);
            } catch (\Throwable $th) {
                DB::rollback();

                return response()->json([
                    'msg' => 'error',
                    'desc' => $th->getMessage()
                ]);
            }
        }
    }

    public function ajax_maintenance_mesin(Request $request)
    {
        $mesin_id = $request->mesin_id;
        $no_do = $request->no_do;
        $type = $request->type;
        $desc = $request->desc;
        $reason = $request->reason;
        $endpoint = env('ENDPOINT_URL');
        if ($request->ajax()) {
            DB::beginTransaction();
            try {
                Http::post("{$endpoint}/mesin?mesinId={$mesin_id}&mode=produksi");

                $rtm = RealTimeMesin::with(['do', 'mesin'])->where('mesin_id', $mesin_id)->where('no_do', $no_do)->first();
                if (!$rtm) {
                    DB::rollback();

                    return response()->json([
                        'msg' => 'error',
                        'desc' => 'No data available in table'
                    ]);
                }
                $lm = new LogMesin();
                $date_time = date('Y-m-d H:i:s');

                $lm_update = LogMesin::where('no_do', $request->no_do)->whereNull('log_time_stop')->first();
                $start = new DateTime($lm_update->log_time_start);
                $end = new DateTime($date_time);
                $durasi = $start->diff($end);
                $format_durasi = $durasi->format('%H:%i:%s');

                $response = Http::get("{$endpoint}/mesin?mesinId={$request->mesin_id}&nomorDo={$request->no_do}");

                $data = $response->object();

                $rtm->status = 'produksi';
                $rtm->actual = $data->actual == null ? 0 : $data->actual;
                $rtm->ng = $data->notGood == 'NaN' ? 0 : $data->notGood;
                $rtm->cycle_time = $data->cycleTime;
                $rtm->update();

                $lm_update->log_time_stop = $date_time;
                $lm_update->desc_type = $desc;
                $lm_update->reason_desc = $reason;
                $lm_update->duration = $format_durasi;
                $lm->status = 'produksi';
                $lm_update->update();

                $lm->realtime_mesin_id = $rtm->id;
                $lm->no_do = $no_do;
                $lm->log_time_start = $date_time;
                $lm->desc_type = 'production';
                $lm->reason_desc = 'production';
                $lm->status = 'produksi';
                $lm->created_by = 'admin';
                $lm->save();

                $nm = NotifMesin::where('mesin_id', $mesin_id)->where('no_do', $no_do)->where('status', 'pending')->first();
                $nm->status = 'done';
                $nm->time_stop = $date_time;
                $nm->update();

                DB::commit();
                return response()->json([
                    'msg' => 'success',
                    'desc' => "This {$rtm->mesin->name} has been repaired."
                ]);
            } catch (QueryException $th) {
                DB::rollback();

                return response()->json([
                    'msg' => 'error',
                    'desc' => $th->getMessage()
                ]);
            } catch (\Throwable $th) {
                DB::rollback();

                return response()->json([
                    'msg' => 'error',
                    'desc' => $th->getMessage()
                ]);
            }
        }
    }


    public function ajax_finish_mesin(Request $request)
    {
        $mesin_id = $request->mesin_id;
        $no_do = $request->no_do;
        $status = $request->status;
        $endpoint = env('ENDPOINT_URL');

        if ($request->ajax()) {
            Http::post("{$endpoint}/mesin?mesinId={$mesin_id}&mode=Finish");

            DB::beginTransaction();
            try {
                if ($status == 'pending') {
                    $rtm = RealTimeMesin::with(['do', 'mesin'])->where('mesin_id', $mesin_id)->where('no_do', $no_do)->first();
                    if (!$rtm) {
                        DB::rollback();

                        return response()->json([
                            'msg' => 'error',
                            'desc' => 'No data available in table'
                        ]);
                    }
                    $lm = new LogMesin();
                    $date_time = date('Y-m-d H:i:s');

                    $do = DoModel::where('no_do', $request->no_do)->first();

                    $lm_update = LogMesin::where('no_do', $request->no_do)->whereNull('log_time_stop')->first();
                    $start = new DateTime($lm_update->log_time_start);
                    $end = new DateTime($date_time);
                    $durasi = $start->diff($end);
                    $format_durasi = $durasi->format('%H:%i:%s');

                    $response = Http::get("{$endpoint}/mesin?mesinId={$request->mesin_id}&nomorDo={$request->no_do}");
                    $data = $response->object();

                    $rtm->status = 'Finish';
                    $rtm->actual = $data->actual == null ? 0 : $data->actual;
                    $rtm->ng = $data->notGood == 'NaN' ? 0 : $data->notGood;
                    $rtm->cycle_time = $data->cycleTime;
                    $rtm->update();

                    $lm_update->log_time_stop = $date_time;
                    $lm_update->desc_type = 'Finish';
                    $lm_update->reason_desc = 'Finish';
                    $lm_update->duration = $format_durasi;
                    $lm->status = 'Finish';
                    $lm_update->update();

                    $do->actual = $data->actual == null ? 0 : $data->actual;
                    $do->ng = $data->notGood == 'NaN' ? 0 : $data->notGood;
                    $do->time_stop = $date_time;
                    $do->log_time_stop = $date_time;
                    $do->update();

                    $lm->realtime_mesin_id = $rtm->id;
                    $lm->no_do = $no_do;
                    $lm->log_time_start = $date_time;
                    $lm->log_time_stop = $date_time;
                    $lm->desc_type = 'Finish';
                    $lm->reason_desc = 'Finish';
                    $lm->status = 'Finish';
                    $lm->created_by = 'admin';
                    $lm->save();

                    $nm = NotifMesin::where('mesin_id', $mesin_id)->where('no_do', $no_do)->where('status', 'pending')->first();
                    $nm->status = 'done';
                    $nm->time_stop = $date_time;
                    $nm->update();

                    DB::commit();
                    return response()->json([
                        'msg' => 'success',
                        'desc' => "This {$rtm->mesin->name} is finished"
                    ]);
                } else {
                    $rtm = RealTimeMesin::with(['do', 'mesin'])->where('mesin_id', $mesin_id)->where('no_do', 0)->where('status', 'perbaikan')->first();
                    if (!$rtm) {
                        DB::rollback();

                        return response()->json([
                            'msg' => 'error',
                            'desc' => 'No data available in table'
                        ]);
                    }

                    $lm = new LogMesin();
                    $date_time = date('Y-m-d H:i:s');

                    $lm_update = LogMesin::where('no_do', 0)->where('status', 'perbaikan')->whereNull('log_time_stop')->first();
                    $start = new DateTime($lm_update->log_time_start);
                    $end = new DateTime($date_time);
                    $durasi = $start->diff($end);
                    $format_durasi = $durasi->format('%H:%i:%s');

                    $response = Http::get("{$endpoint}/mesin?mesinId={$request->mesin_id}&nomorDo={$request->no_do}");
                    $data = $response->object();

                    $rtm->status = 'Finish';
                    $rtm->actual = $data->actual == null ? 0 : $data->actual;
                    $rtm->ng = $data->notGood == 'NaN' ? 0 : $data->notGood;
                    $rtm->cycle_time = $data->cycleTime;
                    $rtm->update();

                    $lm_update->log_time_stop = $date_time;
                    $lm_update->desc_type = 'Finish';
                    $lm_update->reason_desc = 'Finish';
                    $lm_update->duration = $format_durasi;
                    $lm->status = 'Finish';
                    $lm_update->update();

                    $lm->realtime_mesin_id = $rtm->id;
                    $lm->no_do = 0;
                    $lm->log_time_start = $date_time;
                    $lm->log_time_stop = $date_time;
                    $lm->desc_type = 'Finish';
                    $lm->reason_desc = 'Finish';
                    $lm->status = 'Finish';
                    $lm->created_by = 'admin';
                    $lm->save();

                    $nm = NotifMesin::where('mesin_id', $mesin_id)->where('no_do', 0)->where('status', 'perbaikan')->first();
                    $nm->status = 'done';
                    $nm->time_stop = $date_time;
                    $nm->update();

                    DB::commit();
                    return response()->json([
                        'msg' => 'success',
                        'desc' => "This {$rtm->mesin->name} has been repaired"
                    ]);
                }
            } catch (QueryException $th) {
                DB::rollback();

                return response()->json([
                    'msg' => 'error',
                    'desc' => $th->getMessage()
                ]);
            } catch (\Throwable $th) {
                DB::rollback();

                return response()->json([
                    'msg' => 'error',
                    'desc' => $th->getMessage()
                ]);
            }
        }
    }

    public function ajax_list_maintenance(Request $request)
    {
        $data = [];
        if ($request->ajax()) {
            $plan = DB::table('plan_down_times')->get();

            $plan = $this->buildtree($plan);

            $unplan = DB::table('unplan_down_times')->get();

            $unplan = $this->buildtree($unplan);

            $speed_loss = DB::table('speed_losses')->get();

            $speed_loss = $this->buildtree($speed_loss);

            $data = [
                'plan_downtimes' => $plan,
                'unplan_downtimes' => $unplan,
                'speed_loss' => $speed_loss
            ];
        }
        return response()->json($data);
    }

    public function buildtree($src_arr, $parent_id = 0, $tree = array())
    {
        foreach ($src_arr as $idx => $row) {
            if ($row->parent_id == $parent_id) {
                foreach ($row as $k => $v)
                    $tree[$row->id][$k] = $v;
                unset($src_arr[$idx]);
                $tree[$row->id]['children'] = $this->buildtree($src_arr, $row->id);
            }
        }
        ksort($tree);
        return $tree;
    }
}
