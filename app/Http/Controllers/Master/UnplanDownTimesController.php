<?php

namespace App\Http\Controllers\Master;

use App\Models\NotifMesin;
use Illuminate\Http\Request;
use App\Models\UnplanDownTime;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class UnplanDownTimesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = "Unplan Downtimes";
        $data = DB::table('unplan_down_times')->get();

        $data = $this->buildtree($data);

        $data = json_decode(json_encode($data), FALSE);

        $notif = NotifMesin::where('status', 'pending')->orWhere('status', 'perbaikan')->get();
        return view('master.unplan.index', compact('title', 'data', 'notif'));
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
                    $pl = new UnplanDownTime();
                    $pl->jenis_downtime = $request->jenis_downtime;
                    $pl->desc = $request->desc;
                    $pl->save();

                    echo json_encode([
                        'msg' => 'sukses',
                        'desc' => 'New Parent Unplan Downtime has beed added!',
                        'data' => $pl
                    ]);
                    die;
                } elseif ($request->type == 'child') {
                    $pl = new UnplanDownTime();
                    $pl->jenis_downtime = $request->jenis_downtime;
                    $pl->desc = $request->desc;
                    $pl->parent_id = $request->id_sub;
                    $pl->save();

                    echo json_encode([
                        'msg' => 'sukses',
                        'desc' => 'New Child Unplan Downtime has beed added!',
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
                    UnplanDownTime::where('id', $request->id_sub)->orWhere('parent_id', $request->id_sub)->delete();
                    echo json_encode([
                        'msg' => 'sukses',
                        'desc' => 'Parent Unplan Downtimes has been deleted!',
                    ]);
                    die;
                } elseif ($request->type == 'child_2') {
                    UnplanDownTime::where('id', $request->id_sub)->delete();
                    echo json_encode([
                        'msg' => 'sukses',
                        'desc' => 'Child Unplan Downtimes has been deleted!',
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
                $pl = UnplanDownTime::find($request->id_sub);
                $pl->jenis_downtime = $request->jenis_downtime;
                $pl->desc = $request->desc;
                $pl->update();

                echo json_encode([
                    'msg' => 'sukses',
                    'desc' => 'Unplan Downtime has beed updated!',
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
    public function show(UnplanDownTime $unplan)
    {
        echo json_encode($unplan);
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
