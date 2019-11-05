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

use BrowscapPHP\Browscap;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Psr\SimpleCache\CacheInterface;

final class BrowscapFactory
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
        $cache  = $container->get(CacheInterface::class);
        $logger = $container->get(LoggerInterface::class);

        return new Browscap($cache, $logger);
    }
}
