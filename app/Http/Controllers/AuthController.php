<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Masyarakat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
 public function register(Request $request)
    {
        $request->validate([
            'id_nik' => 'required|string',
            'email_masyarakat' => 'required|string|email|unique:masyarakat',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $masyarakat = Masyarakat::create([
            'id_nik' => $request->id_nik,
            'nama_masyarakat' => "", // darimana (?)
            'alamat' => "", //ditto
            'email_masyarakat' => $request->email_masyarakat,
            'password' => bcrypt($request->password),
            'account_status' => "unvalidated",
        ]);

        $token = $masyarakat->createToken('api_token')->plainTextToken;
        $message = "Berhasil mendaftarkan akun";

        return response()->json([
            'masyarakat' => $masyarakat,
            'token' => $token,
            'message' => $message
        ], 201);
    }

    public function login(Request $request)
{
    $request->validate([
        'email_masyarakat' => 'required|email',
        'password' => 'required|string',
    ]);

    $masyarakat = Masyarakat::where('email_masyarakat', $request->email_masyarakat)->first();

    if (!$masyarakat || !Hash::check($request->password, $masyarakat->password)) {
        return response()->json([
            'message' => 'Email atau password salah.'
        ], 401);
    }

    // ✅ Check if model exists
    if (!$masyarakat->exists) {
        return response()->json([
            'message' => 'Login gagal. Data tidak valid.'
        ], 500);
    }

    // ✅ This should now work
    $token = $masyarakat->createToken('api_token')->plainTextToken;

    return response()->json([
        'masyarakat' => $masyarakat,
        'token' => $token,
        'message' => 'Login berhasil'
    ]);
}


}
