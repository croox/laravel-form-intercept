<?php

namespace Croox\FormIntercept\Listeners;

use Illuminate\Mail\Events\MessageSending;

class InterceptFormEmail
{
    /**
     * Handle the event.
     */
    public function handle(MessageSending $event): void
    {
        if (! config('form-intercept.enabled')) {
            return;
        }

        $message = $event->message;
        $subject = $message->getSubject() ?? '';
        $body = $message->getHtmlBody() ?? $message->getTextBody() ?? '';
        $searchable = $subject . ' ' . $body;

        foreach (config('form-intercept.keywords', []) as $keyword) {
            if (stripos($searchable, $keyword) !== false) {
                $techEmail = config('form-intercept.tech_email');

                // Replace all recipients with the tech email.
                $message->to($techEmail);
                $message->cc();
                $message->bcc();

                // Prefix subject so it's clear this was intercepted.
                $message->subject('[INTERCEPTED] ' . $subject);

                return;
            }
        }
    }
}
