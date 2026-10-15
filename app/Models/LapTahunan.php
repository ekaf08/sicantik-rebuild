<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LapTahunan extends Model
{
    use SoftDeletes;

    public const FILE_TAHUNAN = [
        'file_kata_pengantar',
        'file_bab_1',
        'file_bab_2',
        'file_bab_3',
        'file_bab_4',
        'file_bab_5',
        'file_bab_6',
        'file_bab_7',
        'file_bab_8',
        'file_full_laporan',
    ];

    public const FILE_MEMORI = ['file_memori_pj'];

    protected $table = 't_lap_tahunan';

    protected $primaryKey = 'id_lap_tahunan';

    protected $fillable = [
        'jenis_laporan',
        'tahun_periode',
        'level_wilayah',
        'id_kecamatan',
        'id_kelurahan',
        'created_by',
        'file_kata_pengantar',
        'file_bab_1',
        'file_bab_2',
        'file_bab_3',
        'file_bab_4',
        'file_bab_5',
        'file_bab_6',
        'file_bab_7',
        'file_bab_8',
        'file_full_laporan',
        'file_memori_pj',
    ];

    public function fileFields(): array
    {
        return $this->jenis_laporan === 'memori_pj' ? self::FILE_MEMORI : self::FILE_TAHUNAN;
    }

    public function getKelengkapanAttribute(): array
    {
        $fields = $this->fileFields();
        $terisi = collect($fields)->filter(fn ($f) => !empty($this->{$f}))->count();

        return [$terisi, count($fields)];
    }

    public function scopeFilterWilayahUser($query, $user)
    {
        if ($user->id_kelurahan) {
            return $query->where('id_kelurahan', $user->id_kelurahan);
        }
        if ($user->id_kecamatan) {
            return $query->where('id_kecamatan', $user->id_kecamatan);
        }

        return $query;
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}