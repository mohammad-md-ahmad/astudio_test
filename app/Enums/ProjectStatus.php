<?php

declare(strict_types=1);

namespace App\Enums;

enum ProjectStatus
{
    case Active;
    case Inactive;
    case Completed;

    public static function toArray()
    {
        return [
            self::Active->name,
            self::Inactive->name,
            self::Completed->name,
        ];
    }
}
