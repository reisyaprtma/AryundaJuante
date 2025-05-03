<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pekerjaan;
use App\Models\RiwayatStatusHistory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PekerjaanController extends Controller
{
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string',
        ]);

        $pekerjaan = Pekerjaan::findOrFail($id);

        $oldStatus = $pekerjaan->status;
        $pekerjaan->status = $request->status;
        $pekerjaan->save();

        // Bikin notifikasi setelah update
        DB::table('notifikasi')->insert([
            'job_id' => $pekerjaan->id,
            'user_id' => Auth::id(),
            'message' =>  Auth::user()->name .
                         ' memperbarui status pekerjaan "' . $pekerjaan->nama .
                         '" dari "' . $oldStatus . '" menjadi "' . $request->status . '"',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('riwayat_status_pekerjaan')->insert([
            'job_id' => $pekerjaan->id,
            'status' => $request->status,
            'created_at' => now(),
            'updated_by' => Auth::id(),
        ]);

        return back()->with('success', 'Status pekerjaan berhasil diperbarui.');
    }

    public function showHistory($id)
    {
        $pekerjaan = Pekerjaan::findOrFail($id);
        $histories = DB::table('riwayat_status_pekerjaan')
                    ->join('users', 'users.id', '=', 'riwayat_status_pekerjaan.updated_by')
                    ->where('job_id', $id)
                    ->select('riwayat_status_pekerjaan.*', 'users.name as user_name')
                    ->orderBy('created_at', 'desc')
                    ->get();

        return view('laravel-examples.job-history', compact('pekerjaan', 'histories'));
    }
}
