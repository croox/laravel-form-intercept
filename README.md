# Laravel Form Intercept

Intercept outgoing form emails containing specific keywords and redirect them to a tech email address. Useful for testing contact forms on client sites without emails reaching the actual client.

## Requirements

- PHP 8.1+
- Laravel 10, 11, or 12

## Installation

Add the repository to your `composer.json`:

```json
"repositories": [
    {
        "type": "vcs",
        "url": "git@github.com:croox/laravel-form-intercept.git"
    }
]
```

Then install via Composer:

```bash
composer require croox/laravel-form-intercept:dev-main
```

The service provider is auto-discovered — no manual registration needed.

## Configuration

Add these environment variables to your `.env`:

```env
FORM_INTERCEPT_ENABLED=true
FORM_INTERCEPT_EMAIL=tech@croox.com
```

To customize the keywords, publish the config file:

```bash
php artisan vendor:publish --tag=form-intercept-config
```

This creates `config/form-intercept.php` where you can modify the keyword list:

```php
'keywords' => [
    '[TEST]',
    '--test--',
],
```

## How It Works

The package listens to Laravel's `MessageSending` event. Before any email is sent, it checks the subject and body for configured keywords (case-insensitive). If a match is found:

1. All recipients (to, cc, bcc) are replaced with the tech email
2. The subject is prefixed with `[INTERCEPTED]`

Emails without keywords pass through completely untouched.

## Usage

Simply include one of the configured keywords anywhere in your form submission. For example, type `[TEST]` in the message field or subject when filling out a contact form. The email will be redirected to the configured tech email instead of the client.

## How It Looks

| Scenario | Recipient | Subject |
|---|---|---|
| Normal submission | `client@example.com` | `Kontaktformular` |
| With keyword | `tech@croox.com` | `[INTERCEPTED] Kontaktformular` |
