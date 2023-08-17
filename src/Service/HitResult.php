<?php

declare(strict_types=1);

namespace App\Service;

enum HitResult: string
{
    case MISSED = 'M';
    case HIT = 'H';
    case SUNK = 'S';
    case WON = 'W';
    case IGNORED = 'I';
}
