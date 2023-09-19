<?php

namespace App\Http\Controllers\Master;

use App\Models\NotifMesin;
use App\Models\QualityLoss;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class QualityLossesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = "Quality Loss";
        $data = DB::table('quality_losses')->get();

        $data = $this->buildtree($data);

        $data = json_decode(json_encode($data), FALSE);

        $notif = NotifMesin::where('status', 'pending')->orWhere('status', 'perbaikan')->get();
        return view('master.quality_loss.index', compact('title', 'data', 'notif'));
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
                    'jenis_qualityloss'      => 'required',
                ], [
                    'jenis_qualityloss'  => 'The type quality loss field is required!'
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
                    $pl = new QualityLoss();
                    $pl->jenis_qualityloss = $request->jenis_qualityloss;
                    $pl->desc = $request->desc;
                    $pl->save();

                    echo json_encode([
                        'msg' => 'sukses',
                        'desc' => 'New Parent Quality Loss has beed added!',
                        'data' => $pl
                    ]);
                    die;
                } elseif ($request->type == 'child') {
                    $pl = new QualityLoss();
                    $pl->jenis_qualityloss = $request->jenis_qualityloss;
                    $pl->desc = $request->desc;
                    $pl->parent_id = $request->id_sub;
                    $pl->save();

                    echo json_encode([
                        'msg' => 'sukses',
                        'desc' => 'New Child Quality Loss has beed added!',
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
                    QualityLoss::where('id', $request->id_sub)->orWhere('parent_id', $request->id_sub)->delete();
                    echo json_encode([
                        'msg' => 'sukses',
                        'desc' => 'Parent Quality Losss has been deleted!',
                    ]);
                    die;
                } elseif ($request->type == 'child_2') {
                    QualityLoss::where('id', $request->id_sub)->delete();
                    echo json_encode([
                        'msg' => 'sukses',
                        'desc' => 'Child Quality Losss has been deleted!',
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
                $pl = QualityLoss::find($request->id_sub);
                $pl->jenis_qualityloss = $request->jenis_qualityloss;
                $pl->desc = $request->desc;
                $pl->update();

                echo json_encode([
                    'msg' => 'sukses',
                    'desc' => 'Quality Loss has beed updated!',
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
    public function show(QualityLoss $quality_loss)
    {
        echo json_encode($quality_loss);
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
