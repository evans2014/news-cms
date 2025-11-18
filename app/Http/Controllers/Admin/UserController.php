<?php

namespace App\Http\Controllers\Admin; // ← ВАЖНО!

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
    public function index()
    {
        $users = User::paginate(20);
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function toggleAdmin(User $user): \Illuminate\Http\RedirectResponse
    {
        $user->update([
            'is_admin' => !$user->is_admin
        ]);

        return back()->with('success', 'Ролята е променена успешно!');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'is_admin' => 'boolean',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'is_admin' => $request->is_admin ?? false,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Потребителят е създаден!');
    }

    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }


  /*  public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            //'password' => 'nullable|min:8|confirmed',
            'is_admin' => 'boolean',
        ]);

        $data = $request->only('name', 'email', 'is_admin');
        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'Потребителят е обновен!');
    }*/
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'                  => 'required|string|max:255',
            'email'                 => 'required|email|unique:users,email,' . $user->id,
            'is_admin'              => 'sometimes|boolean',
            'password'              => 'nullable|min:6|confirmed',
            'password_confirmation' => 'nullable',
        ]);

        $data = [
            'name'     => $request->name,
            'email'    => $request->email,
            'is_admin' => $request->boolean('is_admin'),
        ];

        // Само ако е попълнена парола – хешираме и записваме
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')
            ->with('success', 'Потребителят е обновен успешно!');
    }
    /*public function update(Request $request, User $user)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'is_admin' => 'sometimes|in:1,0', // или просто nullable
        ]);

        $user->update([
            'name'     => $request->name,
            'email'    => $request->email,
            // ← ТОВА Е КЛЮЧЪТ – винаги слагаме 1 или 0
            'is_admin' => $request->has('is_admin') ? true : false,
            // или още по-ясно:
            // 'is_admin' => $request->boolean('is_admin'),
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'Потребителят е обновен успешно!');
    }*/

    /*
     * не update
     * public function update(Request $request, User $user)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'is_admin' => 'sometimes|boolean',
        ]);

        $user->update([
            'name'     => $request->name,
            'email'    => $request->email,
            'is_admin' => $request->has('is_admin') ? true : false,
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'Потребителят е обновен успешно!');
    }*/

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Не можете да изтриете себе си!');
        }

        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Потребителят е изтрит!');
    }
    public function registration()
    {
        return view('admin.registration');

    }
    public function registerStore(Request $request)
    {
       /* $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);*/
        $request->validate([
            'name'                  => 'required|string|max:255',
            'email'                 => 'required|email|unique:users,email',
            'password'              => 'required|min:6|confirmed', // ← confirmed е задължително!
            'password_confirmation' => 'required',                  // ← това поле трябва да има във формата!
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'is_admin' => false, // ако имаш такава колона
        ]);

        Auth::login($user);

        return redirect()->route('home')->with('success', 'Регистрацията е успешна!');
    }

}