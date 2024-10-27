<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;

class UserListController extends Controller
{
    public function index()
    {
        $list_users = User::select('id', 'name', 'email', 'role', 'created_at', 'updated_at')->get();
        return view('admin.list-user', compact('list_users'));
    }
    public function edit($id)
    {
        $register = User::find($id);
        return view('admin.edit-user', compact('register'));
    }
    public function delete($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        session()->flash('success', 'Data berhasil dihapus');
        return redirect()->route('admin.list-user');
    }

    public function create()
    {
        return view('admin.create-user');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'role' => ['required', 'in:admin,user'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'email_verified_at' => now(),
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);
        session()->flash('success', 'Berhasil menambahkan user!.');
        return redirect()->route('admin.list-user');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $user = User::findOrFail($id);
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);
        $user->save();
        session()->flash('success', 'Data berhasil diubah');
        return redirect()->route('admin.list-user');
    }

}
