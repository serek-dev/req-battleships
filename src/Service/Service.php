<?php

declare(strict_types=1);


namespace App\Service;


use App\Exceptions\NotFound;
use App\Grid\Cell;
use App\Grid\Grid;
use App\Grid\Rendererable;
use App\Ships\Ship;

final class Service
{
    /** @var Ship[] */
    private array $ships;

    public function __construct(private readonly Grid $grid, Ship ...$ships)
    {
        $this->ships = $ships;
    }

    public function hit(Cell $cell): HitResult
    {
        $objectId = $this->grid->get($cell);

        if ($this->dirty($objectId)) {
            return HitResult::IGNORED;
        }

        if ($this->hasAnyShipBeenHit($objectId)) {
            $this->grid->add(HitResult::HIT->value, $cell);

            $returnStatus = HitResult::HIT;
            if ($this->hasShipBeenSunk($objectId)) {
                $returnStatus = HitResult::SUNK;
            }
        } else {
            $this->grid->add(HitResult::MISSED->value, $cell);
            $returnStatus = HitResult::MISSED;
        }

        if ($this->allShipsDestroyed()) {
            $returnStatus = HitResult::WON;
        }

        return $returnStatus;
    }

    private function hasAnyShipBeenHit(int|string|null $objectId): bool
    {
        return in_array($objectId, $this->getShipIds());
    }

    private function hasShipBeenSunk(int $shipId): bool
    {
        $ship = array_values(array_filter($this->ships, fn(Ship $ship) => $shipId === $ship->getId()))[0] ?? throw new NotFound();

        // We can have a small piece of the ship if was hit
        $shipChunks = $this->grid->countObjects($ship->getId());

        // When no remaining chunks after hit, means it got sunk
        return $shipChunks % $ship->getLength() === 0;
    }

    /** @return int[] */
    private function getShipIds(): array
    {
        return array_map(fn(Ship $ship) => $ship->getId(), $this->ships);
    }

    public function getGrid(): Rendererable
    {
        return clone $this->grid;
    }

    private function allShipsDestroyed(): bool
    {
        return $this->grid->countObjects(...$this->getShipIds()) === 0;
    }

    private function dirty(int|string|null $objectId): bool
    {
        return in_array($objectId, [HitResult::HIT->value, HitResult::MISSED->value]);
    }
}
