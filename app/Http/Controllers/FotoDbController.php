<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

// Menyimpan & menampilkan foto dari database (tabel berkas_foto)
class FotoDbController extends Controller
{
    // Simpan file upload ke database, kembalikan path-nya (mis. pmt/1700000000_ab12cd34.jpg)
    public static function simpan($file, string $folder): string
    {
        $path = $folder . '/' . time() . '_' . Str::random(8) . '.' . strtolower($file->getClientOriginalExtension() ?: 'jpg');

        DB::table('berkas_foto')->insert([
            'path'       => $path,
            'mime'       => $file->getMimeType() ?: 'image/jpeg',
            'isi'        => base64_encode(file_get_contents($file->getRealPath())),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return $path;
    }

    // Hapus foto (database + file lama kalau ada)
    public static function hapus(?string $path): void
    {
        if (!$path) {
            return;
        }

        DB::table('berkas_foto')->where('path', $path)->delete();

        $baru = public_path('uploads/' . $path);
        if (file_exists($baru)) {
            @unlink($baru);
        }
        Storage::disk('public')->delete($path);
    }

    // Alamat gambar untuk satu path; $adaDiDb = daftar path yang ada di tabel berkas_foto
    public static function url(?string $path, array $adaDiDb = []): ?string
    {
        if (!$path) {
            return null;
        }
        if (in_array($path, $adaDiDb, true)) {
            return url('/inovasi/kota/foto-db') . '?p=' . rawurlencode($path);
        }
        if (file_exists(public_path('uploads/' . $path))) {
            return asset('uploads/' . $path);
        }

        return asset('storage/' . $path);
    }

    // Daftar path (dari kumpulan path) yang ada di tabel berkas_foto, satu query
    public static function yangAdaDiDb(array $paths): array
    {
        $paths = array_values(array_filter($paths));
        if (!$paths) {
            return [];
        }

        return DB::table('berkas_foto')->whereIn('path', $paths)->pluck('path')->all();
    }

    // GET /inovasi/kota/foto-db?p=pmt/xxx.jpg
    public function show(Request $request)
    {
        $path = (string) $request->query('p', '');

        // hanya folder foto yang dikenal, tanpa ../
        if (!preg_match('#^(pmt|pisang-danor|pisang-danor-organik|makan-ketan)/[A-Za-z0-9_.\-]+$#', $path)) {
            abort(404);
        }

        $row = DB::table('berkas_foto')->where('path', $path)->first(['mime', 'isi']);
        if (!$row) {
            abort(404);
        }

        return response(base64_decode($row->isi), 200, [
            'Content-Type'  => $row->mime,
            'Cache-Control' => 'private, max-age=86400',
        ]);
    }
}
