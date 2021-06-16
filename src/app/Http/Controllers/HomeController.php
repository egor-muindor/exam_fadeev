<?php

namespace App\Http\Controllers;

use App\Infrastructure\Enums\UserRoles;
use App\Models\Role;

class HomeController extends Controller
{
    public function __invoke()
    {
        $user = \Auth::user();
        /** @var Role $role */
        $role = $user->role()->first();
        return match ($role->id) {
            UserRoles::ADMINISTRATOR_ID => redirect(route('admin.menu')),
            UserRoles::OFFICE_USER_ID => redirect(route('user.menu')),
            default => throw new \LogicException('Невозможно определить роль')
        };
    }
}
