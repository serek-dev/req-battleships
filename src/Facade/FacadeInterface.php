<?php

declare(strict_types=1);


namespace App\Facade;

use App\Grid\Rendererable;
use Iterator;

interface FacadeInterface
{
    /**
     * @return Rendererable - returns something immutable that can be by rendered
     */
    public function start(): Iterator;

    public function hit(string $cell): Result;
}
