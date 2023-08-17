<?php

declare(strict_types=1);


namespace Tests\Unit\Ships;


use App\Ships\Battleship;
use App\Ships\Ship;
use PHPUnit\Framework\TestCase;

final class BattleshipTest extends TestCase
{
    /*
     * Should have id = 2 and length = 5
     */
    public function testBattleship(): void
    {
        $sut = new Battleship();
        $this->assertInstanceOf(Ship::class, $sut);
        $this->assertSame(2, $sut->getId());
        $this->assertSame(5, $sut->getLength());
    }
}
