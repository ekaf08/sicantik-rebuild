<?php

namespace App\Support;

use Illuminate\Support\Facades\Crypt;

/**
 * Mengacak ID database sebelum dikirim ke browser / dipakai di URL,
 * dan mengembalikannya saat diterima server.
 * Hasilnya aman dipakai di URL dan tergantung APP_KEY (tidak bisa ditebak / dibalik tanpa kunci).
 */
class IdCipher
{
    public static function encode($id): string
    {
        return strtr(Crypt::encryptString((string) $id), '+/=', '-_.');
    }

    public static function decode(?string $token): ?int
    {
        if (!$token) {
            return null;
        }

        try {
            return (int) Crypt::decryptString(strtr($token, '-_.', '+/='));
        } catch (\Throwable $e) {
            return null;
        }
    }

    /** Sama seperti decode(), tetapi menghasilkan halaman 404 bila token tidak valid. */
    public static function decodeOrFail($token): int
    {
        $id = self::decode(is_string($token) ? $token : (string) $token);

        if ($id === null || $id <= 0) {
            abort(404);
        }

        return $id;
    }
}
