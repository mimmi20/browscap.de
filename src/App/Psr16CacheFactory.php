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
use Psr\Container\ContainerInterface;
use Stickee\Cache\SimpleCache;

final class Psr16CacheFactory
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
        return new SimpleCache($container->get(StorageInterface::class));
    }
}
