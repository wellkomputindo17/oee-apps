<?php

namespace App\Http\Controllers\Master;

use App\Models\Mesin;
use App\Models\NotifMesin;
use Illuminate\Http\Request;
use App\Models\ScheduleMesin;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;

class ScheduleMesinController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $sm = ScheduleMesin::with('mesin')->orderBy('id', 'DESC')->select('*');
            return DataTables::of($sm)
                ->addColumn('action', function ($sm) {
                    return view('datatable-modal._action_modal', [
                        'row_id' => $sm->id,
                        'name'  => $sm->name,
                        'edit_url' => route('sm.store'),
                        'delete_url' => route('sm.destroy', $sm->id),
                    ]);
                })
                ->editColumn('updated_at', function ($sm) {
                    return !empty($sm->updated_at) ? date("Y-m-d H:i", strtotime($sm->updated_at)) : "-";
                })
                ->rawColumns(['action', 'updated_at'])
                ->addIndexColumn()
                ->make(true);
        }

        $title = 'Maintenance Schedule Machine';
        $notif = NotifMesin::where('status', 'pending')->orWhere('status', 'perbaikan')->get();

        return view('master.sm.index', compact('title', 'notif'));
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

            $validator = Validator::make($request->all(), [
                'mesin_id' => 'required',
                'desc'      => 'nullable',
                'start'     => 'required',
                'stop'     => 'required'
            ]);

            if ($validator->fails()) {
                return response()->json(
                    [
                        'msg' => 'error',
                        'desc' => $validator->messages()->first(),
                    ],
                );
            }

            if ($request->id == 0) {
                $sm = new ScheduleMesin();
                $sm->mesin_id = $request->mesin_id;
                $sm->desc = $request->desc;
                $sm->start = !empty($request->start) ? date('Y-m-d H:i', strtotime($request->start)) : null;
                $sm->stop = !empty($request->stop) ? date('Y-m-d H:i', strtotime($request->stop)) : null;
                $sm->save();

                return response()->json(
                    [
                        'msg' => 'sukses',
                        'desc' => 'The Maintenance Schedule Machine Data has been added!',
                        'data' => $sm
                    ],
                );
            } else {
                $sm = ScheduleMesin::find($request->id);
                $sm->mesin_id = $request->mesin_id;
                $sm->desc = $request->desc;
                $sm->start = !empty($request->start) ? date('Y-m-d H:i', strtotime($request->start)) : null;
                $sm->stop = !empty($request->stop) ? date('Y-m-d H:i', strtotime($request->stop)) : null;
                $sm->update();

                return response()->json(
                    [
                        'msg' => 'sukses',
                        'desc' => 'The Maintenance Schedule Machine Data has been updated!',
                        'data' => $sm
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
    public function show(string $id)
    {
        $sm = ScheduleMesin::with('mesin')->where('id', $id)->first();
        return response()->json($sm);
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
    public function destroy(ScheduleMesin $sm)
    {
        $sm->delete();
        return to_route('sm.index')->with('success', 'Maintenance Schedule Machine has been deleted!');
    }
}
