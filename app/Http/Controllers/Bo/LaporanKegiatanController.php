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
            return DataTables::of($this->baseQuery($request))
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
                    $html = '<div style="display: flex; flex-direction: column; gap: 4px; min-width: 100px;">';
                    
                    // Tombol File Notulen
                    if ($r->file_notulen) {
                        $urlNotulen = $this->esc(asset($r->file_notulen));
                        $html .= '<button type="button" class="btn btn-sm" style="background-color: #7765d8; color: white;" onclick="bukaViewerFile(\'' . $urlNotulen . '\')">File Notulen</button>';
                    }
                    
                    // Tombol File Absen
                    if ($r->file_absen) {
                        $urlAbsen = $this->esc(asset($r->file_absen));
                        $html .= '<button type="button" class="btn btn-sm" style="background-color: #f6993f; color: white;" onclick="bukaViewerFile(\'' . $urlAbsen . '\')">File Absen</button>';
                    }
                    
                    // Tombol File Undangan
                    if ($r->file_undangan) {
                        $urlUndangan = $this->esc(asset($r->file_undangan));
                        $html .= '<button type="button" class="btn btn-sm" style="background-color: #e53e3e; color: white;" onclick="bukaViewerFile(\'' . $urlUndangan . '\')">File Undangan</button>';
                    }

                    if (!$r->file_notulen && !$r->file_absen && !$r->file_undangan) {
                        $html .= '<span class="text-muted">-</span>';
                    }

                    $html .= '</div>';
                    return $html;
                })
                
                ->addColumn('foto_thumb', function ($r) {
                    $html = '';
                    $listFoto = [$r->laporan_kegiatan_foto, $r->laporan_kegiatan_foto_2, $r->laporan_kegiatan_foto_3];
                    foreach ($listFoto as $f) {
                        if ($f) {
                            $urlFoto = $this->esc(asset($f));
                            $html .= '<div class="pkk-foto-wrapper mb-1" onclick="bukaViewerFoto(\'' . $urlFoto . '\')" title="Klik untuk memperbesar foto">'
                                .  '<img class="thumb-img" src="' . $urlFoto . '">'
                                .  '<div class="overlay-eye"><i class="ki-outline ki-eye fs-2"></i></div>'
                                .  '</div>';
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
                ->addColumn('oleh', fn ($r) => $r->nama_pembuat ?: '-')
                ->addColumn('action', function ($r) {
                    $enc  = Crypt::encryptString($r->laporan_kegiatan_id);
                    $show = $this->esc(route('laporan-kegiatan.show', $enc));
                    $del  = $this->esc(route('laporan-kegiatan.destroy', $enc));
                    return '<div style="white-space:nowrap">'
                        . '<button type="button" class="abtn view btn-lihat" data-show="' . $show . '">Lihat</button> '
                        . '<button type="button" class="abtn edit btn-edit" data-show="' . $show . '">Edit</button> '
                        . '<button type="button" class="abtn del btn-hapus" data-url="' . $del . '">Hapus</button>'
                        . '</div>';
                })
                ->rawColumns(['foto_thumb', 'jumlah_file', 'action'])
                ->make(true);
        }
 
        $kegiatan = DB::table('m_kegiatan')
            ->where('kegiatan_status', true)->whereNull('deleted_at')
            ->orderBy('kegiatan_id')->get();
 
        return view('bo.pages.laporan.laporan-kegiatan.index', compact('kegiatan'));
    }
 
    // Export ke Excel (.xlsx), mengikuti filter yang sedang aktif
    public function export(Request $request)
    {
        $query = $this->baseQuery($request);
        if ($s = $request->q) {
            $this->terapkanCari($query, $s);
        }

        $judul = [
            'TGL LAPORAN KEGIATAN', 'TGL DIBUAT', 'DIBUAT OLEH', 'LAPORAN KEGIATAN TAMPAT',
            'LAPORAN KEGIATAN DESKRIPSI', 'KETERANGAN', 'LAPORAN KEGIATAN FOTO',
            'LAPORAN KEGIATAN ID', 'NAMA KEGIATAN', 'NAMA SUB KEGIATAN',
        ];

        $tmpSheet = tempnam(sys_get_temp_dir(), 'sheet');
        $tmpXlsx  = tempnam(sys_get_temp_dir(), 'xlsx');

        $h = fopen($tmpSheet, 'w');
        fwrite($h, '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<worksheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main">'
            . '<cols>'
            . '<col min="1" max="2" width="20" customWidth="1"/>'
            . '<col min="3" max="3" width="34" customWidth="1"/>'
            . '<col min="4" max="4" width="30" customWidth="1"/>'
            . '<col min="5" max="5" width="60" customWidth="1"/>'
            . '<col min="6" max="6" width="14" customWidth="1"/>'
            . '<col min="7" max="7" width="60" customWidth="1"/>'
            . '<col min="8" max="8" width="14" customWidth="1"/>'
            . '<col min="9" max="10" width="26" customWidth="1"/>'
            . '</cols><sheetData>');
        fwrite($h, $this->xlsxBaris(1, $judul, true));

        $n = 1;
        foreach ($query->cursor() as $r) {
            $p    = $this->pokjaNum($r->laporan_kegiatan_sub);
            $foto = $r->laporan_kegiatan_foto ?: ($r->laporan_kegiatan_foto_2 ?: $r->laporan_kegiatan_foto_3);

            fwrite($h, $this->xlsxBaris(++$n, [
                Carbon::parse($r->laporan_kegiatan_tanggal)->format('Y-m-d'),
                $r->created_at ? Carbon::parse($r->created_at)->format('Y-m-d H:i:s') : '',
                $r->nama_pembuat,
                $r->laporan_kegiatan_tampat,
                $r->laporan_kegiatan_deskripsi,
                $p === '5' ? 'sekretaris' : ($p ? 'pokja' . $p : ''),
                $foto ? asset($foto) : '',
                (int) $r->laporan_kegiatan_id,
                $r->kegiatan_nama,
                $r->sub_kegiatan_nama,
            ]));
        }
        fwrite($h, '</sheetData></worksheet>');
        fclose($h);

        $this->tulisXlsx($tmpSheet, $tmpXlsx);
        @unlink($tmpSheet);

        return response()->download(
            $tmpXlsx,
            'Data Laporan Kegiatan - Kominfo Kota Surabaya - ' . now()->format('d M Y') . '.xlsx',
            ['Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet']
        )->deleteFileAfterSend(true);
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
        $data['updated_by'] = Auth::id();
 
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
 
        // tempat & jam sedang disabled di form, jangan menimpa data lama dengan kosong
        foreach (['laporan_kegiatan_tampat', 'laporan_kegiatan_jam'] as $k) {
            if ($data[$k] === null || $data[$k] === '') { unset($data[$k]); }
        }

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
 
    // Query dasar: dipakai tabel dan export, lengkap dengan semua filter
    private function baseQuery(Request $request)
    {
        return DB::table(self::T . ' as l')
            ->leftJoin('m_kegiatan as k', 'k.kegiatan_id', '=', 'l.kegiatan_id')
            ->leftJoin('m_sub_kegiatan as s', 's.sub_kegiatan_id', '=', 'l.sub_kegiatan_id')
            ->leftJoin('users as u', 'u.id', '=', 'l.created_by')
            ->whereNull('l.deleted_at')
            ->select([
                'l.laporan_kegiatan_id', 'l.laporan_kegiatan_tanggal', 'l.laporan_kegiatan_tampat',
                'l.laporan_kegiatan_deskripsi', 'l.laporan_kegiatan_foto', 'l.laporan_kegiatan_foto_2',
                'l.laporan_kegiatan_foto_3', 'l.laporan_kegiatan_jam', 'l.file_absen', 'l.file_undangan',
                'l.file_notulen', 'l.nama_notulen', 'l.laporan_kegiatan_sub', 'l.created_by', 'l.created_at',
                'k.kegiatan_nama', 's.sub_kegiatan_nama',
                'u.name as nama_pembuat'
            ])
            ->when($request->kecamatan, fn ($q, $v) => $q->where('u.id_kec', $v))
            ->when($request->kelurahan, fn ($q, $v) => $q->where('u.id_kel', $v))
            ->when($request->bulan, function ($q, $v) {
                [$y, $m] = explode('-', $v);
                $q->whereYear('l.laporan_kegiatan_tanggal', $y)->whereMonth('l.laporan_kegiatan_tanggal', $m);
            })
            ->when($request->pokja, function ($q, $v) {
                $kode = $v === '5' ? 'SEKRETARIS' : 'POKJA' . $v;
                $q->whereRaw("UPPER(REPLACE(l.laporan_kegiatan_sub, ' ', '')) = ?", [$kode]);
            })
            ->orderByDesc('l.laporan_kegiatan_tanggal')
            ->orderByDesc('l.laporan_kegiatan_id');
    }
 
    private function terapkanCari($q, string $s): void
    {
        $q->where(function ($w) use ($s) {
            $w->where('l.laporan_kegiatan_tampat', 'ilike', "%$s%")
              ->orWhere('l.laporan_kegiatan_deskripsi', 'ilike', "%$s%")
              ->orWhere('s.sub_kegiatan_nama', 'ilike', "%$s%");
        });
    }
 
    private function labelPokja($v): string
    {
        $p = $this->pokjaNum($v);
        return $p === '5' ? 'SEKRETARIS' : ($p ? 'POKJA' . $p : '-');
    }
 
    // Cegah teks yang diawali = + - @ dibaca sebagai rumus oleh Excel
    private function csvAman($v)
    {
        if (is_string($v) && $v !== '' && preg_match('/^[=+\-@]/', $v)) {
            return "'" . $v;
        }
        return $v;
    }

    // Satu baris Excel (sel teks memakai inlineStr, angka memakai nilai asli)
private function xlsxBaris(int $row, array $cells, bool $tebal = false): string
{
    $kol = range('A', 'Z');
    $s   = $tebal ? ' s="1"' : '';
    $x   = '<row r="' . $row . '">';

    foreach ($cells as $i => $v) {
        $ref = $kol[$i] . $row;
        if (is_int($v) || is_float($v)) {
            $x .= '<c r="' . $ref . '"' . $s . '><v>' . $v . '</v></c>';
        } else {
            $t = preg_replace('/[^\x09\x0A\x0D\x20-\x{D7FF}\x{E000}-\x{FFFD}]/u', '', (string) $v);
            $x .= '<c r="' . $ref . '"' . $s . ' t="inlineStr"><is><t xml:space="preserve">'
                . htmlspecialchars((string) $t, ENT_XML1 | ENT_QUOTES, 'UTF-8')
                . '</t></is></c>';
        }
    }

    return $x . '</row>';
}

// Bungkus sheet menjadi file .xlsx (zip berisi XML)
private function tulisXlsx(string $sheetPath, string $zipPath): void
{
    $zip = new \ZipArchive();
    if ($zip->open($zipPath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) !== true) {
        abort(500, 'Gagal membuat file Excel.');
    }

    $xml = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>';

    $zip->addFromString('[Content_Types].xml', $xml
        . '<Types xmlns="http://schemas.openxmlformats.org/package/2006/content-types">'
        . '<Default Extension="rels" ContentType="application/vnd.openxmlformats-package.relationships+xml"/>'
        . '<Default Extension="xml" ContentType="application/xml"/>'
        . '<Override PartName="/xl/workbook.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet.main+xml"/>'
        . '<Override PartName="/xl/worksheets/sheet1.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.worksheet+xml"/>'
        . '<Override PartName="/xl/styles.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.styles+xml"/>'
        . '</Types>');

    $zip->addFromString('_rels/.rels', $xml
        . '<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">'
        . '<Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/officeDocument" Target="xl/workbook.xml"/>'
        . '</Relationships>');

    $zip->addFromString('xl/workbook.xml', $xml
        . '<workbook xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships">'
        . '<sheets><sheet name="Laporan Kegiatan" sheetId="1" r:id="rId1"/></sheets></workbook>');

    $zip->addFromString('xl/_rels/workbook.xml.rels', $xml
        . '<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">'
        . '<Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/worksheet" Target="worksheets/sheet1.xml"/>'
        . '<Relationship Id="rId2" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/styles" Target="styles.xml"/>'
        . '</Relationships>');

    $zip->addFromString('xl/styles.xml', $xml
        . '<styleSheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main">'
        . '<fonts count="2"><font><sz val="11"/><name val="Calibri"/></font><font><b/><sz val="11"/><name val="Calibri"/></font></fonts>'
        . '<fills count="2"><fill><patternFill patternType="none"/></fill><fill><patternFill patternType="gray125"/></fill></fills>'
        . '<borders count="1"><border><left/><right/><top/><bottom/><diagonal/></border></borders>'
        . '<cellStyleXfs count="1"><xf numFmtId="0" fontId="0" fillId="0" borderId="0"/></cellStyleXfs>'
        . '<cellXfs count="2"><xf numFmtId="0" fontId="0" fillId="0" borderId="0" xfId="0"/>'
        . '<xf numFmtId="0" fontId="1" fillId="0" borderId="0" xfId="0" applyFont="1"/></cellXfs>'
        . '</styleSheet>');

    $zip->addFile($sheetPath, 'xl/worksheets/sheet1.xml');
    $zip->close();
}

    // htmlspecialchars: ubah < > & " ' menjadi teks biasa
    private function esc($v): string
    {
        return htmlspecialchars((string) $v, ENT_QUOTES, 'UTF-8');
    }
 
    private function find(string $encryptedId)
    {
        try {
            $id = Crypt::decryptString($encryptedId);
        } catch (\Exception $e) {
            return null;
        }
        return DB::table(self::T)->where('laporan_kegiatan_id', $id)->whereNull('deleted_at')->first();
    }

    // Daftar kecamatan untuk dropdown filter
    public function kecamatan()
    {
        return DB::table('m_kecamatan')
            ->where(fn ($q) => $q->whereNull('deleted_at')->orWhere('deleted_at', ''))
            ->orderBy('nama_kec')
            ->get(['id_kec', 'nama_kec']);
    }

    // Daftar kelurahan milik satu kecamatan (m_kelurahan.no_kec = id_kec)
    public function kelurahan($kec)
    {
        return DB::table('m_kelurahan')
            ->whereRaw("LTRIM(CAST(no_kec AS TEXT), '0') = LTRIM(?, '0')", [(string) $kec])
            ->orderBy('nama_kel')
            ->get(['id_kel', 'nama_kel']);
    }
 
    private function simpanFile($file, $dir): string
    {
        // hanya ekstensi yang diizinkan, selain itu ditolak
        $ext  = strtolower($file->getClientOriginalExtension());
        $aman = ['jpg', 'jpeg', 'png', 'pdf', 'doc', 'docx'];
        if (!in_array($ext, $aman, true)) {
            abort(422, 'Tipe file tidak diizinkan.');
        }

        $nama = time() . '_' . bin2hex(random_bytes(8)) . '.' . $ext;
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
            'sub_kegiatan_id' => 'nullable|exists:m_sub_kegiatan,sub_kegiatan_id',
            'tempat'          => 'nullable|string|max:255',
            'jam'             => 'nullable',
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