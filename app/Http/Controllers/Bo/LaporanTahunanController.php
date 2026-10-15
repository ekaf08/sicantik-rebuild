<?php

namespace App\Http\Controllers\Bo;

use App\Http\Controllers\Controller;
use App\Models\LapTahunan;
use App\Support\Access;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LaporanTahunanController extends Controller
{
    public function index(Request $request)
    {
        if (!Access::can('laporan-tahunan', 'table')) {
            abort(403, 'Akses Ditolak.');
        }

        $user = auth()->user();

        $base = LapTahunan::filterWilayahUser($user);

        $tahunList = (clone $base)
            ->select('tahun_periode')
            ->distinct()
            ->orderByDesc('tahun_periode')
            ->pluck('tahun_periode');

        $dataLaporan = (clone $base)
            ->with('creator')
            ->when($request->filled('jenis'), fn ($q) => $q->where('jenis_laporan', $request->jenis))
            ->when($request->filled('tahun'), fn ($q) => $q->where('tahun_periode', $request->tahun))
            ->when($request->filled('wilayah'), fn ($q) => $q->where('level_wilayah', $request->wilayah))
            ->when($request->filled('q'), function ($q) use ($request) {
                $kw = '%' . trim($request->q) . '%';

                $q->where(function ($w) use ($kw) {
                    $w->where('tahun_periode', 'ilike', $kw)
                      ->orWhere('level_wilayah', 'ilike', $kw)
                      ->orWhereHas('creator', fn ($c) => $c->where('name', 'ilike', $kw));
                });
            })
            ->latest()
            ->get();

        return view('bo.pages.laporan.laporan-tahunan.index', compact('dataLaporan', 'tahunList'));
    }

    public function store(Request $request)
    {
        if (!Access::can('laporan-tahunan', 'create')) {
            abort(403, 'Akses Ditolak.');
        }

        $jenis  = $request->input('jenis_laporan');
        $fields = $jenis === 'memori_pj' ? LapTahunan::FILE_MEMORI : LapTahunan::FILE_TAHUNAN;

        $request->validate(
            array_merge([
                'jenis_laporan' => 'required|in:laporan_tahunan,memori_pj',
                'tahun_periode' => 'required|digits:4',
            ], $this->fileRules($fields)),
            $this->messages($fields)
        );

        $user = auth()->user();

        $levelWilayah = 'kota';
        if ($user->id_kelurahan) {
            $levelWilayah = 'kelurahan';
        } elseif ($user->id_kecamatan) {
            $levelWilayah = 'kecamatan';
        }

        $payload = [
            'jenis_laporan' => $jenis,
            'tahun_periode' => $request->tahun_periode,
            'level_wilayah' => $levelWilayah,
            'id_kecamatan'  => $user->id_kecamatan,
            'id_kelurahan'  => $user->id_kelurahan,
            'created_by'    => $user->id,
        ];

        $folder = $jenis === 'memori_pj' ? 'laporan/memori_pj' : 'laporan/tahunan';

        foreach ($fields as $field) {
            if ($request->hasFile($field)) {
                $payload[$field] = $request->file($field)->store($folder, 'public');
            }
        }

        LapTahunan::create($payload);

        return redirect()->back()->with('success', 'Data laporan berhasil disimpan.');
    }

    public function update(Request $request, $id)
    {
        if (!Access::can('laporan-tahunan', 'update')) {
            abort(403, 'Akses Ditolak.');
        }

        $laporan = LapTahunan::filterWilayahUser(auth()->user())->findOrFail($id);

        $fields = $laporan->fileFields();

        $request->validate(
            array_merge([
                'tahun_periode' => 'required|digits:4',
            ], $this->fileRules($fields)),
            $this->messages($fields)
        );

        $folder  = $laporan->jenis_laporan === 'memori_pj' ? 'laporan/memori_pj' : 'laporan/tahunan';
        $payload = ['tahun_periode' => $request->tahun_periode];

        foreach ($fields as $field) {
            if ($request->hasFile($field)) {
                if ($laporan->{$field}) {
                    Storage::disk('public')->delete($laporan->{$field});
                }
                $payload[$field] = $request->file($field)->store($folder, 'public');
            }
        }

        $laporan->update($payload);

        return redirect()->back()->with('success', 'Laporan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        if (!Access::can('laporan-tahunan', 'delete')) {
            abort(403, 'Akses Ditolak.');
        }

        $laporan = LapTahunan::filterWilayahUser(auth()->user())->findOrFail($id);
        $laporan->delete();  

        return redirect()->back()->with('success', 'Laporan berhasil dihapus.');
    }

    private function fileRules(array $fields): array
    {
        $rules = [];
        foreach ($fields as $field) {
            $rules[$field] = 'nullable|file|mimes:pdf|max:2048';
        }

        return $rules;
    }

    private function messages(array $fields): array
    {
        $messages = [];
        foreach ($fields as $field) {
            $label = ucwords(str_replace('_', ' ', preg_replace('/^file_/', '', $field)));
            $messages["$field.mimes"] = "File $label harus berformat PDF.";
            $messages["$field.max"]   = "File $label maksimal 2MB.";
            $messages["$field.uploaded"] = "File $label gagal diunggah (kemungkinan lebih dari batas server).";
        }

        return $messages;
    }
}