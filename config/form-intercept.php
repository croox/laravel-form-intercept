<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Enable Form Email Interception
    |--------------------------------------------------------------------------
    |
    | When enabled, outgoing emails that contain any of the configured
    | keywords in their subject or body will be redirected to the tech email.
    |
    */

    'enabled' => env('FORM_INTERCEPT_ENABLED', true),

    /*
    |--------------------------------------------------------------------------
    | Tech Email
    |--------------------------------------------------------------------------
    |
    | The email address that intercepted emails will be sent to.
    |
    */

    'tech_email' => env('FORM_INTERCEPT_EMAIL', 'tech@croox.com'),

    /*
    |--------------------------------------------------------------------------
    | Keywords
    |--------------------------------------------------------------------------
    |
    | If any of these keywords are found in the email subject or body,
    | the email will be intercepted and redirected to the tech email.
    | Case-insensitive matching is used.
    |
    */

    'keywords' => [
        '[TEST]',
        '--test--',
    ],

    /*
    |--------------------------------------------------------------------------
    | Monitor Email and Keywords
    |--------------------------------------------------------------------------
    |
    | Automated checks (croox/form-monitor) use these keywords so their mails
    | go to a separate mailbox the bot can read, keeping manual [TEST] mails
    | in the tech email. Without a monitor email they fall back to the tech email.
    |
    */

    'monitor_email' => env('FORM_INTERCEPT_MONITOR_EMAIL'),

    'monitor_keywords' => [
        '[MONITOR]',
    ],

    /*
    |--------------------------------------------------------------------------
    | Prevent Form Storage
    |--------------------------------------------------------------------------
    |
    | When enabled, intercepted form submissions will not be stored
    | in the application's form storage (e.g. Statamic's storage/forms).
    |
    */

    'prevent_form_storage' => env('FORM_INTERCEPT_PREVENT_STORAGE', true),

];
