<?php declare(strict_types=1);

use ReactParallel\Factory;
use ReactParallel\ObjectProxy\Configuration;
use ReactParallel\ObjectProxy\Proxy;
use WyriHaximus\Metrics\Configuration as MetricsConfiguration;
use WyriHaximus\Metrics\LazyRegistry\Registry as LazyRegistry;
use WyriHaximus\Metrics\InMemory\Registry as InMemoryRegistry;
use WyriHaximus\Metrics\Registry;

return [
    Proxy::class => static function (Factory $factory, LazyRegistry $registry) {
        $proxy = (new Proxy((new Configuration($factory))->withMetrics(Configuration\Metrics::create($registry))));
        $registry->register($proxy->thread(new InMemoryRegistry(MetricsConfiguration::create()), Registry::class));

        return $proxy;
    },
];
