<?php

namespace App\Http\Controllers\Bo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Captcha;


class AuthController extends Controller
{
    public function index()
    {
        return view('login'); // sesuaikan dengan nama view Anda
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            'password' => 'required|string',
            'captcha'  => 'required|captcha',
        ], [
            'captcha.captcha' => 'Kode captcha yang Anda masukkan salah.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => $validator->errors()->first(),
                'errors'  => $validator->errors(),
            ], 422);
        }

        $credentials = [
            'username' => $request->username,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            return response()->json([
                'status'   => true,
                'message'  => 'Login berhasil',
                'redirect' => route('dashboard'), // sesuaikan route tujuan
            ]);
        }

        return response()->json([
            'status'  => false,
            'message' => 'Username atau password salah.',
        ], 401);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json([
            'status' => true,
            'redirect' => route('login')
        ]);
    }

    public function refresh_captcha()
    {
        $captcha = Captcha::img();
        return response()->json(['captcha' => $captcha]);
    }
}
