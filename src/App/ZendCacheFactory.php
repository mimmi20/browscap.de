<?php
/**
 * This file is part of the mimmi20/browscap.de package.
 *
 * Copyright (c) 2015-2019, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);
namespace App;

use Laminas\Cache\Storage\StorageInterface;
use Laminas\Cache\StorageFactory;
use Psr\Container\ContainerInterface;

final class ZendCacheFactory
{
    /**
     * @param \Psr\Container\ContainerInterface $container
     *
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     *
     * @return \Laminas\Cache\Storage\StorageInterface
     */
    public function __invoke(ContainerInterface $container): StorageInterface
    {
        return StorageFactory::factory(
            [
                'adapter' => [
                    'name' => 'filesystem',
                    // With a namespace, we can indicate the same type of items,
                    // so we can simply use the database id as the cache key
                    'options' => [
                        'namespace' => 'dbtable',
                        'cache_dir' => 'data/cache/',
                        'key_pattern' => '/^[a-z0-9_\+\-\.]*$/Di',
                    ],
                ],
                'plugins' => [
                    // Don't throw exceptions on cache errors
                    'ExceptionHandler' => [
                        'throw_exceptions' => false,
                    ],
                    // We store database rows on filesystem so we need to serialize them
                    'Serializer',
                ],
            ]
        );
    }
}
