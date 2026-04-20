<?php

declare(strict_types=1);

namespace IllumaLaw\HealthCheckMercure;

use Illuminate\Support\Facades\Http;
use Spatie\Health\Checks\Check;
use Spatie\Health\Checks\Result;

final class MercureCheck extends Check
{
    /**
     * {@inheritdoc}
     */
    public function run(): Result
    {
        $publicUrl = config()->string('broadcasting.connections.mercure.public_url');
        $hubUrl = $publicUrl !== ''
            ? $publicUrl
            : config()->string('broadcasting.connections.mercure.url');

        if ($hubUrl === '') {
            return Result::make()->failed(__('filament/hub/health_check_results.mercure.not_configured'));
        }

        $topic = config()->string('health.mercure.probe_topic');
        $timeoutSeconds = max(1, config()->integer('health.mercure.timeout_seconds'));

        try {
            $response = Http::timeout($timeoutSeconds)
                ->withHeaders(['Accept' => 'text/event-stream'])
                ->get($hubUrl, ['topic' => $topic]);
        } catch (\Throwable $e) {
            return Result::make()->failed(__('filament/hub/health_check_results.mercure.unreachable', [
                'message' => $e->getMessage(),
            ]));
        }

        $status = $response->status();

        if ($status === 0) {
            return Result::make()->failed(__('filament/hub/health_check_results.mercure.empty_status'));
        }

        if ($status < 200 || $status >= 300) {
            if ($status >= 500) {
                return Result::make()->failed(__('filament/hub/health_check_results.mercure.server_error', [
                    'code' => $status,
                ]));
            }

            return Result::make()->failed(__('filament/hub/health_check_results.mercure.bad_client', [
                'code' => $status,
            ]));
        }

        return Result::make()->ok(__('filament/hub/health_check_results.mercure.ok'));
    }
}
