<?php

declare(strict_types=1);


namespace Tests\Unit\Ships;


use App\Ships\Destroyer;
use App\Ships\Ship;
use PHPUnit\Framework\TestCase;

final class DestroyerTest extends TestCase
{
    /*
     * Should have id = 1 and length = 4
     */
    public function testDestroyer(): void
    {
        $sut = new Destroyer();
        $this->assertInstanceOf(Ship::class, $sut);
        $this->assertSame(1, $sut->getId());
        $this->assertSame(4, $sut->getLength());
    }
}
