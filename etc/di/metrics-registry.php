<?php declare(strict_types=1);

use WyriHaximus\Metrics\LazyRegistry\Registry as LazyRegistry;
use WyriHaximus\Metrics\Registry;

return [
    LazyRegistry::class => new LazyRegistry(),
    Registry::class => static fn (LazyRegistry $registry) => $registry,
];
