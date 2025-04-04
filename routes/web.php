<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Prometheus\CollectorRegistry;
use Prometheus\RenderTextFormat;
use Prometheus\Storage\APC;

Route::prefix('api')->group(base_path('routes/api.php'));

Route::get('/metrics', static function () {
    $registry = new CollectorRegistry(new APC());
    $renderer = new RenderTextFormat();
    $result = $renderer->render($registry->getMetricFamilySamples());

    return response($result, 200)
        ->header('Content-Type', RenderTextFormat::MIME_TYPE);
});
