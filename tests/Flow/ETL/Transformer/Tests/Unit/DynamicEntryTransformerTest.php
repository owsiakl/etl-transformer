<?php

declare(strict_types=1);

namespace Flow\ETL\Transformer\Tests\Unit;

use Flow\ETL\Row;
use Flow\ETL\Rows;
use Flow\ETL\Transformer\DynamicEntryTransformer;
use PHPUnit\Framework\TestCase;

final class DynamicEntryTransformerTest extends TestCase
{
    public function test_adding_new_entries() : void
    {
        $transformer = new DynamicEntryTransformer(
            fn (Row $row) : Row\Entries => new Row\Entries(new Row\Entry\DateTimeEntry('updated_at', new \DateTimeImmutable('2020-01-01 00:00:00 UTC')))
        );

        $rows = $transformer->transform(new Rows(
            Row::create(new Row\Entry\IntegerEntry('id', 1)),
            Row::create(new Row\Entry\IntegerEntry('id', 2)),
        ));

        $this->assertSame(
            [
                ['id' => 1, 'updated_at' => '2020-01-01T00:00:00+00:00'],
                ['id' => 2, 'updated_at' => '2020-01-01T00:00:00+00:00'],
            ],
            $rows->toArray()
        );
    }
}
