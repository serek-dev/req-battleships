<?php

declare(strict_types=1);


namespace App\Ships;

interface Ship
{
    public function getId(): int;

    public function getLength(): int;

    public function getCount(): int;
}
