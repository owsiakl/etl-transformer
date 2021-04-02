<?php

declare(strict_types=1);

namespace Flow\ETL\Adapter\Filter;

use Flow\ETL\Row;

/**
 * @psalm-immutable
 */
interface Filter
{
    public function __invoke(Row $row) : bool;
}
