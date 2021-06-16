<?php

namespace App\Http\Middleware;

use App\Infrastructure\Enums\LogTypes;
use App\Models\UserLogs;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Closure;

class UserActivityMiddleware
{
    public function handle(Request $request, Closure $next): mixed
    {
        $user = \Auth::user();
        if(\Auth::check()) {
            if (Carbon::parse(\Cache::get($user->getOnlineKey()) ?? '00-00-0000') < now()) {
                UserLogs::create([
                    'user_id' => $user->id,
                    'type' => LogTypes::FORCE_LOGOUT,
                ]);
                \Auth::logout();
                return redirect('/');
            }
            $expiresAt = Carbon::now()->addSeconds(15)->toTimeString();
            Cache::put($user->getOnlineKey(), $expiresAt);
        }

        return $next($request);
    }
}
