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
            'account_status' => "Menunggu",
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
                'user' => [
                    "id_nik" => $super_admin->id_nik,
                    "nama" => $super_admin->nama_super_admin,
                    "email" => $super_admin->email_admin,
                    "alamat" => $super_admin->alamat,
                    "account_status" => "Disetujui",
                    "account_role" => "root_admin",
                    "created_at" => "2025-07-23T11:07:35.000000Z",
                    "updated_at" => "2025-07-23T11:07:35.000000Z"
                ],
                'token' => $token,
                'account_role' => "root_admin",
                'account_status' => "Disetujui"
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

    public function getAccountById(Request $request) {
        $user = User::where('id_nik', $request->id_nik)->first();

        if (!$user) {
            return response()->json([
                'message' => 'Data user tidak ditemukan.'
            ], 404);
        }

        return response()->json([
            'user' => $user,
        ], 200);
    }

    public function getAccountStatusCount() {
        $user = User::count();
        $rejected = User::where('account_status', 'Ditolak')->count();
        $accepted = User::where('account_status', 'Disetujui')->count();
        $admin_pelaporan = User::where('account_role', 'admin_pelaporan')->count();
        $admin_kepala = User::where('account_role', 'admin_kepala')->count();
        $admin_masyarakat = User::where('account_role', 'admin_masyarakat')->count();
        $nonaktif = User::where('account_status', 'Nonaktif')->count();
        $super_admin = SuperAdmin::count() + User::where('account_status', 'super_admin')->count();
        $pending = User::where('account_status','Menunggu')->count();

        return response()->json([
            'all' => $user,
            'Ditolak' => $rejected,
            'Disetujui' => $accepted,
            'admin_pelaporan' => $admin_pelaporan,
            'admin_kepala' => $admin_kepala,
            'admin_masyarakat' => $admin_masyarakat,
            'Nonaktif' => $nonaktif,
            'super_admin' => $super_admin,
            'Pending' => $pending
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

        if (!$user) {
            return response()->json([
                'message' => 'Data user tidak ditemukan.'
            ], 404);
        }

        $user->account_role = $request->account_role;

        return response()->json([
            'message' => 'Role berhasil diperbarui.',
            'user' => $user,
        ], 200);
    }

    public function getAccountByStatus(Request $request) {
        $status = $request->account_status;
        if($status == "notSuperAdmin") {
            $user = User::whereNot('account_role', "super_admin")->get();
        } else {
            $user = User::where('account_status', $status)->get();
        }

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


    public function UpdateProfile(Request $request) {
        $id_nik = $request->id_nik;
        $user = User::where('id_nik', $id_nik)->first();

        if (!$user) {
            return response()->json([
                'message' => 'Data masyarakat tidak ditemukan.'
            ], 404);
        }

        $validated = $request->validate([
            'email' => 'sometimes|email|unique:users,email,' . $user->id_nik . ',id_nik',
            'password' => 'sometimes|string|min:8',
            'nama' => 'sometimes|string',
            'alamat' => 'sometimes|nullable|string',
        ]);

        if (isset($validated['password'])) {
            $validated['password'] = bcrypt($validated['password']);
        }

        $user->update($validated);

        return response()->json([
            'message' => 'Profil berhasil diperbarui.',
            'user' => $user,
        ], 200);
    }



    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logout berhasil.'
        ]);
    }

}
