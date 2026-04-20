<?php

declare(strict_types=1);

return [
    /*
     * Whether the mercure connectivity is required.
     * If true, the check will fail if unreachable.
     * If false, it will only result in a warning.
     */
    'required' => env('HEALTH_MERCURE_REQUIRED', false),
];
