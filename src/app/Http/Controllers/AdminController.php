<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Infrastructure\Enums\UserRoles;
use App\Models\Office;
use App\Models\User;
use Auth;
use Hash;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function menu()
    {
        $user = Auth::user();

        return view('admin.menu', compact('user'));
    }

    public function getAllUsers(Request $request)
    {
        $office = $request->get('office', 'all');
        if ($office !== 'all') {
            $office = $request->get('office');
            $users = User::where('office_id', '=', $office)->orderBy('id')->get();
        } else {
            $users = User::orderBy('id')->get();
        }
        $offices = Office::all();

        return view('admin.allUsers', compact('users', 'offices', 'office'));
    }

    public function createUser()
    {
        $offices = Office::all();

        return view('admin.createUser', compact('offices'));
    }

    public function changeRole(Request $request)
    {
        $user = User::find($request->get('user_id'));

        if ($user->id === Auth::user()->id) {
            return back()->withErrors(['Нельзя изменить роль себе']);
        }

        $user->update([
            'role_id' => $user->role->id === UserRoles::OFFICE_USER_ID
                ? UserRoles::ADMINISTRATOR_ID
                : UserRoles::OFFICE_USER_ID
        ]);

        return back()->with(['success' => 'Роль изменена']);
    }

    public function blockUser(Request $request)
    {
        $user = User::find($request->get('user_id'));

        if ($user->id === Auth::user()->id) {
            return back()->withErrors(['Нельзя заблокировать себя']);
        }

        if ($user->active) {
            $user->update([
                'active' => false
            ]);
            return back()->with(['success' => 'Пользователь заблокирован']);
        }
        $user->update([
            'active' => true
        ]);
        return back()->with(['success' => 'Пользователь активирован']);
    }

    public function storeUser(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|unique:users',
        ]);

        User::create([
            'email' => $request->get('email'),
            'first_name' => $request->get('first_name'),
            'last_name' => $request->get('last_name'),
            'office_id' => $request->get('office'),
            'birth_date' => $request->get('birth_date'),
            'password' => Hash::make($request->get('password')),
            'active' => true,
            'role_id' => UserRoles::OFFICE_USER_ID
        ]);

        return back()->with(['success' => 'Новый пользователь успешно создан']);
    }
}
