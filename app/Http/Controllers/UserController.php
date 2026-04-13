<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Exports\UserExport;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    public function export(Request $request)
    {
        $role = $request->query('role', 'admin');
        return Excel::download(new UserExport($role), $role . '-accounts.xlsx');
    }

    public function resetPassword(User $user)
    {
        $generatedPassword = substr($user->email, 0, 4) . $user->id;
        
        $user->update([
            'password' => Hash::make($generatedPassword)
        ]);

        return redirect()->route('admin.users.index', ['role' => $user->role])
                         ->with('success', 'Berhasil melakukan reset password admin (' . $user->email . ')! Password baru: ' . $generatedPassword);
    }

    public function index(Request $request)
    {
        // Pagar keamanan mutlak: Operator TIDAK BOLEH punya laman index akun!
        if (\Illuminate\Support\Facades\Auth::user()->role === 'operator') {
            abort(403, 'Unauthorized. Operator only have access to Edit Profile.');
        }

        $role = $request->query('role', 'admin'); 
        $users = User::where('role', $role)->get();
        
        if ($role === 'admin') {
            return view('admin.users.admin_index', compact('users', 'role'));
        }
        
        return view('admin.users.operator_index', compact('users', 'role'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|in:admin,operator',
        ], [
            'name.required' => 'The name field is required.',
            'email.required' => 'The email field is required.',
            'role.required' => 'The role field is required.',
        ]);

        // Buat user dulu untuk mendapatkan ID presisi (Kolom ID as Nomor column)
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make(Str::random(10)), // sementara
        ]);
        
        $emailPrefix = substr($request->email, 0, 4);
        $generatedPassword = $emailPrefix . $user->id;
        
        $user->update([
            'password' => Hash::make($generatedPassword)
        ]);

        return redirect()->route('admin.users.index', ['role' => $user->role])
                         ->with('success', 'Berhasil membuat akun (' . $user->email . ')! Password: ' . $generatedPassword);
    }

    public function edit(User $user)
    {
        if (\Illuminate\Support\Facades\Auth::user()->role === 'operator') {
            if ($user->id !== \Illuminate\Support\Facades\Auth::id()) abort(403, 'Unauthorized Profile Access!');
        }
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        if (\Illuminate\Support\Facades\Auth::user()->role === 'operator') {
            if ($user->id !== \Illuminate\Support\Facades\Auth::id()) abort(403, 'Unauthorized Profile Update!');
        }

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'new_password' => 'nullable',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if ($request->filled('new_password')) {
            $data['password'] = Hash::make($request->new_password);
        }

        $user->update($data);

        // Jika dia operator, maka buang ke laman operator landing page
        if (\Illuminate\Support\Facades\Auth::user()->role === 'operator') {
            return redirect()->route('operator')
                             ->with('success', 'Profile berhasil diperbarui.');
        }

        return redirect()->route('admin.users.index', ['role' => $user->role])
                         ->with('success', 'Akun berhasil diupdate.');
    }

    public function destroy(User $user)
    {
        $role = $user->role;
        $user->delete();
        return redirect()->route('admin.users.index', ['role' => $role])
                         ->with('success', 'Akun berhasil dihapus.');
    }
}
