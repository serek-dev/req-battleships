<?php

declare(strict_types=1);


namespace App\Ships;


final class Destroyer implements Ship
{
    public function getId(): int
    {
        return 1;
    }

    public function getLength(): int
    {
        return 4;
    }

    public function getCount(): int
    {
        return 2;
    }
}
