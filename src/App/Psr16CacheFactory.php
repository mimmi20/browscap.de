<?php

declare(strict_types = 1);
namespace App;

use Psr\Container\ContainerInterface;
use Stickee\Cache\SimpleCache;
use Zend\Cache\Storage\StorageInterface;

class Psr16CacheFactory
{
    /**
     * @param \Psr\Container\ContainerInterface $container
     *
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     *
     * @return \Stickee\Cache\SimpleCache
     */
    public function __invoke(ContainerInterface $container): SimpleCache
    {
        $cache = new SimpleCache($container->get(StorageInterface::class));

        return $cache;
    }
}
