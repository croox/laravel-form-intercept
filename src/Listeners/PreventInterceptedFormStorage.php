<?php

namespace Croox\FormIntercept\Listeners;

use Statamic\Events\SubmissionCreating;

class PreventInterceptedFormStorage
{
    /**
     * Handle the event.
     *
     * Returning false prevents Statamic from storing the submission
     * while still allowing emails to be sent.
     */
    public function handle(SubmissionCreating $event): ?bool
    {
        if (! config('form-intercept.enabled')) {
            return null;
        }

        if (! config('form-intercept.prevent_form_storage')) {
            return null;
        }

        $searchable = self::searchableText(collect($event->submission->data())->all());

        foreach (config('form-intercept.keywords', []) as $keyword) {
            if (stripos($searchable, $keyword) !== false) {
                return false;
            }
        }

        return null;
    }

    /**
     * Join all submission values into one string to search for keywords.
     *
     * Flattened first: checkbox groups, multi-selects and uploads hold arrays.
     * Values that cannot be cast to string (e.g. custom fieldtype objects) are skipped.
     */
    public static function searchableText(array $data): string
    {
        return collect($data)
            ->flatten()
            ->filter(fn ($value) => is_scalar($value) || $value instanceof \Stringable)
            ->implode(' ');
    }
}
