<?php

declare(strict_types=1);

namespace App\Infrastructure\Enums;

use MyCLabs\Enum\Enum;

class LogTypes extends Enum
{
    public const LOGIN = 'login';
    public const LOGOUT = 'logout';
    public const FORCE_LOGOUT = 'force_logout';
    public const STAY_ONLINE = 'stay_online';
    public const LOGIN_BLOCKED = 'login_blocked';
}
