<?php

declare(strict_types=1);


namespace App\Grid;


use App\Exceptions\OutOfBound;
use Stringable;

final class Cell implements Stringable
{
    public function __construct(
        public readonly int $col,
        public readonly int $row,
    ) {
        if ($col < 0 || $col > 9 || $row < 0 || $row > 9) {
            throw new OutOfBound(
                'Grid values must be in range 0-9'
            );
        }
    }

    public static function from(string $pos): self
    {
        $columnAsLetter = strtoupper(substr($pos, 0, 1));
        $row = substr($pos, 1, 2);
        $letterAsNumber = ord($columnAsLetter) - ord('A');

        return new self($letterAsNumber, (int)$row);
    }

    public function __toString(): string
    {
        return chr($this->col + ord('A')) . $this->row;
    }
}
