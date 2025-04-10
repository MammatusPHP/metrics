<?php declare(strict_types=1);

use Psr\Log\LoggerInterface;
use ReactParallel\Factory;
use ReactParallel\ObjectProxy\Configuration;
use ReactParallel\ObjectProxy\Generated\ProxyList;
use ReactParallel\ObjectProxy\Proxy;
use ReactParallel\ObjectProxy\ProxyListInterface;
use WyriHaximus\Metrics\Registry;
use WyriHaximus\PSR3\CallableThrowableLogger\CallableThrowableLogger;

use WyriHaximus\Metrics\Configuration as MetricsConfiguration;
use WyriHaximus\Metrics\LazyRegistry\Registry as LazyRegistry;
use WyriHaximus\Metrics\InMemory\Registry as InMemoryRegistry;

return [
    ProxyListInterface::class => static fn (): ProxyListInterface => new ProxyList(),
    Configuration::class => static fn (Factory $factory, LazyRegistry $registry, ProxyListInterface $proxyList): Configuration => (new Configuration($factory))->withProxyList($proxyList)->withMetrics(Configuration\Metrics::create($registry)),
    Proxy::class => static function (Configuration $configuration, LazyRegistry $registry, LoggerInterface $logger) {
        $proxy = new Proxy($configuration);
        $proxy->on('error', CallableThrowableLogger::create($logger));
        $registry->register($proxy->thread(new InMemoryRegistry(MetricsConfiguration::create()), Registry::class));

        return $proxy;
    },
];
