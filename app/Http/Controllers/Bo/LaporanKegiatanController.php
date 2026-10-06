<?php

namespace App\Http\Controllers\Bo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;

class LaporanKegiatanController extends Controller
{
    private const T = 't_laporan_kegiatan';

    // field form => [kolom database, folder simpan di public/]
    private const FILES = [
        'foto_1'        => ['laporan_kegiatan_foto',   'uploads/foto-kegiatan'],
        'foto_2'        => ['laporan_kegiatan_foto_2', 'uploads/foto-kegiatan'],
        'foto_3'        => ['laporan_kegiatan_foto_3', 'uploads/foto-kegiatan'],
        'file_absensi'  => ['file_absen',              'uploads/dokumen-kegiatan'],
        'file_undangan' => ['file_undangan',           'uploads/dokumen-kegiatan'],
        'file_notulen'  => ['file_notulen',            'uploads/dokumen-kegiatan'],
    ];

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = DB::table(self::T . ' as l')
                ->leftJoin('m_kegiatan as k', 'k.kegiatan_id', '=', 'l.kegiatan_id')
                ->leftJoin('m_sub_kegiatan as s', 's.sub_kegiatan_id', '=', 'l.sub_kegiatan_id')
                ->whereNull('l.deleted_at')
                ->select([
                    'l.laporan_kegiatan_id', 'l.laporan_kegiatan_tanggal', 'l.laporan_kegiatan_tampat',
                    'l.laporan_kegiatan_deskripsi', 'l.laporan_kegiatan_foto', 'l.laporan_kegiatan_foto_2',
                    'l.laporan_kegiatan_foto_3', 'l.file_absen', 'l.file_undangan', 'l.file_notulen',
                    'l.laporan_kegiatan_sub', 'l.created_by',
                    'k.kegiatan_nama', 's.sub_kegiatan_nama',
                ])
                ->when($request->jenis, fn ($q, $v) => $q->where('l.kegiatan_id', $v))
                ->when($request->sub, fn ($q, $v) => $q->where('l.sub_kegiatan_id', $v))
                ->when($request->bulan, function ($q, $v) {
                    [$y, $m] = explode('-', $v);
                    $q->whereYear('l.laporan_kegiatan_tanggal', $y)->whereMonth('l.laporan_kegiatan_tanggal', $m);
                })
                ->orderByDesc('l.laporan_kegiatan_tanggal')
                ->orderByDesc('l.laporan_kegiatan_id');

            return DataTables::of($query)
                ->addIndexColumn()
                ->filter(function ($q) use ($request) {
                    if ($s = $request->input('search.value')) {
                        $q->where(function ($w) use ($s) {
                            $w->where('l.laporan_kegiatan_tampat', 'ilike', "%$s%")
                              ->orWhere('l.laporan_kegiatan_deskripsi', 'ilike', "%$s%")
                              ->orWhere('s.sub_kegiatan_nama', 'ilike', "%$s%");
                        });
                    }
                })
                ->addColumn('tanggal_fmt', fn ($r) => Carbon::parse($r->laporan_kegiatan_tanggal)->format('d-m-Y'))
                ->addColumn('jenis', fn ($r) => $r->kegiatan_nama ?: '-')
                ->addColumn('sub', fn ($r) => $r->sub_kegiatan_nama ?: '-')
                ->addColumn('tempat', fn ($r) => $r->laporan_kegiatan_tampat ?: '-')
                ->addColumn('deskripsi_short', fn ($r) => Str::limit($r->laporan_kegiatan_deskripsi, 70) ?: '-')
                ->addColumn('jumlah_file', function ($r) {
                    $n = collect([$r->file_absen, $r->file_undangan, $r->file_notulen])->filter()->count();
                    return $n ? $n . ' file' : '-';
                })
                ->addColumn('foto_thumb', function ($r) {
                    $html = '';
                    foreach ([$r->laporan_kegiatan_foto, $r->laporan_kegiatan_foto_2, $r->laporan_kegiatan_foto_3] as $f) {
                        if ($f) {
                            $html .= '<img class="thumb-img mb-1" src="' . e(asset($f)) . '">';
                        }
                    }
                    return $html ?: '-';
                })
                // ASUMSI: Keterangan = Pokja (dari kolom laporan_kegiatan_sub)
                ->addColumn('keterangan', function ($r) {
                    $p = $this->pokjaNum($r->laporan_kegiatan_sub);
                    return $p === '5' ? 'SEKRETARIS' : ($p ? 'POKJA' . $p : '-');
                })
                // Sementara tampil ID user; nanti diganti nama user kalau tabel user sudah diketahui
                ->addColumn('oleh', fn ($r) => $r->created_by ? 'User #' . $r->created_by : '-')
                ->addColumn('action', function ($r) {
                    $enc  = Crypt::encryptString($r->laporan_kegiatan_id);
                    $show = e(route('laporan-kegiatan.show', $enc));
                    $del  = e(route('laporan-kegiatan.destroy', $enc));
                    return '<div style="white-space:nowrap">'
                        . '<button type="button" class="abtn view btn-lihat" data-show="' . $show . '">Lihat</button> '
                        . '<button type="button" class="abtn edit btn-edit" data-show="' . $show . '">Edit</button> '
                        . '<button type="button" class="abtn del btn-hapus" data-url="' . $del . '">Hapus</button>'
                        . '</div>';
                })
                ->rawColumns(['foto_thumb', 'action'])
                ->make(true);
        }

        $kegiatan = DB::table('m_kegiatan')
            ->where('kegiatan_status', true)->whereNull('deleted_at')
            ->orderBy('kegiatan_id')->get();

        return view('bo.pages.laporan.laporan-kegiatan.index', compact('kegiatan'));
    }

    // Dropdown sub kegiatan.
    // {kegiatan} = id jenis kegiatan, atau "semua". Opsional ?pokja=1..4 (dipakai di form)
    public function subKegiatan(Request $request, $kegiatanId)
    {
        return DB::table('m_sub_kegiatan')
            ->when($kegiatanId !== 'semua', fn ($q) => $q->where('kegiatan_id', $kegiatanId))
            ->when($request->pokja, fn ($q, $v) => $q->where(function ($w) use ($v) {
                $w->where('pokja', $v)->orWhereNull('pokja');
            }))
            ->where('sub_kegiatan_status', true)
            ->whereNull('deleted_at')
            ->orderBy('sub_kegiatan_id')
            ->get(['sub_kegiatan_id', 'sub_kegiatan_nama']);
    }

    public function store(Request $request)
    {
        $request->validate(array_merge($this->rules(), [
            // laporan hanya boleh dibuat H sampai H+7
            'tanggal' => 'required|date|before_or_equal:today|after_or_equal:' . now()->subDays(7)->toDateString(),
        ]));

        $data = $this->mapData($request);
        $data['created_at'] = now();
        $data['updated_at'] = now();
        $data['created_by'] = Auth::id();

        foreach (self::FILES as $field => [$kolom, $dir]) {
            if ($field === 'file_notulen' && $request->notulen !== '1') { continue; }
            if ($request->hasFile($field)) {
                $data[$kolom] = $this->simpanFile($request->file($field), $dir);
            }
        }

        DB::table(self::T)->insert($data);

        return response()->json(['status' => 'success', 'message' => 'Laporan kegiatan berhasil ditambahkan!']);
    }

    public function show(string $encryptedId)
    {
        $r = $this->find($encryptedId);
        if (!$r) {
            return response()->json(['status' => 'error', 'message' => 'Data tidak valid!'], 404);
        }

        $adaNotulen = ($r->nama_notulen || $r->file_notulen) ? true : null;

        $data = [
            'tanggal'         => Carbon::parse($r->laporan_kegiatan_tanggal)->format('Y-m-d'),
            'pokja'           => $this->pokjaNum($r->laporan_kegiatan_sub),
            'kegiatan_id'     => $r->kegiatan_id,
            'sub_kegiatan_id' => $r->sub_kegiatan_id,
            'tempat'          => $r->laporan_kegiatan_tampat,
            'jam'             => $r->laporan_kegiatan_jam ? substr($r->laporan_kegiatan_jam, 0, 5) : '',
            'notulen'         => $adaNotulen,
            'nama_notulen'    => $r->nama_notulen,
            'deskripsi'       => $r->laporan_kegiatan_deskripsi,
        ];
        foreach (self::FILES as $field => [$kolom, $dir]) {
            $data[$field . '_url'] = $r->$kolom ? asset($r->$kolom) : null;
        }

        return response()->json([
            'status'     => 'success',
            'data'       => $data,
            'update_url' => route('laporan-kegiatan.update', $encryptedId),
        ]);
    }

    public function update(Request $request, $encryptedId)
    {
        $r = $this->find($encryptedId);
        if (!$r) {
            return response()->json(['status' => 'error', 'message' => 'Data tidak valid!'], 404);
        }

        $request->validate($this->rules());

        $data = $this->mapData($request);
        $data['updated_at'] = now();
        $data['updated_by'] = Auth::id();

        // kalau notulen diubah jadi "Tidak Ada", hapus file notulen lama
        if ($request->notulen !== '1' && $r->file_notulen) {
            if (is_file(public_path($r->file_notulen))) { @unlink(public_path($r->file_notulen)); }
            $data['file_notulen'] = null;
        }

        foreach (self::FILES as $field => [$kolom, $dir]) {
            if ($field === 'file_notulen' && $request->notulen !== '1') { continue; }
            if ($request->hasFile($field)) {
                if ($r->$kolom && is_file(public_path($r->$kolom))) {
                    @unlink(public_path($r->$kolom));          // hapus file lama
                }
                $data[$kolom] = $this->simpanFile($request->file($field), $dir);
            }
        }

        DB::table(self::T)->where('laporan_kegiatan_id', $r->laporan_kegiatan_id)->update($data);

        return response()->json(['status' => 'success', 'message' => 'Laporan kegiatan berhasil diperbarui!']);
    }

    public function destroy(string $encryptedId)
    {
        $r = $this->find($encryptedId);
        if (!$r) {
            return response()->json(['status' => 'error', 'message' => 'Data tidak ditemukan!'], 404);
        }

        // soft delete, sama seperti pola tabel lama (file di server tidak dihapus)
        DB::table(self::T)->where('laporan_kegiatan_id', $r->laporan_kegiatan_id)->update([
            'deleted_at' => now(),
            'deleted_by' => Auth::id(),
        ]);

        return response()->json(['status' => 'success', 'message' => 'Laporan kegiatan berhasil dihapus!']);
    }

    /* ---------- helper ---------- */

    private function find(string $encryptedId)
    {
        try {
            $id = Crypt::decryptString($encryptedId);
        } catch (\Exception $e) {
            return null;
        }
        return DB::table(self::T)->where('laporan_kegiatan_id', $id)->whereNull('deleted_at')->first();
    }

    private function simpanFile($file, $dir): string
    {
        $nama = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path($dir), $nama);
        return $dir . '/' . $nama;
    }

    // "I"/"II"/"III"/"IV", "Pokja 2", atau "3"  =>  "1".."5"
    private function pokjaNum($v): ?string
    {
        if ($v === null || $v === '') { return null; }
        $v = strtoupper(trim(str_ireplace('pokja', '', $v)));
        $roman = ['I' => '1', 'II' => '2', 'III' => '3', 'IV' => '4', 'V' => '5', 'SEKRETARIS' => '5'];
        return $roman[$v] ?? (ctype_digit($v) ? $v : null);
    }

    private function mapData(Request $request): array
    {
        return [
            'laporan_kegiatan_tanggal'   => $request->tanggal,
            'kegiatan_id'                => $request->kegiatan_id,
            'sub_kegiatan_id'            => $request->sub_kegiatan_id,
            'laporan_kegiatan_tampat'    => $request->tempat,
            'laporan_kegiatan_jam'       => $request->jam,
            'laporan_kegiatan_deskripsi' => $request->deskripsi,
            'laporan_kegiatan_sub'       => $request->pokja === '5' ? 'SEKRETARIS' : 'POKJA' . $request->pokja,   // tersimpan "POKJA1"
            'nama_notulen'               => $request->notulen === '1' ? $request->nama_notulen : null,
        ];
    }

    private function rules(): array
    {
        return [
            'tanggal'         => 'required|date',
            'pokja'           => 'required|in:1,2,3,4,5',
            'kegiatan_id'     => 'required|exists:m_kegiatan,kegiatan_id',
            'sub_kegiatan_id' => 'required|exists:m_sub_kegiatan,sub_kegiatan_id',
            'tempat'          => 'required|string|max:255',
            'jam'             => 'required',
            'notulen'         => 'nullable|in:0,1',
            'nama_notulen'    => 'nullable|required_if:notulen,1|string|max:255',
            'deskripsi'       => 'nullable|string',
            'file_notulen'    => 'nullable|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',
            'file_absensi'    => 'nullable|mimes:jpg,jpeg,pdf|max:2048',
            'foto_1'          => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'foto_2'          => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'foto_3'          => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'file_undangan'   => 'nullable|mimes:jpg,jpeg,png,pdf|max:2048',
        ];
    }
}
