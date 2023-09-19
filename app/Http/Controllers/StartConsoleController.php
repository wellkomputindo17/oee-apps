<?php

namespace App\Http\Controllers;

use App\Models\DoModel;
use App\Models\LogMesin;
use App\Models\NotifMesin;
use App\Models\OeeService;
use App\Models\PlanDownTime;
use App\Models\TimeDownLoss;
use Illuminate\Http\Request;
use App\Models\RealTimeMesin;
use App\Models\ScheduleMesin;
use DateTime;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Validator;

class StartConsoleController extends Controller
{
    public function index()
    {
        $title = 'Form Start Console';

        $notif = NotifMesin::where('status', 'pending')->orWhere('status', 'perbaikan')->get();


        return view('console.start.index', compact('title', 'notif'));
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

    public function store(Request $request)
    {
        $mesin_id = $request->mesin_id;
        $no_do = $request->no_do;
        $target = $request->target;
        $mesin_name = $request->mesin_name;
        $do_name = $request->do_name;
        $is_plan = $request->is_plan == "yes" ? true : false;

        $endpoint = env('ENDPOINT_URL');

        DB::beginTransaction();
        try {
            if ($is_plan) {
                $validate = [
                    'mesin_id' => 'required',
                ];
            } else {
                $validate = [
                    'mesin_id' => 'required',
                    'no_do' => 'required',
                ];
            }

            $validator = Validator::make($request->all(), $validate);

            if ($validator->fails()) {
                return response()->json(
                    [
                        'msg' => 'error',
                        'desc' => $validator->messages()->first(),
                    ]
                );
            }

            $cek = RealTimeMesin::with(['mesin'])->where('mesin_id', $mesin_id)->where(function ($query) {
                $query->where('status', 'produksi')
                    ->orWhere('status', 'perbaikan')
                    ->orWhere('status', 'downtime');
            })->first();

            if ($cek) {
                if ($cek->status == 'produksi') {
                    return response()->json(
                        [
                            'msg' => 'error',
                            'desc' => "The machine {$cek->mesin->name} is already running with production status and uses do number {$cek->no_do}",
                        ]
                    );
                } else if ($cek->status == 'perbaikan') {
                    return response()->json(
                        [
                            'msg' => 'error',
                            'desc' => "The machine {$cek->mesin->name} is already running with maintenance status and uses do number {$cek->no_do}",
                        ]
                    );
                } else if ($cek->status == 'downtime') {
                    return response()->json(
                        [
                            'msg' => 'error',
                            'desc' => "The machine {$cek->mesin->name} is already running with downtime status and uses do number {$cek->no_do}",
                        ]
                    );
                }
            }


            if ($is_plan) {
                $rm = new RealTimeMesin();
                $rm->no_do = 0;
                $rm->mesin_id = $mesin_id;
                $rm->target = $target;
                $rm->is_plan = $is_plan;
                $rm->status = 'perbaikan';
                // $rm->operator = auth()->user()->name;  //KETIKA SUDAH DIBUATKAN MENU LOGIN
                $rm->operator = 'admin';
                $rm->save();
            } else {
                $rm = new RealTimeMesin();
                $rm->no_do = $no_do;
                $rm->mesin_id = $mesin_id;
                $rm->target = $target;
                $rm->is_plan = $is_plan;
                $rm->status = 'produksi';
                // $rm->operator = auth()->user()->name;  //KETIKA SUDAH DIBUATKAN MENU LOGIN
                $rm->operator = 'admin';
                $rm->save();
            }

            $lm = new LogMesin();
            $lm->realtime_mesin_id = $rm->id;

            $lm->no_do = ($is_plan) ? 0 :  $no_do;

            $lm->no_do = ($is_plan) ? 0 : $no_do;

            $lm->log_time_start = date('Y-m-d H:i:s');
            $lm->desc_type = ($is_plan) ? 'maintenance' : 'production';
            $lm->reason_desc = ($is_plan) ? 'maintenance' : 'production';
            $lm->status = ($is_plan) ? 'perbaikan' : 'produksi';
            $lm->created_by = 'admin';
            $lm->save();

            if (!$is_plan) {
                $do = DoModel::where('no_do', $no_do)->first();
                $do->operator = 'admin';
                $do->time_start = date('Y-m-d H:i:s');
                $do->log_time_start = date('Y-m-d H:i:s');
                $do->update();
            }


            $arr = [
                'mesin_id' => $mesin_id,
                'no_do' => ($is_plan) ? 0 :  $no_do,
                'is_plan' => $is_plan,
                'mesin_name' => $mesin_name,
                'do_name' => $do_name,
            ];



            // JALANKAN FUNGSI POST KE MESIN
            if (!$is_plan) {
                $response = Http::post("{$endpoint}/mesin?mesinId={$mesin_id}&mode=produksi");
            } else {
                $response = Http::post("{$endpoint}/mesin?mesinId={$mesin_id}&mode=perbaikan");
            }


            $data = $response->object();

            if ($data->Status == 'Sucees') {

                if (!$is_plan) {
                    $oee = new OeeService();
                    $oee->mesin_id = $mesin_id;
                    $oee->no_do = $no_do;
                    $oee->status = 'running';
                    $oee->save();
                } else {
                    $oee = new OeeService();
                    $oee->mesin_id = $mesin_id;
                    $oee->no_do = 0;
                    $oee->status = 'maintenance';
                    $oee->save();

                    $nm = new NotifMesin();
                    $nm->no_do = 0;
                    $nm->mesin_id = $request->mesin_id;
                    $nm->mesin_name = "Machine {$request->mesin_id}";
                    $nm->status = 'perbaikan';
                    $nm->time_start = date('Y-m-d H:i:s');
                    $nm->save();
                }


                // php artisan schedule:work
                // $path = base_path('services\service-oee.bat');
                // $handle = popen("c:\WINDOWS\system32\cmd.exe /c START {$path}", 'r');
                // dd($handle);

                // pclose($handle);

                if (!$is_plan) {
                    DB::commit();
                    return response()->json(
                        [
                            'msg' => 'sukses',
                            'desc' => 'The machine is running successfully!',
                            'data' => $arr
                        ],
                    );
                } else {
                    DB::commit();
                    return response()->json(
                        [
                            'msg' => 'sukses',
                            'desc' => 'The machine maintenance, is running successfully!',
                            'data' => $arr
                        ],
                    );
                }
            } else {
                DB::rollback();
                return response()->json(
                    [
                        'msg' => 'error',
                        'desc' => 'The machine is error!',
                    ],
                );
            }
        } catch (QueryException $th) {
            DB::rollback();

            echo json_encode([
                'msg' => 'error',
                'desc' => $th->getMessage()
            ]);
            die;
        } catch (\Throwable $th) {
            DB::rollback();

            echo json_encode([
                'msg' => 'error',
                'desc' => $th->getMessage(),
            ]);
            die;
        }
    }

    public function run_schedule(Request $request)
    {
        DB::beginTransaction();
        try {
            $endpoint = env('ENDPOINT_URL');
            // GET STATUS MESIN
            $response = Http::get("{$endpoint}/mesin?mesinId={$request->mesin_id}&nomorDo={$request->no_do}");
            $data = $response->object();

            $rtm = RealTimeMesin::with(['do', 'mesin'])->where('mesin_id', $request->mesin_id)->where('no_do', $request->no_do)->first();
            if (!$rtm) {
                DB::rollback();

                return response()->json([
                    'msg' => 'error',
                    'desc' => 'No data available in table'
                ]);
            }
            $do = DoModel::where('no_do', $request->no_do)->first();

            if ($data->Buzzer == 0 && ($data->statusMesin == 'stop' && $data->mode == 'produksi') && $rtm->status != 'downtime') {

                DB::rollback();

                return response()->json([
                    'msg' => 'success',
                    'code' => 'stop_produksi',
                    'desc' => 'This machine has not been started, has it been started?',
                    'data' => $data
                ]);
            } else if ($data->Buzzer == 0 && ($data->statusMesin == 'running' && $data->mode == 'produksi') && $rtm->status != 'downtime') {
                $rtm->status = $data->mode;
                $rtm->actual = $data->actual == null ? 0 : $data->actual;
                $rtm->ng = $data->notGood == 'NaN' ? 0 : $data->notGood;
                $rtm->cycle_time = $data->cycleTime;
                $rtm->update();

                $do->actual = $data->actual == null ? 0 : $data->actual;
                $do->ng = $data->notGood == 'NaN' ? 0 : $data->notGood;
                $do->update();

                DB::commit();
                return response()->json([
                    'msg' => 'success',
                    'code' => 'running',
                    'desc' => 'This machine has been started and is working on production.',
                    'data' => $data
                ]);
            } else if ($data->Buzzer == 1 && ($data->statusMesin == 'stop' && $data->mode == 'produksi') && $rtm->status != 'downtime') {
                // $path = base_path('services\service-oee.bat');
                // $handle = exec("taskkill /F /IM c:\WINDOWS\system32\cmd.exe /FI START {$path}");

                $lm = new LogMesin();
                $date_time = date('Y-m-d H:i:s');

                $lm_update = LogMesin::where('no_do', $request->no_do)->whereNull('log_time_stop')->first();
                $start = new DateTime($lm_update->log_time_start);
                $end = new DateTime($date_time);
                $durasi = $start->diff($end);
                $format_durasi = $durasi->format('%H:%i:%s');

                $nm = new NotifMesin();
                $nm->no_do = $request->no_do;
                $nm->mesin_id = $request->mesin_id;
                $nm->mesin_name = $rtm->mesin->name;
                $nm->do_name = $rtm->do->name;
                $nm->status = 'pending';
                $nm->time_start = $date_time;
                $nm->save();

                $rtm->status = 'downtime';
                $rtm->actual = $data->actual == null ? 0 : $data->actual;
                $rtm->ng = $data->notGood == 'NaN' ? 0 : $data->notGood;
                $rtm->cycle_time = $data->cycleTime;
                $rtm->update();

                $lm_update->log_time_stop = $date_time;
                $lm_update->duration = $format_durasi;
                $lm_update->update();

                $lm->realtime_mesin_id = $rtm->id;
                $lm->no_do = $request->no_do;
                $lm->log_time_start = $date_time;
                $lm->status = 'downtime';
                $lm->type = 'downtime';
                $lm->created_by = 'admin';
                $lm->save();

                DB::commit();

                return response()->json([
                    'msg' => 'success',
                    'code' => 'stop_perbaikan',
                    'triger' => 2,
                    'desc' => 'The machine is off, please check the machine and notify whether it is being repaired or finished.',
                    'data' => $data
                ]);
            } else if ($data->Buzzer == 1 && ($data->statusMesin == 'stop' && $data->mode == 'produksi') && $rtm->status == 'downtime') {
                DB::rollback();

                return response()->json([
                    'msg' => 'success',
                    'code' => 'downtime',
                    'triger' => 1,
                    'desc' => 'This machine is stopped.',
                    'data' => $data
                ]);
            } else if ($data->Buzzer == 0 && ($data->statusMesin == 'stop' && $data->mode == 'Finish') && $rtm->status != 'downtime') {
                DB::rollback();

                return response()->json([
                    'msg' => 'success',
                    'code' => 'stop_finish',
                    'desc' => 'This machine is finished.',
                    'data' => $data
                ]);
            } else if ($data->Buzzer == 0 && ($data->statusMesin == 'stop' && $data->mode == 'perbaikan') && $rtm->status != 'downtime') {
                DB::rollback();

                return response()->json([
                    'msg' => 'success',
                    'code' => 'perbaikan',
                    'desc' => 'This machine is under maintenance.',
                    'data' => $data
                ]);
            } else {
                DB::rollback();

                return response()->json([
                    'msg' => 'error',
                    'desc' => 'System error please contact the Support team'
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
