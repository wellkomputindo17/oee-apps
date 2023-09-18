<?php

namespace App\Http\Controllers;

use App\Models\LogMesin;
use App\Models\NotifMesin;
use App\Models\OeeService;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ListConsoleController extends Controller
{
    public function index(Request $request)
    {
        $mesin_name = $request->mesin_name;
        $do_name = $request->do_name;
        $mesin_id = $request->mesin_id;
        $no_do = $request->no_do;
        $is_plan = $request->is_plan;

        $title = "List Console Operator";

        $notif = NotifMesin::where('status', 'pending')->get();

        return view('console.list.index', compact('title', 'mesin_name', 'mesin_id', 'no_do', 'do_name', 'notif', 'is_plan'));
    }

    public function ajax_list(Request $request)
    {
        if ($request->ajax()) {
            $rtm = OeeService::where('mesin_id', $request->mesin_id)->first();
           
            if ($rtm) {
                if ($rtm->status == 'running') {
                    $log = LogMesin::with(['realtime_mesin.mesin', 'do'])->where('no_do', $request->no_do)->whereHas('realtime_mesin.mesin', function ($query) use ($request) {
                        $query->where('mesin_id', $request->mesin_id);
                    })->orderBy('id', 'DESC')->select('*');
                } else {
                    $log = LogMesin::with(['realtime_mesin.mesin', 'do'])->whereHas('realtime_mesin.mesin', function ($query) use ($request) {
                        $query->where('mesin_id', $request->mesin_id);
                    })->orderBy('id', 'DESC')->select('*');
                }
            } else {
                $log = LogMesin::with(['realtime_mesin.mesin', 'do'])->where('no_do', $request->no_do)->whereHas('realtime_mesin.mesin', function ($query) use ($request) {
                    $query->where('mesin_id', $request->mesin_id);
                })->orderBy('id', 'DESC')->select('*');
            }

            // dd($log);
            return DataTables::of($log)
                ->editColumn('updated_at', function ($log) {
                    return !empty($log->updated_at) ? date("d-m-Y H:i", strtotime($log->updated_at)) : null;
                })
                ->editColumn('log_start', function ($log) {
                    return !empty($log->log_time_start) ? date("H:i:s", strtotime($log->log_time_start)) : null;
                })
                ->editColumn('log_stop', function ($log) {
                    return !empty($log->log_time_stop) ? date("H:i:s", strtotime($log->log_time_stop)) : null;
                })
                ->editColumn('loss', function ($log) {
                    if ($log->status == 'produksi') {
                        return "<div class='box box--green'></div>";
                    } else if ($log->status == "downtime") {
                        return "<div class='box box--yellow'></div>";
                    } else if ($log->status == "perbaikan") {
                        return "<div class='box box--red'></div>";
                    } else {
                        return "<div class='box box--dark'></div>";
                    }
                })
                ->rawColumns(['updated_at', 'log_start', 'log_stop', 'loss'])
                ->addIndexColumn()
                ->make(true);
        }
    }
}
