<?php

namespace App;

use BrowscapPHP\Browscap;
use Monolog\Logger;
use Psr\Container\ContainerInterface;
use Stickee\Cache\SimpleCache;
use Zend\Cache\Storage\StorageInterface;
use Zend\Cache\StorageFactory;

class Psr16CacheFactory
{
    /**
     * @param \Psr\Container\ContainerInterface $container
     *
     * @return \Stickee\Cache\SimpleCache
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container): SimpleCache
    {
        $cache = new SimpleCache($container->get(StorageInterface::class));

        return $cache;
    }
}
