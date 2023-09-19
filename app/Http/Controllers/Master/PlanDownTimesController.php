<?php

namespace App\Http\Controllers\Master;

use App\Models\NotifMesin;
use App\Models\PlanDownTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class PlanDownTimesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = "Plan Downtimes";
        $data = DB::table('plan_down_times')->get();

        $data = $this->buildtree($data);

        $data = json_decode(json_encode($data), FALSE);

        // $query = DB::table('plan_down_times')
        //     ->selectRaw('id, jenis_downtime, jenis_downtime as path, 0 as hierarchy')
        //     ->whereNull('parent_id')
        //     ->unionAll(
        //         DB::table('plan_down_times')
        //             ->selectRaw('plan_down_times.id, plan_down_times.jenis_downtime, CONCAT(tree.path, ">", plan_down_times.jenis_downtime) as path, tree.hierarchy + 1')
        //             ->join('tree', 'tree.id', '=', 'plan_down_times.parent_id')
        //     );

        // $tree = DB::table('tree')
        //     ->withRecursiveExpression('tree', $query)
        //     ->orderBy('path')
        //     ->get();

        // dd($tree);
        $notif = NotifMesin::where('status', 'pending')->orWhere('status', 'perbaikan')->get();

        return view('master.plan.index', compact('title', 'data', 'notif'));
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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            if ($request->action != 'delete') {
                $validator = Validator::make($request->all(), [
                    'jenis_downtime'      => 'required',
                ], [
                    'jenis_downtime'  => 'The type downtime field is required!'
                ]);

                if ($validator->fails()) {
                    return response()->json(
                        [
                            'msg' => 'error',
                            'desc' => $validator->messages()->first(),
                        ]
                    );
                }
            }

            if ($request->action == 'add') {
                if ($request->type == 'parent') {
                    $pl = new PlanDownTime();
                    $pl->jenis_downtime = $request->jenis_downtime;
                    $pl->desc = $request->desc;
                    $pl->save();

                    echo json_encode([
                        'msg' => 'sukses',
                        'desc' => 'New Parent Plan Downtime has beed added!',
                        'data' => $pl
                    ]);
                    die;
                } elseif ($request->type == 'child') {
                    $pl = new PlanDownTime();
                    $pl->jenis_downtime = $request->jenis_downtime;
                    $pl->desc = $request->desc;
                    $pl->parent_id = $request->id_sub;
                    $pl->save();

                    echo json_encode([
                        'msg' => 'sukses',
                        'desc' => 'New Child Plan Downtime has beed added!',
                        'data' => $pl
                    ]);
                    die;
                } else {
                    echo json_encode([
                        'msg' => 'error',
                        'desc' => 'Error!',
                    ]);
                    die;
                }
            } else if ($request->action == 'delete') {
                if ($request->type == 'child') {
                    PlanDownTime::where('id', $request->id_sub)->orWhere('parent_id', $request->id_sub)->delete();
                    echo json_encode([
                        'msg' => 'sukses',
                        'desc' => 'Parent Plan Downtimes has been deleted!',
                    ]);
                    die;
                } elseif ($request->type == 'child_2') {
                    PlanDownTime::where('id', $request->id_sub)->delete();
                    echo json_encode([
                        'msg' => 'sukses',
                        'desc' => 'Child Plan Downtimes has been deleted!',
                    ]);
                    die;
                } else {
                    echo json_encode([
                        'msg' => 'error',
                        'desc' => 'Error!',
                    ]);
                    die;
                }
            } else if ($request->action == 'edit') {
                $pl = PlanDownTime::find($request->id_sub);
                $pl->jenis_downtime = $request->jenis_downtime;
                $pl->desc = $request->desc;
                $pl->update();

                echo json_encode([
                    'msg' => 'sukses',
                    'desc' => 'Plan Downtime has beed updated!',
                    'data' => $pl
                ]);
                die;
            } else {
                echo json_encode([
                    'msg' => 'error',
                    'desc' => 'Error!',
                ]);
                die;
            }
        } catch (\Throwable $th) {
            echo json_encode([
                'msg' => 'error',
                'desc' => $th->getMessage(),
            ]);
            die;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(PlanDownTime $plan)
    {
        echo json_encode($plan);
        die;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
