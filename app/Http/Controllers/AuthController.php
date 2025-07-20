<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AdminKepala;
use App\Models\AdminMasyarakat;
use App\Models\Masyarakat;
use App\Models\AdminPelaporan;
use App\Models\SuperAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request) {
        $request->validate([
            // 'id_nik' => 'required|string',
            'email_masyarakat' => 'required|string|email|unique:masyarakat',
            'password' => 'required|string|min:6',
        ]);

        // $nama = "user_" . uniqid();
        // $id_nik = $request->id_nik;

        $id_nik = rand(1000, 9999);;

        $masyarakat = Masyarakat::create([
            'id_nik' => $id_nik,
            'nama_masyarakat' => $request->nama_masyarakat, // darimana (?)
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

    public function login(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Login as Masyarakat
        $masyarakat = Masyarakat::where('email_masyarakat', $request->email)->first();

        if ($masyarakat && Hash::check($request->password, $masyarakat->password)) {
            $token = $masyarakat->createToken('masyarakat_token')->plainTextToken;

            return response()->json([
                'user_type' => 'masyarakat',
                'user' => $masyarakat,
                'token' => $token,
                'message' => 'Login berhasil sebagai masyarakat',
            ]);
        }

        // Login as Admin Pelaporan
        $admin_pelaporan = AdminPelaporan::where('email_admin', $request->email)->first();

        if ($admin_pelaporan && Hash::check($request->password, $admin_pelaporan->password)) {
            $token = $admin_pelaporan->createToken('admin_token')->plainTextToken;

            return response()->json([
                'user_type' => 'admin_pelaporan',
                'user' => $admin_pelaporan,
                'token' => $token,
                'message' => 'Login berhasil sebagai admin pelaporan',
            ]);
        }

        // Login as Admin Masyarakat
        $admin_masyarakat = AdminMasyarakat::where('email_admin', $request->email)->first();

        if ($admin_masyarakat && Hash::check($request->password, $admin_masyarakat->password)) {
            $token = $admin_masyarakat->createToken('admin_token')->plainTextToken;

            return response()->json([
                'user_type' => 'admin_masyarakat',
                'user' => $admin_masyarakat,
                'token' => $token,
                'message' => 'Login berhasil sebagai admin masyarakat',
            ]);
        }

        // Login as Super Admin
        $super_admin = SuperAdmin::where('email_admin', $request->email)->first();

        if ($super_admin && Hash::check($request->password, $super_admin->password)) {
            $token = $super_admin->createToken('admin_token')->plainTextToken;

            return response()->json([
                'user_type' => 'super_admin',
                'user' => $super_admin,
                'token' => $token,
                'message' => 'Login berhasil sebagai super admin',
            ]);
        }

        // Login as Admin Kepala
        $admin_kepala = AdminKepala::where('email_admin', $request->email)->first();

        if ($admin_kepala && Hash::check($request->password, $admin_kepala->password)) {
            $token = $admin_kepala->createToken('admin_token')->plainTextToken;

            return response()->json([
                'user_type' => 'admin_kepala',
                'user' => $admin_kepala,
                'token' => $token,
                'message' => 'Login berhasil sebagai admin kepala',
            ]);
        }

        return response()->json([
            'message' => 'Email atau password salah.'
        ], 401);
    }

    public function updateAccountStatus(Request $request) {
        $masyarakat = Masyarakat::where('id_nik', $request->id_nik)->first();

        if (!$masyarakat) {
            return response()->json([
                'message' => 'Data masyarakat tidak ditemukan.'
            ], 404);
        }

        $masyarakat->account_status = $request->account_status;

        $masyarakat->save();

        return response()->json([
            'message' => 'Status akun berhasil diperbarui.',
            'masyarakat' => $masyarakat,
        ]);
    }

    public function UpdateProfile(Request $request) {
        $id_nik = $request->id_nik;



    }

    public function logout() {

    }

}
