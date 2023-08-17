<?php

declare(strict_types=1);


namespace Tests\Unit\Grid;


use App\Grid\Cell;
use App\Grid\Grid;
use App\Grid\Rendererable;
use Iterator;
use PHPUnit\Framework\TestCase;

/** @covers \App\Grid\Grid */
final class GridTest extends TestCase
{
    /*
     * Grid should be iterable, so I can foreach on it
     */
    public function testIsIterable(): void
    {
        $sut = new Grid();
        $this->assertInstanceOf(Iterator::class, $sut);
        $this->assertInstanceOf(Rendererable::class, $sut);
    }

    /*
     * I should be able to add any object
     */
    public function testAddObject(): void
    {
        $sut = new Grid();
        $sut->add('x', new Cell(0, 0), new Cell(1, 0));
        $this->assertSame(2, $sut->countObjects('x'));
    }

    /*
     * I should be able to count objects
     */
    public function testCountObjects(): void
    {
        $sut = new Grid();
        $sut->add(1, new Cell(0, 0), new Cell(1, 0));
        $sut->add(2, new Cell(2, 0), new Cell(3, 0), new Cell(4, 0),);

        $this->assertSame(2, $sut->countObjects(1));
        $this->assertSame(3, $sut->countObjects(2));
    }

    /*
     * I should be able to get saved value or return null when not defined
     */
    public function testGet(): void
    {
        $sut = new Grid();
        $stringCell = new Cell(0, 0);
        $nullCell = new Cell(1, 0);
        $intCell = new Cell(2, 0);
        $sut->add('D', $stringCell);
        $sut->add(1, $intCell);

        $this->assertSame('D', $sut->get($stringCell));
        $this->assertSame(1, $sut->get($intCell));
        $this->assertNull($sut->get($nullCell));
    }
}
