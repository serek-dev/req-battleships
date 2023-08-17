<?php

declare(strict_types=1);


namespace App\Ships;


final class Battleship implements Ship
{
    public function getId(): int
    {
        return 2;
    }

    public function getLength(): int
    {
        return 5;
    }

    public function getCount(): int
    {
        return 1;
    }
}
