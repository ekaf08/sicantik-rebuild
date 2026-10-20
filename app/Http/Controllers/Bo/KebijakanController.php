<?php

namespace App\Http\Controllers\Bo;

use App\Http\Controllers\Controller;
use App\Models\Kebijakan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class KebijakanController extends Controller
{
    public function index()
    {
        return view('bo.pages.kebijakan.index');
    }

    public function getData(Request $request)
{
    $limit  = (int) $request->input('limit', 10);
    $search = trim($request->input('search', ''));
    $tahun  = $request->input('tahun');
    $pokja  = $request->input('pokja');
    $idKec  = $request->input('id_kec');
    $idKel  = $request->input('id_kel');

    $query = Kebijakan::query();

    // Filter Tahun
    if (!empty($tahun) && $tahun !== 'all') {
        $query->where('tahun', $tahun);
    }

    // Filter Pokja
    if (!empty($pokja) && $pokja !== 'all') {
        $query->where('pokja', $pokja);
    }

    // Filter Kecamatan (mencocokkan ke kolom id_kec)
    if (!empty($idKec) && $idKec !== 'all') {
        $query->where(function($q) use ($idKec) {
            $q->where('id_kec', $idKec)
              ->orWhere('id_kec', 'ilike', "%{$idKec}%");
        });
    }

    // Filter Kelurahan (mencocokkan ke kolom id_kel)
    if (!empty($idKel) && $idKel !== 'all') {
        $query->where(function($q) use ($idKel) {
            $q->where('id_kel', $idKel)
              ->orWhere('id_kel', 'ilike', "%{$idKel}%");
        });
    }

    // Global Search
    if (!empty($search)) {
        $query->where(function ($q) use ($search) {
            $q->where('no_sk', 'ilike', "%{$search}%")
              ->orWhere('perihal', 'ilike', "%{$search}%")
              ->orWhere('keterangan', 'ilike', "%{$search}%")
              ->orWhere('pokja', 'ilike', "%{$search}%")
              ->orWhere('created_by', 'ilike', "%{$search}%");
        });
    }

    $paginator = $query->orderBy('id', 'desc')->paginate($limit);

    return response()->json($paginator);
}

    public function store(Request $request)
    {
        $request->validate([
            'no_sk'       => 'required|string|max:255',
            'perihal'     => 'required|string|max:255',
            'tgl_mulai'   => 'required|date',
            'tgl_selesai' => 'nullable|date',
            'file_sk'     => 'nullable|file|mimes:pdf|max:2048',
        ]);

        $fileName = null;
        if ($request->hasFile('file_sk')) {
            $file = $request->file('file_sk');
            $fileName = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '_', $file->getClientOriginalName());
            $destinationPath = public_path('uploads/file-surat-keputusan');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            $file->move($destinationPath, $fileName);
        }

        $userLogin = auth()->user()->name ?? 'Admin';
        $tahunInput = $request->tahun ?: ($request->tgl_mulai ? date('Y', strtotime($request->tgl_mulai)) : date('Y'));

        $kebijakan = Kebijakan::create([
    'no_sk'       => $request->no_sk,
    'perihal'     => $request->perihal,
    'id_kec'      => $request->id_kec,
    'id_kel'      => $request->id_kel,
    'tgl_mulai'   => $request->tgl_mulai,
    'tgl_selesai' => $request->tgl_selesai,
    'file_sk'     => $fileName,
    'keterangan'  => $request->keterangan,
    'kota'        => 'KOTA SURABAYA',
    'tahun'       => $tahunInput,
    'pokja'       => $request->pokja,
    'created_by'  => $userLogin,
    'updated_by'  => null,
    'deleted_by'  => null,
]);
        return response()->json(['status' => 'success', 'data' => $kebijakan], 200);
    }

    private function safeDecrypt($hash)
    {
        $base64 = str_replace(['-', '_'], ['+', '/'], $hash);
        $remainder = strlen($base64) % 4;
        if ($remainder) {
            $base64 .= str_repeat('=', 4 - $remainder);
        }
        $decrypted = base64_decode($base64);
        return Crypt::decryptString($decrypted);
    }

    public function show($id)
    {
        try {
            $realId = $this->safeDecrypt($id);
            $data = Kebijakan::findOrFail($realId);

            return response()->json($data, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Data tidak ditemukan.'], 404);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $realId = $this->safeDecrypt($id);
            $kebijakan = Kebijakan::findOrFail($realId);

            $request->validate([
                'no_sk'       => 'required|string|max:255',
                'perihal'     => 'required|string|max:255',
                'tgl_mulai'   => 'required|date',
                'tgl_selesai' => 'nullable|date',
                'file_sk'     => 'nullable|file|mimes:pdf|max:2048',
            ]);

            $fileName = $kebijakan->file_sk;
            if ($request->hasFile('file_sk')) {
                // Hapus file lama jika ada
                if ($fileName && file_exists(public_path('uploads/file-surat-keputusan/' . $fileName))) {
                    @unlink(public_path('uploads/file-surat-keputusan/' . $fileName));
                }

                $file = $request->file('file_sk');
                $fileName = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '_', $file->getClientOriginalName());
                $destinationPath = public_path('uploads/file-surat-keputusan');
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }
                $file->move($destinationPath, $fileName);
            }

            $userLogin = auth()->user()->name ?? 'Admin';
            $tahunInput = $request->tahun ?: ($request->tgl_mulai ? date('Y', strtotime($request->tgl_mulai)) : $kebijakan->tahun);

            $kebijakan->update([
    'no_sk'       => $request->no_sk,
    'perihal'     => $request->perihal,
    'id_kec'      => $request->id_kec,
    'id_kel'      => $request->id_kel,
    'tgl_mulai'   => $request->tgl_mulai,
    'tgl_selesai' => $request->tgl_selesai,
    'file_sk'     => $fileName,
    'keterangan'  => $request->keterangan,
    'tahun'       => $tahunInput,
    'pokja'       => $request->pokja,
    'updated_by'  => $userLogin,
]);

            return response()->json(['status' => 'success', 'data' => $kebijakan], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal memperbarui data: ' . $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $realId = $this->safeDecrypt($id);
            $kebijakan = Kebijakan::findOrFail($realId);

            $userLogin = auth()->user()->name ?? 'Admin';
            $kebijakan->deleted_by = $userLogin;
            $kebijakan->save();
            $kebijakan->delete();

            return response()->json(['status' => 'success'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal menghapus data: ' . $e->getMessage()], 500);
        }
    }
}