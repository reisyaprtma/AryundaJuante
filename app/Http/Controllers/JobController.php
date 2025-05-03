<?php

namespace App\Http\Controllers;

use App\Models\Pekerjaan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class JobController extends Controller
{
    public function edit($id)
    {
        $pekerjaan = Pekerjaan::findOrFail($id);
        $pekerjas = User::where('role', 'pekerja')->get();
        return view('laravel-examples.job-edit', compact('pekerjaan', 'pekerjas'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'no_kontak' => 'required|string|max:20',
            'deadline' => 'required|date',
            'kategori' => 'required|string|max:100',
            'client' => 'required|string|max:255',
            'ditangani_oleh' => 'nullable|exists:users,id',
            'total' => 'required|numeric',
            'tanggal_tagihan' => 'required|date',
            'deskripsi' => 'nullable|string',
            'url_dokumen' => 'nullable|file|mimes:pdf,doc,docx|max:10240'
        ]);

        $pekerjaan = Pekerjaan::findOrFail($id);

        $data = $request->except('url_dokumen');

        if ($request->hasFile('url_dokumen')) {
            // Delete old document if exists
            if ($pekerjaan->url_dokumen) {
                Storage::delete('public/documents/' . $pekerjaan->url_dokumen);
            }

            $document = $request->file('url_dokumen');
            $documentName = time() . '_' . $document->getClientOriginalName();
            $document->storeAs('public/documents', $documentName);
            $data['url_dokumen'] = $documentName;
        }

        $pekerjaan->update($data);

        return redirect()->route('admin.job-detail', $pekerjaan->id)
            ->with('success', 'Pekerjaan berhasil diperbarui');
    }

    public function destroy($id)
    {
        $pekerjaan = Pekerjaan::findOrFail($id);

        // Delete the associated document if it exists
        if ($pekerjaan->url_dokumen) {
            Storage::delete('public/documents/' . $pekerjaan->url_dokumen);
        }

        $pekerjaan->delete();

        return redirect()->route('admin.jobs-management')
            ->with('success', 'Pekerjaan berhasil dihapus');
    }
}
