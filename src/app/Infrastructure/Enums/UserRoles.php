<?php

declare(strict_types=1);

namespace App\Infrastructure\Enums;

use MyCLabs\Enum\Enum;

class UserRoles extends Enum
{
    public const ADMINISTRATOR_ID = 1;
    public const ADMINISTRATOR = 'Administrator';
    public const OFFICE_USER_ID = 2;
    public const OFFICE_USER = 'User';
}
