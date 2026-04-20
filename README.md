# Healthcheck pgvector

[![Tests](https://github.com/illuma-law/healthcheck-pgvector/actions/workflows/run-tests.yml/badge.svg)](https://github.com/illuma-law/healthcheck-pgvector/actions)
[![PHPStan](https://github.com/illuma-law/healthcheck-pgvector/actions/workflows/phpstan.yml/badge.svg)](https://github.com/illuma-law/healthcheck-pgvector/actions)
[![Packagist License](https://img.shields.io/badge/Licence-MIT-blue)](http://choosealicense.com/licenses/mit/)
[![Latest Stable Version](https://img.shields.io/packagist/v/illuma-law/healthcheck-pgvector?label=Version)](https://packagist.org/packages/illuma-law/healthcheck-pgvector)

**Focused pgvector extension health check for [Spatie's Laravel Health](https://github.com/spatie/laravel-health) package**

This package provides a single, focused health check that verifies whether the `vector` PostgreSQL extension (pgvector) is installed in your database, reports its version when present, and optionally treats its absence as a hard failure instead of a warning.

---

- [Requirements](#requirements)
- [Installation](#installation)
- [Configuration](#configuration)
- [Usage](#usage)
  - [Basic Registration](#basic-registration)
  - [Fluent Configuration](#fluent-configuration)
  - [Result States](#result-states)
- [Testing](#testing)
- [Changelog](#changelog)
- [Security](#security)
- [Credits](#credits)
- [License](#license)

---

## Requirements

- **PHP** 8.2 or higher
- **Laravel** 11, 12, or 13
- **spatie/laravel-health** ^1.39
- A PostgreSQL database

## Installation

Require the package via Composer:

```bash
composer require illuma-law/healthcheck-pgvector
```

Publish the config file:

```bash
php artisan vendor:publish --tag="healthcheck-pgvector-config"
```

## Configuration

The published config file at `config/healthcheck-pgvector.php` exposes a single option:

```php
return [
    /*
     * Whether the pgvector extension is required.
     * When true, the check fails if the extension is not installed.
     * When false, a missing extension produces a warning instead.
     */
    'required' => env('HEALTH_PGVECTOR_REQUIRED', false),
];
```

Set `HEALTH_PGVECTOR_REQUIRED=true` in your `.env` file to treat a missing pgvector extension as a hard failure in production.

## Usage

### Basic Registration

Register the check inside your application's health service provider or wherever you configure [Spatie Laravel Health](https://github.com/spatie/laravel-health):

```php
use IllumaLaw\HealthCheckPgvector\PgvectorExtensionCheck;
use Spatie\Health\Facades\Health;

Health::checks([
    PgvectorExtensionCheck::new(),
]);
```

### Fluent Configuration

Override the config value at registration time using the fluent `required()` method:

```php
use IllumaLaw\HealthCheckPgvector\PgvectorExtensionCheck;
use Spatie\Health\Facades\Health;

Health::checks([
    // Hard-fail in this environment regardless of config
    PgvectorExtensionCheck::new()->required(true),

    // Only warn when missing (default behaviour)
    PgvectorExtensionCheck::new()->required(false),
]);
```

### Result States

| State | Condition |
| :--- | :--- |
| **Ok** | pgvector is installed — short summary reports the installed version |
| **Warning** | pgvector is not installed and `required` is `false` |
| **Failed** | pgvector is not installed and `required` is `true` |
| **Failed** | The query to `pg_extension` throws an exception |

## Testing

The package ships with a Pest test suite. To run it locally, install dependencies first:

```bash
composer install
```

Run the full test suite:

```bash
composer test
```

Run tests with code coverage:

```bash
composer test-coverage
```

Run static analysis:

```bash
composer analyse
```

Apply code style fixes:

```bash
composer format
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Security

If you discover any security related issues, please email support@illuma.law instead of using the issue tracker.

## Credits

- [illuma-law](https://github.com/illuma-law)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
