<?php

namespace Croox\FormIntercept\Tests;

use Croox\FormIntercept\Listeners\PreventInterceptedFormStorage;
use PHPUnit\Framework\TestCase;

class SearchableTextTest extends TestCase
{
    public function test_joins_plain_values(): void
    {
        $text = PreventInterceptedFormStorage::searchableText([
            'name' => 'Jane',
            'message' => '[TEST] hello',
        ]);

        $this->assertSame('Jane [TEST] hello', $text);
    }

    public function test_flattens_array_values_from_checkboxes_and_uploads(): void
    {
        $text = PreventInterceptedFormStorage::searchableText([
            'topics' => ['a', 'b'],
            'files' => [['id' => '[TEST] file']],
        ]);

        $this->assertSame('a b [TEST] file', $text);
    }

    public function test_skips_values_that_cannot_be_cast_to_string(): void
    {
        $text = PreventInterceptedFormStorage::searchableText([
            'custom' => new \stdClass,
            'empty' => null,
            'message' => '[TEST]',
        ]);

        $this->assertSame('[TEST]', $text);
    }
}
