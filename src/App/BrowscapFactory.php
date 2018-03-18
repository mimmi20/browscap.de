<?php

declare(strict_types = 1);
namespace App;

use BrowscapPHP\Browscap;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Psr\SimpleCache\CacheInterface;

class BrowscapFactory
{
    /**
     * @param \Psr\Container\ContainerInterface $container
     *
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     *
     * @return \BrowscapPHP\Browscap
     */
    public function __invoke(ContainerInterface $container): Browscap
    {
        $cache    = $container->get(CacheInterface::class);
        $logger   = $container->get(LoggerInterface::class);
        $browscap = new Browscap($cache, $logger);

        return $browscap;
    }
}
