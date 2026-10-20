<?php

namespace App\Http\Controllers\Bo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;

class InovasiController extends Controller
{
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

    private function decRef( int $token)
    {
        try {
            $raw = base64_decode(strtr((string) $token, '-_', '+/'));
            return Crypt::decryptString($raw);
        } catch (\Throwable $e) {
            return null;
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
            ->get();

        return view('bo.pages.inovasi.inovasiglobal.index', compact('kecamatan', 'kelurahan'));
    }

    public function getData()
    {
        try {
            // Ambil data inovasi global
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
        $validator = Validator::make($request->all(), [
            'id'                => 'nullable',
            'tanggal_entry'     => 'required|date',
            'pokja'             => 'required|in:Sekretaris,POKJA 1,POKJA 2,POKJA 3,POKJA 4',
            'id_kec'            => 'required',
            'id_kel'            => 'nullable',
            'nama_inovasi'      => 'required|string|max:255',
            'deskripsi_inovasi' => 'required|string',
            'foto_1'            => 'sometimes|nullable|file|image|mimes:jpeg,png,jpg,webp|max:2048',
            'foto_2'            => 'sometimes|nullable|file|image|mimes:jpeg,png,jpg,webp|max:2048',
            'file_dokumen'      => 'sometimes|nullable|file|mimes:pdf|max:2048',
        ], [
            'id_kec.required'   => 'Kecamatan wajib dipilih.',
            'foto_1.max'        => 'Ukuran Foto 1 tidak boleh lebih dari 2 MB.',
            'foto_1.mimes'      => 'Format Foto 1 harus JPG, PNG, atau WEBP.',
            'foto_2.max'        => 'Ukuran Foto 2 tidak boleh lebih dari 2 MB.',
            'foto_2.mimes'      => 'Format Foto 2 harus JPG, PNG, atau WEBP.',
            'file_dokumen.max'  => 'Ukuran dokumen PDF tidak boleh lebih dari 2 MB.',
            'file_dokumen.mimes'=> 'Berkas lampiran wajib berformat PDF.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 'error',
                'message' => $validator->errors()->first(),
                'errors'  => $validator->errors()
            ], 422);
        }

        try {
            $id = $request->id;
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
                'nama_inovasi'      => $request->nama_inovasi,
                'deskripsi_inovasi' => $request->deskripsi_inovasi,
                'pokja'             => $request->pokja,
                'id_kec'            => $idKec,
                'id_kel'            => $request->filled('id_kel') ? $this->decRef($request->id_kel) : null,
                'periode'           => $request->periode ?? '2026',
                'keterangan'        => $request->keterangan ?? ($request->pokja . ' - Kota Surabaya'),
                'updated_by'        => Auth::id() ?? 1,
                'updated_at'        => now(),
            ];

            $destinationPath = public_path('uploads/inovasi-global');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }

            if ($request->hasFile('foto_1')) {
                $file = $request->file('foto_1');
                $fileName = time() . '_foto1_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move($destinationPath, $fileName);
                $payload['foto_1'] = '/uploads/inovasi-global/' . $fileName;
            }

            if ($request->hasFile('foto_2')) {
                $file = $request->file('foto_2');
                $fileName = time() . '_foto2_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move($destinationPath, $fileName);
                $payload['foto_2'] = '/uploads/inovasi-global/' . $fileName;
            }

            if ($request->hasFile('file_dokumen')) {
                $file = $request->file('file_dokumen');
                $fileName = time() . '_dokumen_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move($destinationPath, $fileName);
                $payload['file_dokumen'] = '/uploads/inovasi-global/' . $fileName;
            }

            if ($isEdit) {
                DB::table('t_inovasi_global')->where('id', $id)->update($payload);
                $msg = 'Data inovasi berhasil diperbarui.';
            } else {
                $payload['created_by'] = Auth::id() ?? 1;
                $payload['created_at'] = now();
                DB::table('t_inovasi_global')->insert($payload);
                $msg = 'Inovasi baru berhasil disimpan.';
            }

            return response()->json([
                'status'  => 'success',
                'message' => $msg
            ]);

        } catch (\Exception $e) {
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

        DB::table('t_inovasi_global')->where('id', $id)->update([
            'deleted_by' => Auth::id() ?? 1,
            'deleted_at' => now(),
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Data inovasi berhasil dihapus.'
        ]);
    }

    public function kota()
    {
        return view('bo.pages.inovasi.inovasikota.index');
    }

    public function getSurabayaEmasData(Request $request)
    {
        $page      = (int) $request->input('page', 1);
        $limit     = (int) $request->input('limit', 10);
        $kecamatan = $request->input('kecamatan', 'Semua');
        $kelurahan = $request->input('kelurahan', 'Semua');
        $tahun     = $request->input('tahun', 'Semua');
        $search    = $request->input('search', '');

        $dummyData = [
            [
                'id' => 1,
                'nama_balita' => 'Ahmad Fauzi',
                'tanggal_lahir' => '12-05-2022',
                'jenis_kelamin' => 'Laki-laki',
                'alamat_domisili' => 'Jl. Asem Baru No. 12',
                'kelurahan_domisili' => 'Asem Rowo',
                'kecamatan_domisili' => 'ASEMROWO',
                'tpk' => 'TPK 01',
                'tahun' => '2024'
            ],
            [
                'id' => 2,
                'nama_balita' => 'Siti Aisyah',
                'tanggal_lahir' => '04-09-2023',
                'jenis_kelamin' => 'Perempuan',
                'alamat_domisili' => 'Jl. Tambak Sarioso No. 45',
                'kelurahan_domisili' => 'Tambak Sarioso',
                'kecamatan_domisili' => 'ASEMROWO',
                'tpk' => 'TPK 02',
                'tahun' => '2024'
            ],
            [
                'id' => 3,
                'nama_balita' => 'Budi Santoso',
                'tanggal_lahir' => '20-01-2022',
                'jenis_kelamin' => 'Laki-laki',
                'alamat_domisili' => 'Jl. Genting Baru No. 8',
                'kelurahan_domisili' => 'Genting Kalianak',
                'kecamatan_domisili' => 'ASEMROWO',
                'tpk' => 'TPK 01',
                'tahun' => '2024'
            ]
        ];

        $filtered = array_filter($dummyData, function ($item) use ($kecamatan, $search) {
            if ($kecamatan !== 'Semua' && !empty($kecamatan) && strcasecmp($item['kecamatan_domisili'], $kecamatan) !== 0) {
                return false;
            }
            if (!empty($search) && stripos($item['nama_balita'], $search) === false) {
                return false;
            }
            return true;
        });

        $filtered  = array_values($filtered);
        $total     = count($filtered);
        $offset    = ($page - 1) * $limit;
        $pagedData = array_slice($filtered, $offset, $limit);

        return response()->json([
            'total'        => $total,
            'current_page' => $page,
            'per_page'     => $limit,
            'last_page'    => max(1, (int) ceil($total / max(1, $limit))),
            'data'         => $pagedData
        ]);
    }
}
