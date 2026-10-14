<?php

namespace Croox\FormIntercept\Listeners;

use Croox\FormIntercept\KeywordMatcher;
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

        $recipient = KeywordMatcher::recipientFor($searchable, config('form-intercept'));

        if ($recipient === null) {
            return;
        }

        // Replace all recipients with the intercept address.
        $message->to($recipient);
        $message->cc();
        $message->bcc();

        // Prefix subject so it's clear this was intercepted.
        $message->subject('[INTERCEPTED] ' . $subject);
    }
}
