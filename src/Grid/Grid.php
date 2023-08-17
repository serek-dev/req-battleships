<?php

declare(strict_types=1);

namespace App\Grid;

use App\Exceptions\OutOfBound;

final class Grid implements Rendererable
{
    private array $data;
    private int $position;

    public function __construct()
    {
        $this->data = [];
        $this->position = 0;

        for ($row = 0; $row < 10; $row++) {
            for ($col = 0; $col < 10; $col++) {
                $this->data[$row][$col] = null;
            }
        }
    }

    /** @throws OutOfBound */
    public function add(string|int $element, Cell ...$cells): void
    {
        foreach ($cells as $c) {
            $this->data[$c->row][$c->col] = $element;
        }
    }

    public function rewind(): void
    {
        $this->position = 0;
    }

    public function current(): array|string|int|null
    {
        return $this->data[$this->position];
    }

    public function key(): int
    {
        return $this->position;
    }

    public function next(): void
    {
        ++$this->position;
    }

    public function valid(): bool
    {
        return isset($this->data[$this->position]);
    }

    public function countObjects(int|string ...$objects): int
    {
        $count = 0;

        foreach ($this as $gridData) {
            foreach ($gridData as $value) {
                if (in_array($value, $objects)) {
                    $count++;
                }
            }
        }

        return $count;
    }

    public function get(Cell $cell): string|int|null
    {
        return $this->data[$cell->row][$cell->col];
    }

    public function isEmpty(Cell ...$cells): bool
    {
        foreach ($cells as $cell) {
            if (!is_null($this->data[$cell->row][$cell->col])) {
                return false;
            }
        }

        return true;
    }
}
