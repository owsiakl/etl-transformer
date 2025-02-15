<?php

declare(strict_types=1);

namespace Flow\ETL\Transformer\Tests\Unit;

use Flow\ETL\Row;
use Flow\ETL\Rows;
use Flow\ETL\Transformer\KeepEntriesTransformer;
use PHPUnit\Framework\TestCase;

final class KeepEntriesTransformerTest extends TestCase
{
    public function test_keeping_entries() : void
    {
        $rows = new Rows(
            Row::create(
                new Row\Entry\IntegerEntry('id', 1),
                new Row\Entry\StringEntry('name', 'Row Name'),
                new Row\Entry\ArrayEntry('array', ['test'])
            )
        );

        $transformer = new KeepEntriesTransformer('name');
        $this->assertSame(
            [
                ['name' => 'Row Name'],
            ],
            $transformer->transform($rows)->toArray()
        );
    }

    public function test_keeping_not_existing_entries() : void
    {
        $rows = new Rows(
            Row::create(
                new Row\Entry\IntegerEntry('id', 1),
                new Row\Entry\StringEntry('name', 'Row Name'),
                new Row\Entry\ArrayEntry('array', ['test'])
            )
        );

        $transformer = new KeepEntriesTransformer('not_existing');
        $this->assertSame(
            [[]],
            $transformer->transform($rows)->toArray()
        );
    }
}
