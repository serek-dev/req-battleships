<?php

declare(strict_types=1);


namespace Tests\Unit\Service;


use App\Grid\Cell;
use App\Grid\Grid;
use App\Service\HitResult;
use App\Service\Service;
use App\Ships\Battleship;
use App\Ships\Destroyer;
use PHPUnit\Framework\TestCase;

/** @covers \App\Service\Service */
final class ServiceTest extends TestCase
{
    /*
     * It should return won status when all objects sunk
     */
    public function testHitReturnsWonStatus(): void
    {
        // I have an empty grid (no ships = won)
        $emptyGrid = new Grid();
        $sut = new Service($emptyGrid, new Destroyer(), new Battleship());
        $this->assertEquals(HitResult::WON, $sut->hit(Cell::from('a1')));
    }

    /*
     * It should return missed status
     */
    public function testHitReturnsMissedStatus(): void
    {
        // I have a grid with one destroyer
        $grid = new Grid();
        $destroyer = new Destroyer();
        $grid->add($destroyer->getId(), Cell::from('a1'));
        $sut = new Service($grid, new Destroyer(), new Battleship());
        $this->assertEquals(HitResult::MISSED, $sut->hit(Cell::from('a2')));
    }

    /*
     * It should return hit status
     */
    public function testHitReturnsHitStatus(): void
    {
        // I have a grid with one destroyer
        $grid = new Grid();
        $destroyer = new Destroyer();
        $grid->add($destroyer->getId(), Cell::from('a1'), Cell::from('a2'));
        $sut = new Service($grid, new Destroyer(), new Battleship());
        $this->assertEquals(HitResult::HIT, $sut->hit(Cell::from('a1')));
    }

    /*
     * It should return sunk status when 1 more ship remaining
     */
    public function testHitReturnsSunkStatusOnRemainingShip(): void
    {
        // I have a grid with two destroyers
        $grid = new Grid();

        $destroyer = new Destroyer();
        $battleship = new Battleship();

        $sinkMe = [Cell::from('a1'), Cell::from('a2'), Cell::from('a3'), Cell::from('a4')];

        $grid->add($destroyer->getId(), ...$sinkMe);
        $grid->add($battleship->getId(), Cell::from('b1'), Cell::from('b2'), Cell::from('b3'), Cell::from('b4'));

        $sut = new Service($grid, $destroyer, $battleship);

        // When I sunk 1 of 2 ships
        $result = null;
        foreach ($sinkMe as $cell) {
            $result = $sut->hit($cell);
        }

        $this->assertEquals(HitResult::SUNK, $result);
    }
}
