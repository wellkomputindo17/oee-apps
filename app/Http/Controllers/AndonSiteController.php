<?php

namespace App\Http\Controllers;

use App\Events\SiteRealTimeEvent;
use App\Helpers\CodeNumbering;
use App\Models\AndonSite;
use App\Models\AndonSiteHistory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;

class AndonSiteController extends Controller
{
    public function history_site(Request $request)
    {
        $history = AndonSiteHistory::select('andon_site_histories.*')->whereBetween('created_at',  [now()->startOfDay(), now()->endOfDay()])->orderBy('id', 'DESC')->get()->unique('production_no');

        return response()->json([
            'data'   => $history,
        ]);
    }
    public function real_time(Request $request)
    {
        $nama_line = $request->nama_line;
        $nama_mesin = $request->nama_mesin;
        $operator = $request->operator;
        $part_no = $request->part_no;
        $target = $request->target;
        $actual = $request->actual;
        $cycle_time = $request->cycle_time;
        $ng = $request->ng;
        $status = $request->status;
        $time = $request->time;
        $kode_page = $request->kode_page;

        $validator = Validator::make($request->all(), [
            'nama_line'     => 'required',
            'nama_mesin'       => 'required',
            'operator'     => 'required',
            'part_no'     => 'required',
            'status'     => 'required',
            'time'     => 'required',
            'kode_page'     => 'required',
            'target'        => 'required|numeric',
            'actual'        => 'required|numeric',
            'cycle_time'        => 'required',
            'ng'        => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), Response::HTTP_BAD_REQUEST);
        }

        DB::beginTransaction();
        try {
            $site = AndonSite::where('kode_page', $kode_page)->where('nama_line', $nama_line)->where('nama_mesin', $nama_mesin)->first();

            if ($status == 'running' || $status == 'down' || $status == 'standby' || $status == 'maintenance' || $status == 'preparing' || $status == 'standby') {
                if (empty($site)) {
                    $site = new AndonSite();
                    $production_no = CodeNumbering::custom_code($site, 'production_no');
                    $site->production_no = $production_no;
                    $site->kode_page = $kode_page;
                    $site->nama_line = $nama_line;
                    $site->nama_mesin = $nama_mesin;
                    $site->operator = $operator;
                    $site->part_no = $part_no;
                    $site->status = $status;
                    $site->time = $time;
                    $site->target = $target;
                    $site->actual = $actual;
                    $site->cycle_time = $cycle_time;
                    $site->ng = $ng;
                    $site->save();
                } else {
                    $site->kode_page = $kode_page;
                    $site->nama_line = $nama_line;
                    $site->nama_mesin = $nama_mesin;
                    $site->operator = $operator;
                    $site->part_no = $part_no;
                    $site->status = $status;
                    $site->time = $time;
                    $site->target = $target;
                    $site->actual = $actual;
                    $site->cycle_time = $cycle_time;
                    $site->ng = $ng;
                    $site->update();
                }

                $history  = new AndonSiteHistory();
                if (empty($site)) {
                    $history->production_no = $production_no;
                } else {
                    $history->production_no = $site->production_no;
                }
                $history->nama_line = $nama_line;
                $history->kode_page = $kode_page;
                $history->nama_mesin = $nama_mesin;
                $history->operator = $operator;
                $history->part_no = $part_no;
                $history->status = $status;
                $history->time = $time;
                $history->target = $target;
                $history->actual = $actual;
                $history->cycle_time = $cycle_time;
                $history->ng = $ng;
                $history->save();

                DB::commit();

                SiteRealTimeEvent::dispatch($site);

                return response()->json([
                    'message'   => 'Sukses',
                    'data'      => $site
                ], 200);
            } else {
                DB::rollback();

                return response()->json([
                    'message'   => "Error, status tidak ditemukan!",
                ], 422);
            }
        } catch (QueryException $th) {
            DB::rollback();

            return response()->json([
                'message'   => $th->getMessage(),
            ], 422);
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json([
                'message'   => $th->getMessage(),
            ], 422);
        }
    }
}
