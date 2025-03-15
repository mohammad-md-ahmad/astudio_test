<?php

declare(strict_types=1);

namespace App\Enums;

enum AttributeType
{
    case Text;
    case Date;
    case Number;
    case Select;
}
