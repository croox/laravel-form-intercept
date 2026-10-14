<?php

namespace Croox\FormIntercept;

class KeywordMatcher
{
    /**
     * Return the address a message or submission containing $text should go to,
     * or null when it contains no keyword.
     *
     * Monitor keywords are checked first and go to the monitor email, falling
     * back to the tech email so a site without FORM_INTERCEPT_MONITOR_EMAIL
     * still never mails the client. Matching is case-insensitive.
     */
    public static function recipientFor(string $text, array $config): ?string
    {
        foreach ($config['monitor_keywords'] ?? [] as $keyword) {
            if (stripos($text, $keyword) !== false) {
                return ($config['monitor_email'] ?? null) ?: $config['tech_email'];
            }
        }

        foreach ($config['keywords'] ?? [] as $keyword) {
            if (stripos($text, $keyword) !== false) {
                return $config['tech_email'];
            }
        }

        return null;
    }
}
