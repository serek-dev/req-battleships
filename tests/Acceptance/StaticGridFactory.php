<?php

declare(strict_types=1);


namespace Tests\Acceptance;


use App\Grid\Cell;
use App\Grid\Grid;

final class StaticGridFactory
{
    public function createGrid(): Grid
    {
        $grid = new Grid();

        // Battleships
        $grid->add(
            2,
            Cell::from('A0'),
            Cell::from('B0'),
            Cell::from('C0'),
            Cell::from('D0'),
            Cell::from('E0'),
        );

        // Destroyers
        $grid->add(
            1,
            Cell::from('G0'),
            Cell::from('H0'),
            Cell::from('I0'),
            Cell::from('J0'),
        );

        $grid->add(
            1,
            Cell::from('B2'),
            Cell::from('C2'),
            Cell::from('D2'),
            Cell::from('E2'),
        );

        return $grid;
    }
}
