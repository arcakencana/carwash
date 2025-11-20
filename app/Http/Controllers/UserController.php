<?php

namespace App\Http\Controllers;

use App\Models\Kelurahan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = User::query();

        if ($search) {
            $query->where('name', 'like', "%{$search}%")
            ->orWhere('email', 'like', "%{$search}%");
        }

        $users = $query->latest()->paginate(10);
        $users->appends(['search' => $search]);

        return view('users.index', compact('users', 'search'));
    }

    public function create()
    {
        $roles = Role::pluck('name', 'id');
        $kelurahans = Kelurahan::pluck('name', 'id');

        return view('users.create', compact('roles', 'kelurahans'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required',
            'kelurahan_id' => 'required',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'kelurahan_id' => $validated['kelurahan_id'],
        ]);

        $user->assignRole($validated['role']);

        return redirect()->route('users.index')->with('success', 'User berhasil dibuat.');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::pluck('name', 'id');
        $kelurahans = Kelurahan::pluck('name', 'id');
        $userRole = DB::table('model_has_roles')
        ->where('model_id', $user->id)
        ->select('role_id')
        ->first();

        return view('users.edit', compact('user', 'roles', 'kelurahans', 'userRole'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'password' => 'nullable|string|min:6|confirmed',
            'kelurahan_id' => 'required|integer',
            'role' => 'required|integer',
        ]);

        $user = User::findOrFail($id);

        User::where('id', $id)->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $request->filled('password') ? Hash::make($validated['password']) : $user->password,
            'kelurahan_id' => $validated['kelurahan_id'],
        ]);

        $roleName = Role::find($validated['role'])->name;
        $user->syncRoles([$roleName]);

        return redirect()->route('users.index')->with('success', 'User berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User berhasil dihapus.');
    }

    public function assignRole(User $user)
    {
        $roles = Role::all();

        return view('users.assign-role', compact('user', 'roles'));
    }

    public function storeAssignedRole(Request $request, User $user)
    {
        $request->validate([
            'roles' => 'array|required',
        ]);

        $user->syncRoles($request->roles);

        return redirect()->route('users.index')->with('success', 'Role berhasil diperbarui');
    }

    // public function assignPermission(User $user)
    // {
    //     $permissions = Permission::all();
    //     return view('users.assign-permission', compact('user', 'permissions'));
    // }

    // public function storeAssignedPermission(Request $request, User $user)
    // {
    //     $request->validate([
    //         'permissions' => 'array|required'
    //     ]);

    //     $user->syncPermissions($request->permissions);

    //     return redirect()->route('users.index')->with('success', 'Permission berhasil diperbarui');
    // }

}
