#!/usr/bin/env php
<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use App\Facade\GameFacade;
use App\Grid\RandomGridFactory;
use App\Service\Service;
use App\Ships\Battleship;
use App\Ships\Destroyer;
use App\Ships\Ship;
use App\UI\GridRenderer;
use App\UI\PlayCommand;
use Symfony\Component\Console\Application;

$application = new Application();

$ships = [new Destroyer(), new Battleship()];
$grid = (new RandomGridFactory(...$ships))->createGrid();

$application->add(
    command: new PlayCommand(
        facade: new GameFacade(
            service: new Service(
                $grid,
                ...$ships,
            )
        ),
        gridRenderer: new GridRenderer(
            (bool)getenv('SHOW') ?? false,
            ...array_map(fn(Ship $ship) => $ship->getId(), $ships)
        )
    )
);

$application->run();
