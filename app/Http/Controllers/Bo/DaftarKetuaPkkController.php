<?php

namespace App\Http\Controllers\Bo;

use App\Http\Controllers\Controller;
use App\Models\DaftarKetuaPkk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class DaftarKetuaPkkController extends Controller
{
    private function safeEncrypt($id)
    {
        $encrypted = Crypt::encryptString((string)$id);
        return rtrim(strtr(base64_encode($encrypted), '+/', '-_'), '=');
    }

    private function safeDecrypt($hash)
    {
        try {
            $base64 = strtr($hash, '-_', '+/');
            $remainder = strlen($base64) % 4;
            if ($remainder) {
                $base64 .= str_repeat('=', 4 - $remainder);
            }
            $decrypted = base64_decode($base64);
            return Crypt::decryptString($decrypted);
        } catch (\Exception $e) {
            return null;
        }
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
            'file_dokumen' => 'required|file|mimes:pdf|mimetypes:application/pdf|max:5120',
        ], [
            'file_dokumen.required'  => 'Dokumen wajib diunggah.',
            'file_dokumen.mimes'     => 'Format dokumen harus berupa PDF.',
            'file_dokumen.mimetypes' => 'Format dokumen harus berupa PDF.',
            'file_dokumen.max'       => 'Ukuran dokumen maksimal adalah 5 MB.',
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

            $hash = $this->safeEncrypt($data->id);

            return response()->json([
                'status'        => 'success',
                'message'       => 'Dokumen berhasil diunggah',
                'hash'          => $hash,
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
            if (!$realId) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Token dokumen tidak valid.',
                ], 400);
            }

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