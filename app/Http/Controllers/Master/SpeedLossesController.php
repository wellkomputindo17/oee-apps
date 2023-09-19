<?php

namespace App\Http\Controllers\Master;

use App\Models\SpeedLoss;
use App\Models\NotifMesin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class SpeedLossesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = "Speed Loss";
        $data = DB::table('speed_losses')->get();

        $data = $this->buildtree($data);

        $data = json_decode(json_encode($data), FALSE);

        $notif = NotifMesin::where('status', 'pending')->orWhere('status', 'perbaikan')->get();
        return view('master.speed_loss.index', compact('title', 'data', 'notif'));
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
                    'jenis_speedloss'      => 'required',
                ], [
                    'jenis_speedloss'  => 'The type speedloss field is required!'
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
                    $pl = new SpeedLoss();
                    $pl->jenis_speedloss = $request->jenis_speedloss;
                    $pl->desc = $request->desc;
                    $pl->save();

                    echo json_encode([
                        'msg' => 'sukses',
                        'desc' => 'New Parent Speed Loss has beed added!',
                        'data' => $pl
                    ]);
                    die;
                } elseif ($request->type == 'child') {
                    $pl = new SpeedLoss();
                    $pl->jenis_speedloss = $request->jenis_speedloss;
                    $pl->desc = $request->desc;
                    $pl->parent_id = $request->id_sub;
                    $pl->save();

                    echo json_encode([
                        'msg' => 'sukses',
                        'desc' => 'New Child Speed Loss has beed added!',
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
                    SpeedLoss::where('id', $request->id_sub)->orWhere('parent_id', $request->id_sub)->delete();
                    echo json_encode([
                        'msg' => 'sukses',
                        'desc' => 'Parent Speed Losss has been deleted!',
                    ]);
                    die;
                } elseif ($request->type == 'child_2') {
                    SpeedLoss::where('id', $request->id_sub)->delete();
                    echo json_encode([
                        'msg' => 'sukses',
                        'desc' => 'Child Speed Losss has been deleted!',
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
                $pl = SpeedLoss::find($request->id_sub);
                $pl->jenis_speedloss = $request->jenis_speedloss;
                $pl->desc = $request->desc;
                $pl->update();

                echo json_encode([
                    'msg' => 'sukses',
                    'desc' => 'Speed Loss has beed updated!',
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
    public function show(SpeedLoss $speed_loss)
    {
        echo json_encode($speed_loss);
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
