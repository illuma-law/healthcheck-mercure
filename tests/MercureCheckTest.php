<?php

declare(strict_types=1);

use IllumaLaw\HealthCheckMercure\MercureCheck;
use Illuminate\Support\Facades\Http;
use Spatie\Health\Enums\Status;

beforeEach(function () {
    config()->set('broadcasting.connections.mercure.url', '');
    config()->set('broadcasting.connections.mercure.public_url', '');
    config()->set('health.mercure.probe_topic', 'health-check');
    config()->set('health.mercure.timeout_seconds', 5);
});

it('fails when mercure hub url is not configured', function () {
    $result = MercureCheck::new()->run();

    expect($result->status)->toEqual(Status::failed());
});

it('succeeds when mercure hub is reachable', function () {
    config()->set('broadcasting.connections.mercure.url', 'http://mercure.test');
    
    Http::fake([
        'mercure.test*' => Http::response('ok', 200),
    ]);

    $result = MercureCheck::new()->run();

    expect($result->status)->toEqual(Status::ok());
});

it('fails when mercure hub returns error', function () {
    config()->set('broadcasting.connections.mercure.url', 'http://mercure.test');
    
    Http::fake([
        'mercure.test*' => Http::response('error', 500),
    ]);

    $result = MercureCheck::new()->run();

    expect($result->status)->toEqual(Status::failed());
});

it('fails when mercure hub is unreachable', function () {
    config()->set('broadcasting.connections.mercure.url', 'http://mercure.test');
    
    Http::fake([
        'mercure.test*' => function () {
            throw new \Exception('Unreachable');
        },
    ]);

    $result = MercureCheck::new()->run();

    expect($result->status)->toEqual(Status::failed());
});
