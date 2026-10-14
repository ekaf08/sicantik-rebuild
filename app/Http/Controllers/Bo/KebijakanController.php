<?php

namespace App\Http\Controllers\Bo;

use App\Http\Controllers\Controller;
use App\Models\Kebijakan;
use Illuminate\Http\Request;

class KebijakanController extends Controller
{
    public function index()
    {
        return view('bo.pages.kebijakan.index');
    }

    public function getData(Request $request)
    {
        $limit = $request->input('limit', 10);
        $search = $request->input('search');
        $tahun = $request->input('tahun');
        $pokja = $request->input('pokja');
        $kelurahan = $request->input('kelurahan');
        $query = Kebijakan::query();

        if (!empty($tahun) && $tahun !== 'all') {
            $query->where('tahun', $tahun);
        }

        if (!empty($pokja) && $pokja !== 'all') {
            $query->where('pokja', $pokja);
        }
        if (!empty($kelurahan)) {
                $query->where(function($q) use ($kelurahan) {
                    $q->where('perihal', 'ilike', "%{$kelurahan}%")
                    ->orWhere('keterangan', 'ilike', "%{$kelurahan}%");
                });
            }
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('no_sk', 'ilike', "%{$search}%")
                  ->orWhere('perihal', 'ilike', "%{$search}%")
                  ->orWhere('keterangan', 'ilike', "%{$search}%")
                  ->orWhere('pokja', 'ilike', "%{$search}%")
                  ->orWhere('created_by', 'ilike', "%{$search}%");
            });
        }

        $data = $query->orderBy('id', 'desc')->paginate($limit);

        return response()->json($data);
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

    public function show($id)
    {
        $data = Kebijakan::findOrFail($id);
        return response()->json($data, 200);
    }

    public function update(Request $request, $id)
    {
        $kebijakan = Kebijakan::findOrFail($id);

        $request->validate([
            'no_sk'       => 'required|string|max:255',
            'perihal'     => 'required|string|max:255',
            'tgl_mulai'   => 'required|date',
            'tgl_selesai' => 'nullable|date',
            'file_sk'     => 'nullable|file|mimes:pdf|max:2048',
        ]);

        $fileName = $kebijakan->file_sk;
        if ($request->hasFile('file_sk')) {
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
            'tgl_mulai'   => $request->tgl_mulai,
            'tgl_selesai' => $request->tgl_selesai,
            'file_sk'     => $fileName,
            'keterangan'  => $request->keterangan,
            'tahun'       => $tahunInput,
            'pokja'       => $request->pokja,
            'updated_by'  => $userLogin,
        ]);

        return response()->json(['status' => 'success', 'data' => $kebijakan], 200);
    }

    public function destroy($id)
    {
        $kebijakan = Kebijakan::findOrFail($id);
        $userLogin = auth()->user()->name ?? 'Admin';

        $kebijakan->deleted_by = $userLogin;
        $kebijakan->save();
        $kebijakan->delete();

        return response()->json(['status' => 'success'], 200);
    }
}