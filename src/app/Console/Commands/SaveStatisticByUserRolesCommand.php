<?php

namespace App\Console\Commands;

use App\Infrastructure\Enums\UserRoles;
use App\Models\User;
use App\Models\UserLogs;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class SaveStatisticByUserRolesCommand extends Command
{
    protected $signature = 'cron:user-roles-stat';

    protected $description = 'Сохраняет статистику по пользователям';

    public function handle()
    {
        $result = [
            UserRoles::ADMINISTRATOR => 0,
            UserRoles::OFFICE_USER => 0
        ];
        $users = User::all();
        $date = now();
        foreach ($users as $user) {
            if (UserLogs::isActiveByMonth($date, $user->id)){
                $result[$user->role->title]++;
            }
        }
        DB::table('user_stats')->updateOrInsert([
            'month' => $date->toDateString(),
            'user_by_roles' => Collection::make($result)->toJson()
        ]);
    }
}
