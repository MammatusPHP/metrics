<?php declare(strict_types=1);

use React\EventLoop\LoopInterface;
use ReactParallel\Factory;
use WyriHaximus\Metrics\Registry;

return [
    Factory::class => static function (LoopInterface $loop, Registry $registry) {
        return (new Factory($loop))->withMetrics($registry);
    },
];
