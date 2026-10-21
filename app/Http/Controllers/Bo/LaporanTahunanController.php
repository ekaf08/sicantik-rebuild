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

        if (!collect($fields)->contains(fn ($f) => $request->hasFile($f))) {
            return back()->withInput()->withErrors(['file' => 'Unggah minimal satu file laporan.']);
        }

        $user = auth()->user();

        $sudahAda = LapTahunan::where('jenis_laporan', $jenis)
            ->where('tahun_periode', $request->tahun_periode)
            ->where('id_kecamatan', $user->id_kecamatan)
            ->where('id_kelurahan', $user->id_kelurahan)
            ->exists();

        if ($sudahAda) {
            return back()->withInput()->withErrors([
                'tahun_periode' => 'Laporan untuk jenis, tahun, dan wilayah ini sudah ada. Gunakan menu edit.',
            ]);
        }

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
        $tersimpan = [];

        try {
            foreach ($fields as $field) {
                if ($request->hasFile($field)) {
                    $payload[$field] = $request->file($field)->store($folder, 'public');
                    $tersimpan[] = $payload[$field];
                }
            }

            LapTahunan::create($payload);
        } catch (\Throwable $e) {
            // DB gagal: buang file yang sudah terlanjur tersimpan
            Storage::disk('public')->delete($tersimpan);
            Log::error('Simpan laporan tahunan gagal: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Gagal menyimpan laporan.');
        }

        return redirect()->back()->with('success', 'Data laporan berhasil disimpan.');
    }

  public function update(Request $request, $id)
    {
        if (!Access::can('laporan-tahunan', 'update')) {
            abort(403, 'Akses Ditolak.');
        }

        $laporan = LapTahunan::filterWilayahUser(auth()->user())->findOrFail($id);
        $fields  = $laporan->fileFields();

        $request->validate(
            array_merge([
                'tahun_periode' => 'required|digits:4',
            ], $this->fileRules($fields)),
            $this->messages($fields)
        );

        if ((string) $request->tahun_periode !== (string) $laporan->tahun_periode) {
            $bentrok = LapTahunan::where('jenis_laporan', $laporan->jenis_laporan)
                ->where('tahun_periode', $request->tahun_periode)
                ->where('id_kecamatan', $laporan->id_kecamatan)
                ->where('id_kelurahan', $laporan->id_kelurahan)
                ->where($laporan->getKeyName(), '!=', $laporan->getKey())
                ->exists();

            if ($bentrok) {
                return back()->withInput()->withErrors([
                    'tahun_periode' => 'Laporan untuk tahun ini sudah ada.',
                ]);
            }
        }

        $folder   = $laporan->jenis_laporan === 'memori_pj' ? 'laporan/memori_pj' : 'laporan/tahunan';
        $payload  = ['tahun_periode' => $request->tahun_periode];
        $baru     = [];
        $lama     = [];

        try {
            foreach ($fields as $field) {
                if ($request->hasFile($field)) {
                    if ($laporan->{$field}) {
                        $lama[] = $laporan->{$field};
                    }
                    $payload[$field] = $request->file($field)->store($folder, 'public');
                    $baru[] = $payload[$field];
                }
            }

            $laporan->update($payload);
        } catch (\Throwable $e) {
            Storage::disk('public')->delete($baru);
            Log::error('Update laporan tahunan gagal: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Gagal memperbarui laporan.');
        }

        if ($lama) {
            Storage::disk('public')->delete($lama);
        }

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