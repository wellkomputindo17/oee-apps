<?php

namespace App\Http\Controllers\Master;

use App\Models\Mesin;
use App\Models\NotifMesin;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;

class MesinController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $mesin = Mesin::orderBy('id', 'DESC')->select('*');
            return DataTables::of($mesin)
                ->addColumn('action', function ($mesin) {
                    return view('datatable-modal._action', [
                        'row_id' => $mesin->id,
                        'edit_url' => route('mesin.edit', $mesin->id),
                        'delete_url' => route('mesin.destroy', $mesin->id),
                    ]);
                })
                ->editColumn('updated_at', function ($mesin) {
                    return !empty($mesin->updated_at) ? date("d-m-Y H:i", strtotime($mesin->updated_at)) : "-";
                })
                ->rawColumns(['action', 'updated_at'])
                ->addIndexColumn()
                ->make(true);
        }

        $title = 'Machine';
        $notif = NotifMesin::where('status', 'pending')->orWhere('status', 'perbaikan')->get();
        return view('master.mesin.index', compact('title', 'notif'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Machine';
        return view('master.mesin.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'no_mesin' => 'required|max:20|unique:mesin,no_mesin',
            'name'     => 'required',
        ]);

        $ms = new Mesin();
        $ms->no_mesin = $request->no_mesin;
        $ms->name = $request->name;
        $ms->year = $request->year;
        $ms->type = $request->type;
        $ms->origin = $request->origin;
        $ms->save();

        return to_route('mesin.index')->with('success', 'New machine has been added!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Mesin $mesin)
    {
        $title = 'Machine';
        return view('master.mesin.edit', compact('title', 'mesin'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'no_mesin' => 'required|max:20|unique:mesin,no_mesin,' . $id,
            'name'     => 'required',
        ]);

        $ms = Mesin::find($id);
        $ms->no_mesin = $request->no_mesin;
        $ms->name = $request->name;
        $ms->year = $request->year;
        $ms->type = $request->type;
        $ms->origin = $request->origin;
        $ms->update();

        return to_route('mesin.index')->with('success', 'Machine has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mesin $mesin)
    {
        $mesin->delete();

        return to_route('mesin.index')->with('success', 'Machine has been deleted!');
    }
}
