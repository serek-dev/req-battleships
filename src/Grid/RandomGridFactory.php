<?php

declare(strict_types=1);


namespace App\Grid;


use App\Ships\Ship;

final class RandomGridFactory
{
    private const HORIZONTAL = 0;
    private const VERTICAL = 1;

    /** @var Ship[] */
    private array $ships;

    public function __construct(Ship ...$ships)
    {
        $this->ships = $ships;
    }

    public function createGrid(): Grid
    {
        $grid = new Grid();

        $createCells = function (Ship $ship) {
            $x = rand(0, 9 - $ship->getLength());
            $y = rand(0, 9 - $ship->getLength());
            $randomFirstCell = new Cell($x, $y);
            $direction = rand(self::VERTICAL, self::HORIZONTAL);

            $nextCells = [];

            for ($c = 0; $c < $ship->getLength(); $c++) {
                if ($direction === self::VERTICAL) {
                    $nextCells[] = new Cell($x++, $y);
                } else {
                    $nextCells[] = new Cell($x, $y++);
                }
            }

            return array_merge([$randomFirstCell], $nextCells);
        };

        foreach ($this->ships as $ship) {
            $shipCount = 0;
            while ($shipCount < $ship->getCount()) {
                do {
                    $cells = $createCells($ship);
                } while (!$grid->isEmpty(...$cells));

                $grid->add($ship->getId(), ...$cells);
                $shipCount++;
            }
        }

        return $grid;
    }
}
