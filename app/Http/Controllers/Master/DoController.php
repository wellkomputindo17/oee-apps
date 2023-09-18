<?php

namespace App\Http\Controllers\Master;

use App\Models\DoModel;
use App\Models\NotifMesin;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Helpers\CodeNumbering;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;

class DoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $do = DoModel::orderBy('id', 'DESC')->select('*');
            return DataTables::of($do)
                ->addColumn('action', function ($do) {
                    return view('datatable-modal._action_modal', [
                        'row_id' => $do->id,
                        'name'  => $do->name,
                        'edit_url' => route('do.store'),
                        'delete_url' => route('do.destroy', $do->id),
                    ]);
                })
                ->editColumn('updated_at', function ($do) {
                    return !empty($do->updated_at) ? date("d-m-Y H:i", strtotime($do->updated_at)) : "-";
                })
                ->editColumn('target', function ($do) {
                    return number_format($do->target, 0, ",", ".");
                })
                ->editColumn('actual', function ($do) {
                    return number_format($do->actual, 0, ",", ".");
                })
                ->rawColumns(['action', 'updated_at', 'target', 'actual'])
                ->addIndexColumn()
                ->make(true);
        }

        $title = 'DO';
        $notif = NotifMesin::where('status', 'pending')->get();
        return view('master.do.index', compact('title', 'notif'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $rules = [
                'name'      => 'required',
                'target'    => 'nullable|numeric'
            ];

            if ($request->id == 0) {
                $rules['no_do'] = 'required|unique:do,no_do';
            } else {
                $rules['no_do'] = 'required|unique:do,no_do,' . $request->id;
            }

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json(
                    [
                        'msg' => 'error',
                        'desc' => $validator->messages()->first(),
                    ],
                );
            }

            if ($request->id == 0) {
                $do = new DoModel();
                $do->no_do = CodeNumbering::custom_code_do($do, 'no_do');
                $do->name = $request->name;
                $do->target = !empty($request->target) ? str_replace(".", "", $request->target) : null;
                $do->type = $request->type;
                $do->save();

                return response()->json(
                    [
                        'msg' => 'sukses',
                        'desc' => 'The DO Data has been added!',
                        'data' => $do
                    ],
                );
            } else {
                $do = DoModel::find($request->id);
                $do->name = $request->name;
                $do->target = !empty($request->target) ? str_replace(".", "", $request->target) : null;
                $do->type = $request->type;
                $do->update();

                return response()->json(
                    [
                        'msg' => 'sukses',
                        'desc' => 'The DO Data has been updated!',
                        'data' => $do
                    ],
                );
            }
        } catch (QueryException $th) {
            return response()->json(
                [
                    'msg' => 'error',
                    'desc' => $th->getMessage(),
                ],
            );
        } catch (\Throwable $th) {
            return response()->json(
                [
                    'msg' => 'error',
                    'desc' => $th->getMessage(),
                ],
            );
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(DoModel $do)
    {
        return response()->json($do);
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
    public function destroy(DoModel $do)
    {
        $do->delete();
        return to_route('do.index')->with('success', 'DO has been deleted!');
    }
}
