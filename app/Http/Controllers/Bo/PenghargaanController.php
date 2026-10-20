<?php

namespace App\Http\Controllers\Bo;

use App\Http\Controllers\Controller;
use App\Models\Penghargaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PenghargaanController extends Controller
{
    /**
     * Tampilkan halaman utama Penghargaan beserta data pendukung dropdown
     */
    public function index(Request $request)
    {
        try {
            $kecamatan = DB::table('m_kecamatan')->get();
            $kelurahan = DB::table('m_kelurahan')->get();

            $query = Penghargaan::query();

            if ($request->filled('kecamatan_id')) {
                $query->where('kecamatan_id', $request->kecamatan_id);
            }
            if ($request->filled('kelurahan_id')) {
                $query->where('kelurahan_id', $request->kelurahan_id);
            }
            if ($request->filled('tahun')) {
                $query->where('tahun', $request->tahun);
            }

            $penghargaan = $query->orderBy('created_at', 'desc')->get();

            return view('bo.pages.penghargaan.penghargaan', compact('penghargaan', 'kecamatan', 'kelurahan'));
        } catch (\Exception $e) {
            $kecamatan = collect();
            $kelurahan = collect();
            $penghargaan = collect();

            return view('bo.pages.penghargaan.penghargaan', compact('penghargaan', 'kecamatan', 'kelurahan'));
        }
    }

    /**
     * Ambil data Kelurahan via AJAX berdasarkan Kecamatan ID
     */
    public function getKelurahan(int $kecamatan_id)
    {
        $kelurahan = DB::table('m_kelurahan')
            ->where('kecamatan_id', $kecamatan_id)
            ->orWhere('id_kec', $kecamatan_id)
            ->orWhere('id_kecamatan', $kecamatan_id)
            ->get();

        return response()->json($kelurahan);
    }

    /**
     * Simpan Data Penghargaan baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_penghargaan'      => 'required|string|max:255',
            'deskripsi_penghargaan' => 'required|string',
            'kategori_penghargaan'  => 'required|string|max:255',
            'tahun'                 => 'required|string|max:4',
            'kecamatan_id'          => 'required',
            'kelurahan_id'          => 'required',
            'foto'                  => 'required|file|mimes:jpg,jpeg,png|max:2048',
            'file'                  => 'required|file|mimes:pdf,doc,docx|max:2048',
        ], [
            'kecamatan_id.required' => 'Kecamatan wajib dipilih!',
            'kelurahan_id.required' => 'Kelurahan wajib dipilih!',
            'foto.mimes' => 'Format foto harus berupa JPG, JPEG, atau PNG!',
            'foto.max'   => 'Ukuran foto maksimal 2MB!',
            'file.mimes' => 'Format file dokumen harus berupa PDF, DOC, atau DOCX!',
            'file.max'   => 'Ukuran file dokumen maksimal 2MB!',
        ]);

        try {
            $fotoPath = $request->file('foto')->store('penghargaan/foto', 'public');
            $filePath = $request->file('file')->store('penghargaan/file', 'public');

            // forceFill supaya kolom wilayah ikut tersimpan walau belum ada di $fillable model
            $item = new Penghargaan();
            $item->forceFill([
                'nama_penghargaan'      => $request->nama_penghargaan,
                'deskripsi_penghargaan' => $request->deskripsi_penghargaan,
                'kategori_penghargaan'  => $request->kategori_penghargaan,
                'tahun'                 => $request->tahun,
                'kecamatan_id'          => $request->kecamatan_id,
                'kelurahan_id'          => $request->kelurahan_id,
                'foto'                  => $fotoPath,
                'file'                  => $filePath,
                'created_by'            => 'Admin Kominfo',
            ])->save();

            return redirect()->back()->with('success_store', true);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }

    /**
     * Update Data Penghargaan
     */
    public function update(Request $request, int $id)
    {
        $request->validate([
            'nama_penghargaan'      => 'required|string|max:255',
            'deskripsi_penghargaan' => 'required|string',
            'kategori_penghargaan'  => 'required|string|max:255',
            'tahun'                 => 'required|string|max:4',
            'foto'                  => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
            'file'                  => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ], [
            'foto.mimes' => 'Format foto harus berupa JPG, JPEG, atau PNG!',
            'foto.max'   => 'Ukuran foto maksimal 2MB!',
            'file.mimes' => 'Format file dokumen harus berupa PDF, DOC, atau DOCX!',
            'file.max'   => 'Ukuran file dokumen maksimal 2MB!',
        ]);

        try {
            $penghargaan = Penghargaan::findOrFail($id);

            $data = [
                'nama_penghargaan'      => $request->nama_penghargaan,
                'deskripsi_penghargaan' => $request->deskripsi_penghargaan,
                'kategori_penghargaan'  => $request->kategori_penghargaan,
                'tahun'                 => $request->tahun,
            ];

            if ($request->filled('kecamatan_id') && $request->filled('kelurahan_id')) {
                $data['kecamatan_id'] = $request->kecamatan_id;
                $data['kelurahan_id'] = $request->kelurahan_id;
            }

            if ($request->hasFile('foto')) {
                if ($penghargaan->foto && Storage::disk('public')->exists($penghargaan->foto)) {
                    Storage::disk('public')->delete($penghargaan->foto);
                }
                $data['foto'] = $request->file('foto')->store('penghargaan/foto', 'public');
            }

            if ($request->hasFile('file')) {
                if ($penghargaan->file && Storage::disk('public')->exists($penghargaan->file)) {
                    Storage::disk('public')->delete($penghargaan->file);
                }
                $data['file'] = $request->file('file')->store('penghargaan/file', 'public');
            }

            $penghargaan->forceFill($data)->save();

            return redirect()->back()->with('success_update', true);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memperbarui data: ' . $e->getMessage());
        }
    }

    /**
     * Hapus Data Penghargaan
     */
    public function destroy(int $id)
    {
        try {
            $penghargaan = Penghargaan::find($id);
            $nama = $penghargaan->nama_penghargaan ?? 'Data';

            if ($penghargaan) {
                if ($penghargaan->foto && Storage::disk('public')->exists($penghargaan->foto)) {
                    Storage::disk('public')->delete($penghargaan->foto);
                }
                if ($penghargaan->file && Storage::disk('public')->exists($penghargaan->file)) {
                    Storage::disk('public')->delete($penghargaan->file);
                }
                $penghargaan->delete();
            }

            return redirect()->back()->with('success_delete', $nama . ' berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
}
