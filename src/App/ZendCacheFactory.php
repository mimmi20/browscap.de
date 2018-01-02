<?php
declare(strict_types = 1);
namespace App;

use Psr\Container\ContainerInterface;
use Zend\Cache\Storage\StorageInterface;
use Zend\Cache\StorageFactory;

class ZendCacheFactory
{
    /**
     * @param \Psr\Container\ContainerInterface $container
     *
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     *
     * @return \Zend\Cache\Storage\StorageInterface
     */
    public function __invoke(ContainerInterface $container): StorageInterface
    {
        $cache = StorageFactory::factory(
            [
                'adapter' => [
                    'name' => 'filesystem',
                    // With a namespace, we can indicate the same type of items,
                    // so we can simply use the database id as the cache key
                    'options' => [
                        'namespace'   => 'dbtable',
                        'cache_dir'   => 'cache/',
                        'key_pattern' => '/^[a-z0-9_\+\-\.]*$/Di',
                    ],
                ],
                'plugins' => [
                    // Don't throw exceptions on cache errors
                    'exception_handler' => [
                        'throw_exceptions' => false,
                    ],
                    // We store database rows on filesystem so we need to serialize them
                    'Serializer',
                ],
            ]
        );

        return $cache;
    }
}
