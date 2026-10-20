<?php

namespace App\Http\Controllers\Bo;

use App\Http\Controllers\Controller;
use App\Models\DaftarKetuaPkk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class DaftarKetuaPkkController extends Controller
{
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

    public function index()
    {
        $latestDoc = DaftarKetuaPkk::latest('id')->first();
        $pdfUrl = ($latestDoc && file_exists(public_path('uploads/file-ketua-pkk/' . $latestDoc->file_pdf)))
            ? asset('uploads/file-ketua-pkk/' . $latestDoc->file_pdf)
            : null;

        return view('bo.pages.daftar-ketua-pkk.index', compact('latestDoc', 'pdfUrl'));
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file_dokumen' => 'required|file|mimes:pdf|max:5120',
        ]);

        if ($request->hasFile('file_dokumen')) {
            $file = $request->file('file_dokumen');
            $originalName = $file->getClientOriginalName();
            $fileName = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '_', $originalName);

            $destinationPath = public_path('uploads/file-ketua-pkk');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            $file->move($destinationPath, $fileName);

            $userLogin = auth()->user()->name ?? 'Admin';

            $data = DaftarKetuaPkk::create([
                'file_pdf'      => $fileName,
                'original_name' => $originalName,
                'created_by'    => $userLogin,
            ]);

            return response()->json([
                'status'        => 'success',
                'message'       => 'Dokumen berhasil diunggah',
                'hash'          => $data->hash,
                'original_name' => $originalName,
                'pdf_url'       => asset('uploads/file-ketua-pkk/' . $fileName),
            ], 200);
        }

        return response()->json([
            'status'  => 'error',
            'message' => 'Gagal mengunggah file',
        ], 400);
    }

    public function destroy($id)
    {
        try {
            $realId = $this->safeDecrypt($id);
            $doc = DaftarKetuaPkk::findOrFail($realId);

            $filePath = public_path('uploads/file-ketua-pkk/' . $doc->file_pdf);
            if (file_exists($filePath)) {
                @unlink($filePath);
            }

            $userLogin = auth()->user()->name ?? 'Admin';
            $doc->deleted_by = $userLogin;
            $doc->save();
            $doc->delete();

            return response()->json([
                'status'  => 'success',
                'message' => 'Dokumen berhasil dihapus'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Gagal menghapus dokumen.'
            ], 500);
        }
    }
}