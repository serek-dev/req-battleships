<?php

declare(strict_types=1);


namespace App\Facade;


use App\Grid\Cell;
use App\Grid\Rendererable;
use App\Service\Service;
use Throwable;

final class GameFacade implements FacadeInterface
{
    public function __construct(private readonly Service $service)
    {
    }

    public function start(): Rendererable
    {
        return $this->service->getGrid();
    }

    public function hit(string $cell): Result
    {
        try {
            $status = $this->service->hit(Cell::from($cell));
            return new Result(
                $status->name,
                $this->service->getGrid(),
                $status->name === Result::IGNORED ? 'This position has already been hit, ignoring' : null,
            );
        } catch (Throwable $e) {
            return new Result(Result::ERROR, $this->service->getGrid(), $e->getMessage());
        }
    }
}
