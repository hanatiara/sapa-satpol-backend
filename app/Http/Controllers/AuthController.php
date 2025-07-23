<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\SuperAdmin;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{


    public function register(Request $request) {
        $request->validate([
            'id_nik' => 'required|string|unique:users',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'id_nik' => $request->id_nik,
            'nama' => $request->nama,
            'alamat' => "",
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'account_status' => "menunggu",
            'account_role' => "user_biasa"
        ]);

        $token = $user->createToken('api_token')->plainTextToken;
        $message = "Berhasil mendaftarkan akun";

        return response()->json([
            'user' => $user,
            'token' => $token,
            'message' => $message,
        ], 201);
    }

    public function login(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Login as User
        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            $token = $user->createToken('user_token')->plainTextToken;

            $role = $user->account_role;
            $status = $user->account_status;

            return response()->json([
                'user' => $user,
                'token' => $token,
                'message' => 'Login berhasil sebagai '. $role,
                'account_role' => $role,
                'account_status' => $status
            ]);
        }

        // Login as Super Admin
        $super_admin = SuperAdmin::where('email_admin', $request->email)->first();

        if ($super_admin && Hash::check($request->password, $super_admin->password)) {
            $token = $super_admin->createToken('admin_token')->plainTextToken;

            return response()->json([
                'user' => $super_admin,
                'token' => $token,
                'account_role' => 'super_admin'
            ]);
        }

        return response()->json([
            'message' => 'Email atau password salah.'
        ], 401);
    }

    public function updateAccountStatus(Request $request) {
        $user = User::where('id_nik', $request->id_nik)->first();

        if (!$user) {
            return response()->json([
                'message' => 'Data user tidak ditemukan.'
            ], 404);
        }

        $user->account_status = $request->account_status;

        $user->save();

        return response()->json([
            'message' => 'Status akun berhasil diperbarui.',
            'user' => $user,
        ], 200);
    }

    public function getAccountStatusCount() {
        $user = User::count();
        $rejected = User::where('account_status', 'ditolak')->count();
        $accepted = User::where('account_status', 'disetujui')->count();
        $admin_pelaporan = User::where('account_role', 'admin_pelaporan')->count();
        $admin_kepala = User::where('account_role', 'admin_kepala')->count();
        $user_biasa = User::where('account_role', 'user_biasa')->count();
        $nonaktif = User::where('account_status', 'nonaktif')->count();
        $super_admin = SuperAdmin::get()->count();
        $pending = User::where('account_status','menunggu')->count();

        return response()->json([
            'all' => $user,
            'ditolak' => $rejected,
            'distujui' => $accepted,
            'admin_pelaporan' => $admin_pelaporan,
            'admin_kepala' => $admin_kepala,
            'user_biasa' => $user_biasa,
            'nonaktif' => $nonaktif,
            'super_admin' => $super_admin,
            'pending' => $pending
        ], 200);
    }

    public function getAllAccount() {
        $user = User::select('nama', 'email', 'account_status','id_nik','account_role')->get();

        return response()->json([
            'user' => $user
        ], 200);

    }

    public function updateAccountRole(Request $request) {
        $id_nik = $request->id_nik;
        $user = User::where('id_nik', $id_nik)->first();

        $user->account_role = $request->account_role;

        return response()->json([
            'message' => 'Role berhasil diperbarui.',
            'user' => $user,
        ], 200);
    }

    public function getAccountByStatus(Request $request) {
        $status = $request->account_status;
        $user = User::where('account_status', $status)->get();

        return response()->json([
            'user' => $user,
        ]);
    }

        public function deleteUser(Request $request) {
        $id_nik = $request->id_nik;

        $user = User::where('id_nik', $id_nik)->first();

        if (!$user) {
            return response()->json(['message' => 'User tidak ditemukan.'], 404);
        }

        $user->delete();

        return response()->json(['message' => 'Pengguna berhasil dihapus.'], 200);
    }


    // public function UpdateProfile(Request $request) {
    //     $id_nik = $request->id_nik;
    //     // Edit as Masyrakat
    //     $masyarakat = Masyarakat::where('id_nik', $id_nik)->first();

    //     if (!$masyarakat) {
    //         return response()->json([
    //             'message' => 'Data masyarakat tidak ditemukan.'
    //         ], 404);
    //     }

    //     $masyarakat->nama_masyarakat

    // }


    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logout berhasil.'
        ]);
    }

}
