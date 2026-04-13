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

];
