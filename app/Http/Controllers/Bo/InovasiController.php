<?php

namespace App\Http\Controllers\Bo;

use App\Http\Controllers\Controller;
use App\Support\IdCipher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class InovasiController extends Controller
{
    private const UPLOAD_DIR = 'uploads/inovasi-global';

    
    private const REGEX_TEKS  = '/^[\p{L}\p{M}\p{N}\s.,\-()\/:!?&%]+$/u';
    private const REGEX_TOKEN = '/^[A-Za-z0-9\-_]+$/';
    private const REGEX_PERIODE = '/^[\p{L}\p{N}\s\-\/]+$/u';

    private const FILE_FIELDS = [
        'foto_1'       => 'foto1',
        'foto_2'       => 'foto2',
        'file_dokumen' => 'dokumen',
    ];

    public function index()
    {
        $kecamatan = DB::table('m_kecamatan')->orderBy('nama_kec', 'asc')->get();
        $kelurahan = DB::table('m_kelurahan')->orderBy('nama_kel', 'asc')->get();

        return view('bo.inovasi.index', compact('kecamatan', 'kelurahan'));
    }

    private function encRef(int $value)
    {
        return rtrim(strtr(base64_encode(Crypt::encryptString((string) $value)), '+/', '-_'), '=');
    }

    private function decRef($token)
    {
        try {
            $raw = base64_decode(strtr((string) $token, '-_', '+/'));
            return (int) Crypt::decryptString($raw);
        } catch (\Throwable $e) {
            return null;
        }
    }

    private function isMaliciousString(string $value): bool
    {
        $decoded = $value;
        for ($i = 0; $i < 3; $i++) {
            $next = html_entity_decode(urldecode($decoded), ENT_QUOTES | ENT_HTML5, 'UTF-8');
            if ($next === $decoded) {
                break;
            }
            $decoded = $next;
        }

        $patterns = [
            '/[<>]/',                                   
            '/\x00/',                                   
            '/javascript\s*:/i',
            '/vbscript\s*:/i',
            '/data\s*:\s*text\/html/i',
            '/\bon[a-z]{3,}\s*=/i',                     
            '/\b(alert|prompt|confirm|eval)\s*\(/i',
            '/document\s*\.\s*(cookie|write|location|domain)/i',
            '/window\s*\.\s*location/i',
            '/\{\{|\}\}|\{!!|!!\}/',                   
            '/\$\{/',                                   
            '/\bunion\s+(all\s+)?select\b/i',          
            '/;\s*(drop|delete|update|insert|alter|truncate)\b/i',
            '/\bor\s+1\s*=\s*1\b/i',
        ];

        foreach ([$value, $decoded] as $candidate) {
            foreach ($patterns as $pattern) {
                if (preg_match($pattern, $candidate)) {
                    return true;
                }
            }
        }

        return false;
    }

    private function findMaliciousInput(array $inputs, string $prefix = ''): ?string
    {
        foreach ($inputs as $key => $value) {
            $name = $prefix === '' ? (string) $key : $prefix . '.' . $key;

            if (is_array($value)) {
                if ($found = $this->findMaliciousInput($value, $name)) {
                    return $found;
                }
                continue;
            }

            if (is_string($value) && $value !== '' && $this->isMaliciousString($value)) {
                return $name;
            }
        }

        return null;
    }

    
    private function deleteStoredFile(?string $path): void
    {
        if (empty($path)) {
            return;
        }

        $base = realpath(public_path(self::UPLOAD_DIR));
        $full = realpath(public_path(ltrim($path, '/')));

        if ($base && $full && strpos($full, $base . DIRECTORY_SEPARATOR) === 0 && is_file($full)) {
            @unlink($full);
        }
    }

    public function global()
    {
        $kecamatan = DB::table('m_kecamatan')
            ->orderBy('nama_kec', 'asc')
            ->get()
            ->map(function ($k) {
                $k->ref = $this->encRef($k->id_kec);
                unset($k->id_kec);
                return $k;
            });

        $kelurahan = DB::table('m_kelurahan')
            ->orderBy('nama_kel', 'asc')
            ->get()
            ->map(function ($kel) {
                $kel->ref = $this->encRef($kel->id_kel);
                unset($kel->id_kel);
                return $kel;
            });

        return view('bo.pages.inovasi.inovasiglobal.index', compact('kecamatan', 'kelurahan'));
    }

    public function getData()
    {
        try {
            $inovasi = DB::table('t_inovasi_global as tig')
                ->leftJoin('m_kecamatan as mk', 'tig.id_kec', '=', 'mk.id_kec')
                ->leftJoin('m_kelurahan as mkel', 'tig.id_kel', '=', 'mkel.id_kel')
                ->leftJoin('users as u', 'tig.created_by', '=', 'u.id')
                ->whereNull('tig.deleted_at')
                ->select(
                    'tig.id',
                    'tig.tanggal_entry',
                    'tig.nama_inovasi',
                    'tig.deskripsi_inovasi',
                    'tig.foto_1',
                    'tig.foto_2',
                    'tig.file_dokumen',
                    'tig.periode',
                    'tig.keterangan',
                    'tig.pokja',
                    'mk.nama_kec',
                    'mkel.nama_kel',
                    'u.name as creator_name'
                )
                ->orderBy('tig.id', 'desc')
                ->get()
                ->map(function ($row) {
                    $row->ref = $this->encRef($row->id);
                    unset($row->id);
                    return $row;
                });

            return response()->json([
                'status' => 'success',
                'data'   => $inovasi
            ], 200);

        } catch (\Throwable $e) {
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function storeOrUpdateGlobal(Request $request)
    {
        /* ---- (5) Tolak input yang mengandung script / simbol berbahaya ---- */
        $labels = [
            'tanggal_entry'     => 'Tanggal Entry',
            'pokja'             => 'Pokja',
            'id_kec'            => 'Kecamatan',
            'id_kel'            => 'Kelurahan',
            'nama_inovasi'      => 'Nama Inovasi',
            'deskripsi_inovasi' => 'Deskripsi Inovasi',
            'dibuat_oleh'       => 'Dibuat Oleh',
            'periode'           => 'Periode',
            'keterangan'        => 'Keterangan',
            'id'                => 'ID',
        ];

        $badField = $this->findMaliciousInput(
            $request->except(['_token', '_method', 'foto_1', 'foto_2', 'file_dokumen'])
        );

        if ($badField !== null) {
            $label = $labels[$badField] ?? $badField;
            return response()->json([
                'status'  => 'error',
                'message' => "Kolom {$label} mengandung kata atau simbol yang tidak diizinkan (misalnya tag HTML atau script).",
            ], 422);
        }

        $validator = Validator::make($request->all(), [
            'id'                 => ['nullable', 'string', 'max:1000', 'regex:' . self::REGEX_TOKEN],
            'tanggal_entry'      => 'required|date',
            'pokja'              => 'required|in:Sekretaris,POKJA 1,POKJA 2,POKJA 3,POKJA 4',
            'id_kec'             => ['required', 'string', 'max:1000', 'regex:' . self::REGEX_TOKEN],
            'id_kel'             => ['nullable', 'string', 'max:1000', 'regex:' . self::REGEX_TOKEN],
            'nama_inovasi'       => ['required', 'string', 'max:255', 'regex:' . self::REGEX_TEKS],
            'deskripsi_inovasi'  => ['required', 'string', 'max:5000', 'regex:' . self::REGEX_TEKS],
            'periode'            => ['nullable', 'string', 'max:20', 'regex:' . self::REGEX_PERIODE],
            'keterangan'         => ['nullable', 'string', 'max:255', 'regex:' . self::REGEX_TEKS],
            'foto_1'             => 'sometimes|nullable|file|image|mimes:jpeg,png,jpg,webp|max:2048',
            'foto_2'             => 'sometimes|nullable|file|image|mimes:jpeg,png,jpg,webp|max:2048',
            'file_dokumen'       => 'sometimes|nullable|file|mimes:pdf|max:2048',
            'remove_foto_1'      => 'nullable|in:0,1',
            'remove_foto_2'      => 'nullable|in:0,1',
            'remove_file_dokumen'=> 'nullable|in:0,1',
        ], [
            'id_kec.required'    => 'Kecamatan wajib dipilih.',
            'id_kec.regex'       => 'Kecamatan tidak valid.',
            'id_kel.regex'       => 'Kelurahan tidak valid.',
            'id.regex'           => 'Data tidak valid.',
            'nama_inovasi.regex'      => 'Nama Inovasi hanya boleh berisi huruf, angka, spasi, dan tanda . , - ( ) / : ! ? & %',
            'deskripsi_inovasi.regex' => 'Deskripsi Inovasi hanya boleh berisi huruf, angka, spasi, dan tanda . , - ( ) / : ! ? & %',
            'keterangan.regex'        => 'Keterangan hanya boleh berisi huruf, angka, spasi, dan tanda . , - ( ) / : ! ? & %',
            'periode.regex'           => 'Periode hanya boleh berisi huruf, angka, spasi, strip, dan garis miring.',
            'foto_1.max'         => 'Ukuran Foto 1 tidak boleh lebih dari 2 MB.',
            'foto_1.mimes'       => 'Format Foto 1 harus JPG, PNG, atau WEBP.',
            'foto_2.max'         => 'Ukuran Foto 2 tidak boleh lebih dari 2 MB.',
            'foto_2.mimes'       => 'Format Foto 2 harus JPG, PNG, atau WEBP.',
            'file_dokumen.max'   => 'Ukuran dokumen PDF tidak boleh lebih dari 2 MB.',
            'file_dokumen.mimes' => 'Berkas lampiran wajib berformat PDF.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 'error',
                'message' => $validator->errors()->first(),
                'errors'  => $validator->errors()
            ], 422);
        }

        $id     = $request->id;
        $isEdit = !empty($id) && $id !== '-1';

        if ($isEdit) {
            $id = $this->decRef($id);
            if (!$id) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Data tidak valid.'
                ], 400);
            }
        }

        $idKec = $this->decRef($request->id_kec);
        if (!$idKec) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Kecamatan tidak valid.'
            ], 422);
        }

        $payload = [
            'tanggal_entry'     => $request->tanggal_entry,
            'nama_inovasi'      => trim($request->nama_inovasi),
            'deskripsi_inovasi' => trim($request->deskripsi_inovasi),
            'pokja'             => $request->pokja,
            'id_kec'            => $idKec,
            'id_kel'            => $request->filled('id_kel') ? $this->decRef($request->id_kel) : null,
            'periode'           => $request->periode ?? '2026',
            'keterangan'        => $request->keterangan ?? ($request->pokja . ' - Kota Surabaya'),
            'updated_by'        => Auth::id() ?? 1,
            'updated_at'        => now(),
        ];

        $newFiles         = [];
        $oldFilesToDelete = []; 

        DB::beginTransaction();

        try {
            $existing = null;

            if ($isEdit) {
                $existing = DB::table('t_inovasi_global')
                    ->where('id', $id)
                    ->whereNull('deleted_at')
                    ->first();

                if (!$existing) {
                    DB::rollBack();
                    return response()->json([
                        'status'  => 'error',
                        'message' => 'Data inovasi tidak ditemukan.'
                    ], 404);
                }

                DB::table('t_inovasi_global')->where('id', $id)->update($payload);
                $recordId = $id;
                $msg = 'Data inovasi berhasil diperbarui.';
            } else {
                $payload['created_by'] = Auth::id() ?? 1;
                $payload['created_at'] = now();
                $recordId = DB::table('t_inovasi_global')->insertGetId($payload);
                $msg = 'Inovasi baru berhasil disimpan.';
            }

            $destinationPath = public_path(self::UPLOAD_DIR);
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            $fileUpdates = [];

            foreach (self::FILE_FIELDS as $field => $label) {
                $oldPath = $existing->{$field} ?? null;

                if ($request->hasFile($field) && $request->file($field)->isValid()) {
                    $file     = $request->file($field);
                    $fileName = time() . '_' . $label . '_' . uniqid() . '.' . $file->extension();
                    $file->move($destinationPath, $fileName);

                    $newPath = '/' . self::UPLOAD_DIR . '/' . $fileName;
                    $newFiles[]           = $newPath;
                    $fileUpdates[$field]  = $newPath;

                    if ($oldPath) {
                        $oldFilesToDelete[] = $oldPath;
                    }
                } elseif ($isEdit && $request->input('remove_' . $field) === '1' && $oldPath) {
                    $fileUpdates[$field] = null;
                    $oldFilesToDelete[]  = $oldPath;
                }
            }

            if (!empty($fileUpdates)) {
                DB::table('t_inovasi_global')->where('id', $recordId)->update($fileUpdates);
            }

            DB::commit();

            foreach ($oldFilesToDelete as $oldFile) {
                $this->deleteStoredFile($oldFile);
            }

            return response()->json([
                'status'  => 'success',
                'message' => $msg
            ]);

        } catch (\Throwable $e) {
            DB::rollBack();

            foreach ($newFiles as $newFile) {
                $this->deleteStoredFile($newFile);
            }

            return response()->json([
                'status'  => 'error',
                'message' => 'Gagal menyimpan ke database: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroyGlobal(Request $request)
{
    $id = $this->decRef($request->input('id', $request->route('id')));

    if (!$id) {
        return response()->json([
            'status'  => 'error',
            'message' => 'ID data tidak valid.'
        ], 400);
    }

    $row = DB::table('t_inovasi_global')
        ->where('id', $id)
        ->whereNull('deleted_at')
        ->first();

    if (!$row) {
        return response()->json([
            'status'  => 'error',
            'message' => 'Data inovasi tidak ditemukan atau sudah dihapus.'
        ], 404);
    }

    try {
        DB::table('t_inovasi_global')->where('id', $id)->update([
            'foto_1'       => null,
            'foto_2'       => null,
            'file_dokumen' => null,
            'deleted_by'   => Auth::id() ?? 1,
            'deleted_at'   => now(),
        ]);
    } catch (\Throwable $e) {
        return response()->json([
            'status'  => 'error',
            'message' => 'Gagal menghapus data: ' . $e->getMessage()
        ], 500);
    }

    foreach ([$row->foto_1, $row->foto_2, $row->file_dokumen] as $path) {
        $this->deleteStoredFile($path);
    }

    return response()->json([
        'status'  => 'success',
        'message' => 'Data inovasi berhasil dihapus.'
    ]);
}

    public function kota()
    {
        $kelurahan = DB::table('m_kelurahan')->orderBy('nama_kel', 'asc')->get();

        return view('bo.pages.inovasi.inovasikota.index', compact('kelurahan'));
    }

    // SOTH 
    
    public function soth()
{
    $listKelurahan = collect();

    if (Schema::hasTable('m_kelurahan')) {
        $query = DB::table('m_kelurahan');

        if (Schema::hasTable('m_kecamatan') && Schema::hasColumn('m_kelurahan', 'id_kec')) {
            $query->leftJoin('m_kecamatan', 'm_kelurahan.id_kec', '=', 'm_kecamatan.id_kec')
                ->select(
                    'm_kelurahan.nama_kel',
                    DB::raw('UPPER(TRIM(m_kecamatan.nama_kec)) as nama_kec')
                );
        } else {
            $query->select('nama_kel');
        }

        $listKelurahan = $query->orderBy('nama_kel', 'asc')->get();
    }

    if ($listKelurahan->isEmpty() && Schema::hasTable('t_inovasi_soth')) {
        $listKelurahan = DB::table('t_inovasi_soth')
            ->whereNull('deleted_at')
            ->select(
                'kelurahan as nama_kel',
                DB::raw('UPPER(TRIM(kecamatan)) as nama_kec')
            )
            ->distinct()
            ->orderBy('kelurahan', 'asc')
            ->get();
    }

    return view('bo.pages.inovasi_soth.index', [
        'masterKelurahan' => $listKelurahan
    ]);
}

    public function getSothData(Request $request)
    {
        $page      = (int) $request->input('page', 1);
        $limit     = (int) $request->input('limit', 10);
        $kecamatan = $request->input('kecamatan');
        $kelurahan = $request->input('kelurahan');
        $tahun     = $request->input('tahun');
        $search    = trim($request->input('search', ''));

        $query = DB::table('t_inovasi_soth')->whereNull('deleted_at');

        if (!empty($kecamatan) && $kecamatan !== 'all') {
            $query->where('kecamatan', 'ilike', trim($kecamatan));
        }

        if (!empty($kelurahan) && $kelurahan !== 'all') {
            $query->where('kelurahan', 'ilike', trim($kelurahan));
        }

        if (!empty($tahun) && $tahun !== 'all') {
            if (Schema::hasColumn('t_inovasi_soth', 'tahun')) {
                $query->where('tahun', $tahun);
            } else {
                $query->whereYear('created_at', $tahun);
            }
        }

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'ilike', "%{$search}%")
                  ->orWhere('alamat', 'ilike', "%{$search}%")
                  ->orWhere('kelurahan', 'ilike', "%{$search}%")
                  ->orWhere('kecamatan', 'ilike', "%{$search}%")
                  ->orWhere('rt', 'ilike', "%{$search}%")
                  ->orWhere('rw', 'ilike', "%{$search}%");
            });
        }

        $total  = $query->count();
        $offset = ($page - 1) * $limit;

        $items = $query->orderBy('id', 'desc')
            ->offset($offset)
            ->limit($limit)
            ->get();

        return response()->json([
            'total'        => $total,
            'current_page' => $page,
            'per_page'     => $limit,
            'last_page'    => max(1, (int) ceil($total / max(1, $limit))),
            'from'         => $total > 0 ? $offset + 1 : 0,
            'to'           => min($offset + $limit, $total),
            'data'         => $items
        ]);
    }

    public function getSothChart(Request $request)
    {
        $kecamatan = $request->input('kecamatan');
        $kelurahan = $request->input('kelurahan');
        $tahun     = $request->input('tahun');

        $query = DB::table('t_inovasi_soth')->whereNull('deleted_at');

        if (!empty($kecamatan) && $kecamatan !== 'all') {
            $query->where('kecamatan', 'ilike', trim($kecamatan));
        }

        if (!empty($kelurahan) && $kelurahan !== 'all') {
            $query->where('kelurahan', 'ilike', trim($kelurahan));
        }

        if (!empty($tahun) && $tahun !== 'all') {
            if (Schema::hasColumn('t_inovasi_soth', 'tahun')) {
                $query->where('tahun', $tahun);
            } else {
                $query->whereYear('created_at', $tahun);
            }
        }

        // Jika kecamatan dipilih, grafik otomatis mengelompokkan per kelurahan.
        // Jika kelurahan spesifik dipilih, tampilkan perbandingan SOTH di kelurahan tersebut.
        // Jika semua kecamatan, tampilkan per kecamatan.
        if (!empty($kelurahan) && $kelurahan !== 'all') {
            $groupField = 'nama';
        } elseif (!empty($kecamatan) && $kecamatan !== 'all') {
            $groupField = 'kelurahan';
        } else {
            $groupField = 'kecamatan';
        }

        $data = $query->select(
            $groupField . ' as label_name',
            DB::raw('ROUND(AVG(rata_pre)::numeric, 2) as avg_pre'),
            DB::raw('ROUND(AVG(rata_post)::numeric, 2) as avg_post')
        )
        ->groupBy($groupField)
        ->orderBy($groupField, 'asc')
        ->get();

        $labels   = [];
        $preData  = [];
        $postData = [];

        foreach ($data as $item) {
            $labels[]   = $item->label_name;
            $preData[]  = (float) $item->avg_pre;
            $postData[] = (float) $item->avg_post;
        }

        return response()->json([
            'labels'   => $labels,
            'pretest'  => $preData,
            'posttest' => $postData,
            'group'    => $groupField
        ]);
    }

    public function getSothKelurahan(Request $request)
    {
        $kecamatan = $request->input('kecamatan');
        $list = collect();

        if (Schema::hasTable('m_kelurahan')) {
            $query = DB::table('m_kelurahan');

            $colKel = Schema::hasColumn('m_kelurahan', 'nama_kel') ? 'nama_kel' : 
                     (Schema::hasColumn('m_kelurahan', 'kelurahan') ? 'kelurahan' : 'nama');

            if (!empty($kecamatan) && $kecamatan !== 'all') {
                $kecClean = strtoupper(trim($kecamatan));

                if (Schema::hasTable('m_kecamatan') && Schema::hasColumn('m_kelurahan', 'id_kec')) {
                    $query->whereIn('id_kec', function ($q) use ($kecClean) {
                        $q->select('id_kec')
                          ->from('m_kecamatan')
                          ->whereRaw('UPPER(TRIM(nama_kec)) = ?', [$kecClean]);
                    });
                } 
                elseif (Schema::hasColumn('m_kelurahan', 'nama_kec')) {
                    $query->whereRaw('UPPER(TRIM(nama_kec)) = ?', [$kecClean]);
                }
            }

            $list = $query->orderBy($colKel, 'asc')->pluck($colKel);
        }

        if ($list->isEmpty() && Schema::hasTable('t_inovasi_soth')) {
            $query = DB::table('t_inovasi_soth')->whereNull('deleted_at');
            if (!empty($kecamatan) && $kecamatan !== 'all') {
                $query->whereRaw('UPPER(TRIM(kecamatan)) = ?', [strtoupper(trim($kecamatan))]);
            }
            $list = $query->select('kelurahan')
                          ->distinct()
                          ->orderBy('kelurahan', 'asc')
                          ->pluck('kelurahan');
        }

        return response()->json($list->filter()->values());
    }

    public function storeSoth(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama'          => 'required|string|max:255',
            'alamat'        => 'required|string|max:255',
            'rt'            => 'required|string|max:20',
            'rw'            => 'nullable|string|max:20',
            'kelurahan'     => 'required|string|max:255',
            'kecamatan'     => 'required|string|max:255',
            'rata_pre'      => 'required|numeric|min:0|max:100',
            'rata_post'     => 'required|numeric|min:0|max:100',
            'total_peserta' => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 'error',
                'message' => $validator->errors()->first()
            ], 422);
        }

        $user = Auth::user()->name ?? 'Admin';

        DB::table('t_inovasi_soth')->insert([
            'nama'          => $request->nama,
            'alamat'        => $request->alamat,
            'rt'            => $request->rt,
            'rw'            => $request->rw ?? '-',
            'kelurahan'     => $request->kelurahan,
            'kecamatan'     => strtoupper($request->kecamatan),
            'rata_pre'      => $request->rata_pre,
            'rata_post'     => $request->rata_post,
            'total_peserta' => $request->total_peserta,
            'created_by'    => $user,
            'created_at'    => now(),
            'updated_at'    => now(),
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Data SOTH berhasil ditambahkan'
        ]);
    }

    public function showSoth($id)
    {
        $realId = IdCipher::decode($id);
        if (!$realId) {
            return response()->json(['status' => 'error', 'message' => 'Data tidak valid'], 400);
        }

        $data = DB::table('t_inovasi_soth')
            ->where('id', $realId)
            ->whereNull('deleted_at')
            ->first();

        if (!$data) {
            return response()->json(['status' => 'error', 'message' => 'Data tidak ditemukan'], 404);
        }

        $data->hash = IdCipher::encode($data->id);
        unset($data->id);

        return response()->json([
            'status' => 'success',
            'data'   => $data
        ]);
    }

    public function updateSoth(Request $request, $id)
    {
        $realId = IdCipher::decode($id);
        if (!$realId) {
            return response()->json(['status' => 'error', 'message' => 'Data tidak valid'], 400);
        }

        $validator = Validator::make($request->all(), [
            'nama'          => 'required|string|max:255',
            'alamat'        => 'required|string|max:255',
            'rt'            => 'required|string|max:20',
            'rw'            => 'nullable|string|max:20',
            'kelurahan'     => 'required|string|max:255',
            'kecamatan'     => 'required|string|max:255',
            'rata_pre'      => 'required|numeric|min:0|max:100',
            'rata_post'     => 'required|numeric|min:0|max:100',
            'total_peserta' => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 'error',
                'message' => $validator->errors()->first()
            ], 422);
        }

        $user = Auth::user()->name ?? 'Admin';

        DB::table('t_inovasi_soth')
            ->where('id', $realId)
            ->update([
                'nama'          => $request->nama,
                'alamat'        => $request->alamat,
                'rt'            => $request->rt,
                'rw'            => $request->rw ?? '-',
                'kelurahan'     => $request->kelurahan,
                'kecamatan'     => strtoupper($request->kecamatan),
                'rata_pre'      => $request->rata_pre,
                'rata_post'     => $request->rata_post,
                'total_peserta' => $request->total_peserta,
                'updated_by'    => $user,
                'updated_at'    => now(),
            ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Data SOTH berhasil diperbarui'
        ]);
    }

    public function destroySoth(Request $request, $id = null)
    {
        $target = $id ?? $request->input('id');
        $realId = IdCipher::decode($target);

        if (!$realId) {
            return response()->json(['status' => 'error', 'message' => 'ID data tidak valid'], 400);
        }

        $user = Auth::user()->name ?? 'Admin';

        DB::table('t_inovasi_soth')
            ->where('id', $realId)
            ->update([
                'deleted_by' => $user,
                'deleted_at' => now(),
            ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Data SOTH berhasil dihapus'
        ]);
    }

    // Kampung Asi
    public function getKampungAsiData(Request $request)
    {
        try {
            $page      = max(1, (int) $request->input('page', 1));
            $limit     = max(1, (int) $request->input('limit', 10));
            $kecamatan = $request->input('kecamatan', 'all');
            $search    = trim($request->input('search', ''));

            $query = DB::table('kampung_asi');

            if (!empty($kecamatan) && $kecamatan !== 'all') {
                $query->where('kecamatan', 'ilike', trim($kecamatan));
            }

            if (!empty($search)) {
                $query->where(function ($q) use ($search) {
                    $q->where('nama_kampung_asi', 'ilike', "%{$search}%")
                      ->orWhere('kelurahan', 'ilike', "%{$search}%")
                      ->orWhere('kecamatan', 'ilike', "%{$search}%");
                });
            }

            $total  = (clone $query)->count();
            $offset = ($page - 1) * $limit;

            $items = $query->orderBy('id', 'desc')
                ->offset($offset)
                ->limit($limit)
                ->get()
                ->map(function ($row) {
                    if (class_exists(\App\Helpers\IdCipher::class)) {
                        $row->hash = \App\Helpers\IdCipher::encode($row->id);
                    } elseif (class_exists('IdCipher')) {
                        $row->hash = \IdCipher::encode($row->id);
                    } else {
                        $row->hash = (string) $row->id;
                    }
                    unset($row->id);
                    return $row;
                });

            return response()->json([
                'total'        => $total,
                'current_page' => $page,
                'per_page'     => $limit,
                'last_page'    => max(1, (int) ceil($total / $limit)),
                'from'         => $total > 0 ? $offset + 1 : 0,
                'to'           => min($offset + $limit, $total),
                'data'         => $items
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine()
            ], 500);
        }
    }

    public function getKampungAsiChart(Request $request)
    {
        try {
            $kecamatan = $request->input('kecamatan', 'all');

            $query = DB::table('kampung_asi');

            if (!empty($kecamatan) && $kecamatan !== 'all') {
                $query->where('kecamatan', 'ilike', trim($kecamatan));
            }

            $data = $query->select(
                'kecamatan',
                DB::raw('ROUND(AVG(persentase)::numeric, 2) as avg_persen')
            )
            ->groupBy('kecamatan')
            ->orderBy('kecamatan', 'asc')
            ->get();

            $labels = [];
            $values = [];

            foreach ($data as $item) {
                $labels[] = $item->kecamatan;
                $values[] = (float) $item->avg_persen;
            }

            return response()->json([
                'labels' => $labels,
                'data'   => $values
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine()
            ], 500);
        }
    }

    public function storeKampungAsi(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kecamatan'        => 'required|string|max:255',
            'kelurahan'        => 'required|string|max:255',
            'nama_kampung_asi' => 'required|string|max:255',
            'jumlah_kader'     => 'required|integer|min:0',
            'jumlah_toga'      => 'required|integer|min:0',
            'ibu_hamil'        => 'required|integer|min:0',
            'ibu_menyusui'     => 'required|integer|min:0',
            'persentase'       => 'required|numeric|min:0|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 'error',
                'message' => $validator->errors()->first()
            ], 422);
        }

        DB::table('kampung_asi')->insert([
            'kecamatan'        => strtoupper(trim($request->kecamatan)),
            'kelurahan'        => trim($request->kelurahan),
            'nama_kampung_asi' => trim($request->nama_kampung_asi),
            'jumlah_kader'     => (int) $request->jumlah_kader,
            'jumlah_toga'      => (int) $request->jumlah_toga,
            'ibu_hamil'        => (int) $request->ibu_hamil,
            'ibu_menyusui'     => (int) $request->ibu_menyusui,
            'persentase'       => (float) $request->persentase,
            'tahun'            => 2026,
            'created_at'       => now(),
            'updated_at'       => now(),
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Data Kampung ASI berhasil ditambahkan'
        ]);
    }

    public function showKampungAsi($id)
    {
        $realId = IdCipher::decode($id);
        if (!$realId) {
            return response()->json(['status' => 'error', 'message' => 'Data tidak valid'], 400);
        }

        $data = DB::table('kampung_asi')
            ->where('id', $realId)
            ->first();

        if (!$data) {
            return response()->json(['status' => 'error', 'message' => 'Data tidak ditemukan'], 404);
        }

        $data->hash = IdCipher::encode($data->id);
        unset($data->id);

        return response()->json([
            'status' => 'success',
            'data'   => $data
        ]);
    }

    public function updateKampungAsi(Request $request, $id)
    {
        $realId = IdCipher::decode($id);
        if (!$realId) {
            return response()->json(['status' => 'error', 'message' => 'Data tidak valid'], 400);
        }

        $validator = Validator::make($request->all(), [
            'kecamatan'        => 'required|string|max:255',
            'kelurahan'        => 'required|string|max:255',
            'nama_kampung_asi' => 'required|string|max:255',
            'jumlah_kader'     => 'required|integer|min:0',
            'jumlah_toga'      => 'required|integer|min:0',
            'ibu_hamil'        => 'required|integer|min:0',
            'ibu_menyusui'     => 'required|integer|min:0',
            'persentase'       => 'required|numeric|min:0|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 'error',
                'message' => $validator->errors()->first()
            ], 422);
        }

        DB::table('kampung_asi')
            ->where('id', $realId)
            ->update([
                'kecamatan'        => strtoupper(trim($request->kecamatan)),
                'kelurahan'        => trim($request->kelurahan),
                'nama_kampung_asi' => trim($request->nama_kampung_asi),
                'jumlah_kader'     => (int) $request->jumlah_kader,
                'jumlah_toga'      => (int) $request->jumlah_toga,
                'ibu_hamil'        => (int) $request->ibu_hamil,
                'ibu_menyusui'     => (int) $request->ibu_menyusui,
                'persentase'       => (float) $request->persentase,
                'updated_at'       => now(),
            ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Data Kampung ASI berhasil diperbarui'
        ]);
    }

    public function destroyKampungAsi(Request $request, $id = null)
    {
        $target = $id ?? $request->input('id');
        $realId = IdCipher::decode($target);

        if (!$realId) {
            return response()->json(['status' => 'error', 'message' => 'ID data tidak valid'], 400);
        }

        DB::table('kampung_asi')
            ->where('id', $realId)
            ->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Data Kampung ASI berhasil dihapus'
        ]);
    }
    
    public function getSurabayaEmasData(Request $request)
    {
        $query = DB::table('surabaya_emas_balita');

        if ($request->filled('kecamatan') && !in_array($request->kecamatan, ['all', 'Semua'])) {
            $query->where('kecamatan_domisili', $request->kecamatan);
        }

        if ($request->filled('kelurahan') && !in_array($request->kelurahan, ['all', 'Semua'])) {
            $query->where('kelurahan_domisili', $request->kelurahan);
        }

        if ($request->filled('tahun') && !in_array($request->tahun, ['all', 'Semua'])) {
            $query->where('tahun', $request->tahun);
        }

        if ($request->filled('search')) {
            $keyword = trim($request->search);
            $query->where(function ($q) use ($keyword) {
                $q->where('nama_balita', 'ILIKE', "%{$keyword}%")
                  ->orWhere('nik', 'ILIKE', "%{$keyword}%")
                  ->orWhere('alamat_domisili', 'ILIKE', "%{$keyword}%")
                  ->orWhere('tpk', 'ILIKE', "%{$keyword}%");
            });
        }

        $limit = $request->input('limit', 10);
        $data = $query->orderBy('id', 'desc')->paginate($limit);

        return response()->json($data);
    }

    public function getSurabayaEmasChart(Request $request)
{
    $masterKecamatan = [
        'ASEMROWO', 'BENOWO', 'BUBUTAN', 'BULAK', 'DUKUH PAKIS', 'GAYUNGAN', 'GENTENG',
        'GUBENG', 'GUNUNG ANYAR', 'JAMBANGAN', 'KARANG PILANG', 'KENJERAN', 'KREMBANGAN',
        'LAKAR SANTRI', 'MULYOREJO', 'PABEAN CANTIAN', 'PAKAL', 'RUNGKUT',
        'SAMBI KEREP', 'SAWAHAN', 'SEMAMPIR', 'SIMOKERTO', 'SUKOLILO',
        'SUKOMANUNGGAL', 'TAMBAKSARI', 'TANDES', 'TEGALSARI', 'TENGGILIS MEJOYO',
        'WIYUNG', 'WONOCOLO', 'WONOKROMO'
    ];

    $query = DB::table('surabaya_emas_balita');

    if ($request->filled('tahun') && !in_array($request->tahun, ['all', 'Semua'])) {
        $query->where('tahun', $request->tahun);
    }

    if ($request->filled('kelurahan') && !in_array($request->kelurahan, ['all', 'Semua'])) {
        $query->where('kelurahan_domisili', $request->kelurahan);
    }

    if ($request->filled('kecamatan') && !in_array($request->kecamatan, ['all', 'Semua'])) {
        $query->where('kecamatan_domisili', $request->kecamatan);
    }

    $counts = $query->select('kecamatan_domisili', DB::raw('COUNT(id) as total'))
        ->groupBy('kecamatan_domisili')
        ->pluck('total', 'kecamatan_domisili')
        ->toArray();

    $labels = $masterKecamatan;
    $data = [];

    foreach ($masterKecamatan as $kec) {
        $data[] = isset($counts[$kec]) ? (int)$counts[$kec] : 0;
    }

    return response()->json([
        'labels' => $labels,
        'data'   => $data
    ]);
}

    public function getSurabayaEmasDetail($id)
    {
        $balita = DB::table('surabaya_emas_balita')->where('id', $id)->first();

        if (!$balita) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        $riwayat = DB::table('surabaya_emas_riwayat_timbang')
            ->where('balita_id', $id)
            ->orderBy('tanggal_timbang', 'asc')
            ->get();

        $labels = [];
        $bb = [];
        $tb = [];

        foreach ($riwayat as $item) {
            $labels[] = date('d M Y', strtotime($item->tanggal_timbang));
            $bb[] = (float) $item->berat_badan;
            $tb[] = (float) $item->tinggi_badan;
        }

        return response()->json([
            'balita' => [
                'id' => $balita->id,
                'nik' => $balita->nik,
                'nama' => $balita->nama_balita,
                'jenis_kelamin' => $balita->jenis_kelamin,
                'alamat' => $balita->alamat_domisili,
            ],
            'riwayat' => $riwayat,
            'chart' => [
                'labels' => $labels,
                'bb' => $bb,
                'tb' => $tb
            ]
        ]);
    }


public function getDataSiCantik()
{
    try {
        $data = \DB::table('inovasi_sicantik')->get();

        return response()->json([
            'status'  => 'success',
            'message' => 'Berhasil',
            'data'    => $data
        ], 200);

    } catch (\Throwable $e) {
        return response()->json([
            'status'  => 'error',
            'message' => $e->getMessage(),
            'line'    => $e->getLine(),
            'file'    => $e->getFile()
        ], 500);
    }
}

public function destroySiCantik(Request $request, $encryptedId)
{
    try {
        $realId = Crypt::decryptString($encryptedId);

        DB::table('inovasi_sicantik')->where('id', $realId)->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Data berhasil dihapus'
        ]);
    } catch (DecryptException $e) {
        return response()->json([
            'status'  => 'error',
            'message' => 'Token tindakan tidak valid atau telah dimanipulasi.'
        ], 403);
    } catch (\Exception $e) {
        return response()->json([
            'status'  => 'error',
            'message' => $e->getMessage()
        ], 500);
    }
}

}