<?php

declare(strict_types=1);


namespace App\Facade;


use Iterator;

final class Result
{
    public const MISSED = 'MISSED';
    public const HIT = 'HIT';
    public const SUNK = 'SUNK';
    public const WON = 'WON';
    public const ERROR = 'ERROR';
    public const IGNORED = 'IGNORED';

    public function __construct(
        /** MISSED, HIT, SUNK, WON, ERROR, IGNORED */
        public readonly string $status,
        public readonly Iterator $grid,
        public readonly ?string $details = null,
    ) {
    }
}
