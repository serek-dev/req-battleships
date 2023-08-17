<?php

declare(strict_types=1);


namespace Tests\Acceptance;


use App\Facade\FacadeInterface;
use App\Facade\GameFacade;
use App\Grid\RandomGridFactory;
use App\Service\Service;
use App\Ships\Battleship;
use App\Ships\Destroyer;
use PHPUnit\Framework\TestCase;

/*
 * Background:
 *
 * The challenge is to program a simple version of the game Battleships (video).
 * Create an application to allow a single human player to play a one-sided game of Battleships against ships placed by the computer.
 */

final class AcceptanceTest extends TestCase
{
    private FacadeInterface $game;

    private FacadeInterface $hardcodedGame;

    protected function setUp(): void
    {
        $ships = [new Destroyer(), new Battleship()];

        // Real life case
        $grid = (new RandomGridFactory(...$ships))->createGrid();
        $this->game = new GameFacade(
            service: new Service($grid, ...$ships),
        );

        // Hardcoded case
        $grid = (new StaticGridFactory())->createGrid();
        $this->hardcodedGame = new GameFacade(
            service: new Service($grid, ...$ships),
        );
    }

    /*
     * The program should create a 10x10 grid
     */
    public function testGridIs10x10Dimensions(): void
    {
        $this->assertSame('ERROR', $this->game->hit('A11')->status);
        $this->assertSame('ERROR', $this->game->hit('K0')->status);
    }

    /*
     * The player enters or selects coordinates of the form “A5”, where “A” is the column and “5” is the row,
     * to specify a square to target. Shots result in hits, misses or sinks.
     */
    public function testShootResultsInHitMissedSink(): void
    {
        $this->assertSame('MISSED', $this->hardcodedGame->hit('J9')->status);
        $this->assertSame('HIT', $this->hardcodedGame->hit('A0')->status);

        $this->hardcodedGame->hit('A0');
        $this->hardcodedGame->hit('B0');
        $this->hardcodedGame->hit('C0');
        $this->hardcodedGame->hit('D0');
        $this->assertSame('SUNK', $this->hardcodedGame->hit('E0')->status);
    }

    /*
     * The game ends when all ships are sunk.
     */
    public function testGameFinishes(): void
    {
        $startColumn = ord('A');
        $endColumn = ord('J');
        $rowCount = 10;

        $hasGameEnded = false;

        for ($rowNumber = 0; $rowNumber < $rowCount; $rowNumber++) {
            for ($i = $startColumn; $i <= $endColumn; $i++) {
                $column = chr($i);
                $cell = $column . $rowNumber;
                $result = $this->game->hit($cell);
                if ($result->status === 'WON') {
                    $hasGameEnded = true;
                }
            }
        }
        $this->assertTrue($hasGameEnded);
    }
}
