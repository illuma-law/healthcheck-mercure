---
description: Mercure hub reachability health check for Spatie Laravel Health
---

# healthcheck-mercure

Mercure hub reachability health check for `spatie/laravel-health`. Verifies the hub URL returns a successful HTTP response.

## Namespace

`IllumaLaw\HealthCheckMercure`

## Key Check

- `MercureCheck` — HTTP GET to the configured Mercure hub; validates 2xx status

## Registration

```php
use IllumaLaw\HealthCheckMercure\MercureCheck;
use Spatie\Health\Facades\Health;

Health::checks([
    MercureCheck::new(),
]);
```

## Notes

- Reads hub URL from `MERCURE_URL` or the configured Mercure connection.
- Respects configurable timeout to prevent the check from hanging.
- Returns `failed` (not `warning`) if the hub is unreachable, since Mercure is required for realtime features.
