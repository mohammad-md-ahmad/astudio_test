<?php

declare(strict_types=1);

namespace App\Enums;

enum AttributeType
{
    case Text;
    case Date;
    case Number;
    case Select;

    public static function toArray(): array
    {
        return [
            self::Text->name,
            self::Date->name,
            self::Number->name,
            self::Select->name,
        ];
    }
}
