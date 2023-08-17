<?php

namespace Tests\Unit\Grid;

use App\Exceptions\OutOfBound;
use App\Grid\Cell;
use PHPUnit\Framework\TestCase;

/** @covers \App\Grid\Cell */
final class CellTest extends TestCase
{
    /*
     * I should be able to create from string values
     */
    /** @dataProvider providerForTestFrom */
    public function testFrom(string $value, int $expectedRow, int $expectedCol): void
    {
        $sut = Cell::from($value);
        $this->assertSame($expectedRow, $sut->row);
        $this->assertSame($expectedCol, $sut->col);
    }

    public static function providerForTestFrom(): array
    {
        return [
            'A0' => ['value' => 'A0', 'expectedRow' => 0, 'expectedCol' => 0],
            'B0' => ['value' => 'B0', 'expectedRow' => 0, 'expectedCol' => 1],
            'A1' => ['value' => 'A1', 'expectedRow' => 1, 'expectedCol' => 0],
            'B1' => ['value' => 'B1', 'expectedRow' => 1, 'expectedCol' => 1],
            'J9' => ['value' => 'J9', 'expectedRow' => 9, 'expectedCol' => 9],
            'G3' => ['value' => 'G3', 'expectedRow' => 3, 'expectedCol' => 6],
        ];
    }

    /*
     * I should be able to stringify to a string "0:0"
     */
    public function testStringify(): void
    {
        $sut = new Cell(0, 1);
        $this->assertSame('A1', (string)$sut);
    }

    /*
     * It should fail on invalid range
     */
    /** @dataProvider providerForTestFromFails */
    public function testFailsOnInvalidRange(int $x, int $y): void
    {
        $this->expectException(OutOfBound::class);
        new Cell($x, $y);
    }

    public static function providerForTestFromFails(): array
    {
        return [
            'x is < 0' => ['x' => -1, 'y' => 0],
            'y is < 0' => ['x' => 0, 'y' => -1],
            'x is > 9' => ['x' => 10, 'y' => 0],
            'y is < 9' => ['x' => 0, 'y' => 10],
        ];
    }
}
