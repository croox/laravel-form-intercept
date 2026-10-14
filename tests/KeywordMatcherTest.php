<?php

namespace Croox\FormIntercept\Tests;

use Croox\FormIntercept\KeywordMatcher;
use PHPUnit\Framework\TestCase;

class KeywordMatcherTest extends TestCase
{
    private array $config = [
        'tech_email' => 'tech@example.com',
        'monitor_email' => 'monitor@example.com',
        'keywords' => ['[TEST]', '--test--'],
        'monitor_keywords' => ['[MONITOR]'],
    ];

    public function test_no_keyword_returns_null(): void
    {
        $this->assertNull(KeywordMatcher::recipientFor('A real inquiry', $this->config));
    }

    public function test_test_keyword_goes_to_tech_email(): void
    {
        $this->assertSame('tech@example.com', KeywordMatcher::recipientFor('Hi [test] there', $this->config));
    }

    public function test_monitor_keyword_goes_to_monitor_email(): void
    {
        $this->assertSame('monitor@example.com', KeywordMatcher::recipientFor('[MONITOR] monitor-123', $this->config));
    }

    public function test_monitor_keyword_wins_over_test_keyword(): void
    {
        $this->assertSame('monitor@example.com', KeywordMatcher::recipientFor('[TEST] [MONITOR]', $this->config));
    }

    public function test_monitor_keyword_falls_back_to_tech_email_without_monitor_email(): void
    {
        $config = ['monitor_email' => null] + $this->config;

        $this->assertSame('tech@example.com', KeywordMatcher::recipientFor('[MONITOR] monitor-123', $config));
    }

    public function test_published_config_without_monitor_keys_still_matches_test_keyword(): void
    {
        $config = ['tech_email' => 'tech@example.com', 'keywords' => ['[TEST]']];

        $this->assertSame('tech@example.com', KeywordMatcher::recipientFor('[TEST]', $config));
        $this->assertNull(KeywordMatcher::recipientFor('[MONITOR]', $config));
    }
}
