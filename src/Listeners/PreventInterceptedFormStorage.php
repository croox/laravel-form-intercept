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

        $submission = $event->submission;
        $searchable = collect($submission->data())->values()->implode(' ');

        foreach (config('form-intercept.keywords', []) as $keyword) {
            if (stripos($searchable, $keyword) !== false) {
                return false;
            }
        }

        return null;
    }
}
