<?php

namespace Tests\Unit\Grid;

use App\Grid\RandomGridFactory;
use App\Ships\Battleship;
use App\Ships\Destroyer;
use PHPUnit\Framework\TestCase;

final class RandomGridFactoryTest extends TestCase
{
    /*
     * It should create a grid with:
     * 1x Battleship (5 squares)
     * 2x Destroyers (4 squares)
     */
    public function testCreate(): void
    {
        $ships = [$D = new Destroyer(), $B = new Battleship()];
        $sut = (new RandomGridFactory(...$ships))->createGrid();

        $this->assertSame($B->getLength() * $B->getCount(), $sut->countObjects($B->getId()));
        $this->assertSame($D->getLength() * $D->getCount(), $sut->countObjects($D->getId()));
    }
}
