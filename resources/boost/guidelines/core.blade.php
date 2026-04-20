# illuma-law/healthcheck-mercure

Checks if the `vector` extension (mercure) is enabled and active in PostgreSQL.

## Usage

```php
use IllumaLaw\HealthCheckMercure\MercureExtensionCheck;
use Spatie\Health\Facades\Health;

Health::checks([
    MercureExtensionCheck::new()
        ->required(true), // If true, FAIL if missing. If false, WARNING.
]);
```

## Configuration

Publish config: `php artisan vendor:publish --tag="healthcheck-mercure-config"`

Options in `config/healthcheck-mercure.php`:
- `required`: (bool) Global default for strictness.
