<?php

declare(strict_types=1);

namespace Flow\ETL\Transformer\Tests\Unit;

use Flow\ETL\Row;
use Flow\ETL\Rows;
use Flow\ETL\Transformer\RenameEntries\EntryRename;
use Flow\ETL\Transformer\RenameEntriesTransformer;
use PHPUnit\Framework\TestCase;

final class RenameEntriesTransformerTest extends TestCase
{
    public function test_renaming_entries() : void
    {
        $renameTransformer = new RenameEntriesTransformer(
            new EntryRename('old_int', 'new_int'),
            new EntryRename('null', 'nothing')
        );

        $rows = $renameTransformer->transform(
            new Rows(
                Row::create(
                    new Row\Entry\IntegerEntry('old_int', 1000),
                    new Row\Entry\IntegerEntry('id', 1),
                    new Row\Entry\StringEntry('status', 'PENDING'),
                    new Row\Entry\BooleanEntry('enabled', true),
                    new Row\Entry\DateTimeEntry('datetime', new \DateTimeImmutable('2020-01-01 00:00:00 UTC')),
                    new Row\Entry\ArrayEntry('array', ['foo', 'bar']),
                    new Row\Entry\JsonEntry('json', ['foo', 'bar']),
                    new Row\Entry\ObjectEntry('object', new \stdClass()),
                    new Row\Entry\NullEntry('null')
                ),
            ),
        );

        $this->assertEquals(
            new Rows(
                Row::create(
                    new Row\Entry\IntegerEntry('id', 1),
                    new Row\Entry\StringEntry('status', 'PENDING'),
                    new Row\Entry\BooleanEntry('enabled', true),
                    new Row\Entry\DateTimeEntry('datetime', new \DateTimeImmutable('2020-01-01 00:00:00 UTC')),
                    new Row\Entry\ArrayEntry('array', ['foo', 'bar']),
                    new Row\Entry\JsonEntry('json', ['foo', 'bar']),
                    new Row\Entry\ObjectEntry('object', new \stdClass()),
                    new Row\Entry\IntegerEntry('new_int', 1000),
                    new Row\Entry\NullEntry('nothing')
                ),
            ),
            $rows
        );
    }
}
