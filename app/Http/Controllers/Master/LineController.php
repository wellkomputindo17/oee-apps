<?php

namespace App\Http\Controllers\Master;

use App\Models\Line;
use App\Models\NotifMesin;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class LineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $line = Line::orderBy('id', 'DESC')->select('*');
            return DataTables::of($line)
                ->addColumn('action', function ($line) {
                    return view('datatable-modal._action_modal', [
                        'row_id' => $line->id,
                        'name' => $line->name,
                        'edit_url' => route('line.store'),
                        'delete_url' => route('line.destroy', $line->id),
                    ]);
                })
                ->editColumn('updated_at', function ($line) {
                    return !empty($line->updated_at) ? date("d-m-Y H:i", strtotime($line->updated_at)) : "-";
                })
                ->rawColumns(['action', 'updated_at'])
                ->addIndexColumn()
                ->make(true);
        }

        $title = 'Line';
        $notif = NotifMesin::where('status', 'pending')->get();
        return view('master.line.index', compact('title', 'notif'));
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
        $validator = Validator::make($request->all(), [
            'name'      => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    'msg' => 'error',
                    'desc' => $validator->messages()->first(),
                ]
            );
        }

        if ($request->id == 0) {
            $cek_line = Line::where('name', $request->name)->first();
            if ($cek_line) {
                echo json_encode([
                    'msg' => 'error',
                    'desc' => 'Line is available!',
                ]);
                die;
            }
            $line = new Line();
            $line->name = $request->name;
            $line->save();
            echo json_encode([
                'msg' => 'sukses',
                'desc' => 'New line has beed added!',
                'data' => $line
            ]);
            die;
        } else {
            $line = Line::find($request->id);
            $line->name = $request->name;
            $line->update();

            echo json_encode([
                'msg' => 'sukses',
                'desc' => 'Line has beed updated!',
                'data' => $line
            ]);
            die;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $line = Line::find($id);

        echo json_encode($line);
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
    public function destroy(Line $line)
    {
        $line->delete();
        return to_route('line.index')->with('success', 'Line has been deleted!');
    }
}
