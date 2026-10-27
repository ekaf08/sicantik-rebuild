<?php

namespace App\Models;

use App\Support\Access;
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

    /** Wilayah user kosong padahal levelnya butuh wilayah. */
    private static function wilayahKosong($user, ?string $level): bool
    {
        return ($level === 'kelurahan' && empty($user->id_kel))
            || ($level === 'kecamatan' && empty($user->id_kec));
    }

    /** Data yang BOLEH DILIHAT. */
    public function scopeFilterWilayahUser($query, $user)
    {
        $level = $user->levelWilayah();

        if (self::wilayahKosong($user, $level)) {
            return $query->whereRaw('1 = 0');
        }

        return match ($level) {
            'kelurahan' => $query->where('id_kelurahan', $user->id_kel),
            'kecamatan' => $query->where('id_kecamatan', $user->id_kec),
            'kota'      => $query,
            default     => $query->whereRaw('1 = 0'),
        };
    }

    /** Data yang BOLEH DIUBAH/DIHAPUS. */
    public function scopeDikelolaOleh($query, $user)
    {
        $level = $user->levelWilayah();

        if (self::wilayahKosong($user, $level)) {
            return $query->whereRaw('1 = 0');
        }

        return match ($level) {
            'kelurahan' => $query->where('level_wilayah', 'kelurahan')->where('id_kelurahan', $user->id_kel),
            'kecamatan' => $query->where('level_wilayah', 'kecamatan')->where('id_kecamatan', $user->id_kec),
            'kota'      => $query->where('level_wilayah', 'kota'),
            default     => $query->whereRaw('1 = 0'),
        };
    }

    public function bisaDikelola($user): bool
    {
        $level = $user->levelWilayah();

        if (!$level || self::wilayahKosong($user, $level)) {
            return false;
        }

        return $level === $this->level_wilayah
            && match ($this->level_wilayah) {
                'kelurahan' => (string) $this->id_kelurahan === (string) $user->id_kel,
                'kecamatan' => (string) $this->id_kecamatan === (string) $user->id_kec,
                default     => true,
            };
    }

    public function bisaDiubah($user): bool
    {
        return Access::can('laporan-tahunan', 'update') && $this->bisaDikelola($user);
    }

    public function bisaDihapus($user): bool
    {
        return Access::can('laporan-tahunan', 'delete') && $this->bisaDikelola($user);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}