<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mpasi extends Model
{
    protected $table = 't_mpasi';

    protected $primaryKey = 'id_mpasi';

    protected $fillable = [
        'judul', 'kategori_usia', 'deskripsi', 'bahan', 'langkah', 'mpasi_foto', 'url_video'
    ];   

    protected $appends = ['embed_video_url'];

    public function getEmbedVideoUrlAttribute()
    {
        if (!$this->url_video) {
            return null;
        }

        $url = $this->url_video;

        if (preg_match('/(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|shorts\/|watch\?.+&v=)|m\.youtube\.com\/(?:watch\?v=|shorts\/))([\w-]{11})/i', $url, $matches)) {
            return "https://www.youtube.com/embed/" . $matches[1];
        }

        if (str_contains($url, 'drive.google.com')) {
            if (preg_match('/\/d\/([a-zA-Z0-9_-]+)/', $url, $matches)) {
                return "https://drive.google.com/file/d/" . $matches[1] . "/preview";
            }
        }

        return $url;
    }

    public static function listKategoriUsia()
    {
        return [
            '6-8_bulan'   => '6 - 8 Bulan',
            '9-11_bulan'  => '9 - 11 Bulan',
            '12-23_bulan' => '12 - 23 Bulan',
        ];
    }

}
