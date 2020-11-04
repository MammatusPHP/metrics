<?php declare(strict_types=1);

use ReactParallel\Factory;
use ReactParallel\ObjectProxy\Proxy;
use WyriHaximus\Metrics\Registry;

return [
    Proxy::class => static function (Factory $factory, Registry $registry) {
        $proxy = (new Proxy($factory))->withMetrics($registry);
        $proxy->create($registry, Registry::class, true);

        return $proxy;
    },
];
