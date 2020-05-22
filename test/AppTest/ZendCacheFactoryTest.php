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
namespace AppTest;

use App\ZendCacheFactory;
use Laminas\Cache\Storage\Adapter\Filesystem;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

final class ZendCacheFactoryTest extends TestCase
{
    /** @var \Prophecy\Prophecy\ObjectProphecy|\Psr\Container\ContainerInterface */
    private $container;

    /**
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     *
     * @return void
     */
    protected function setUp(): void
    {
        $this->container = $this->prophesize(ContainerInterface::class);
    }

    /**
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     *
     * @return void
     */
    public function testFactoryWithTemplate(): void
    {
        $factory = new ZendCacheFactory();

        self::assertInstanceOf(ZendCacheFactory::class, $factory);

        $zendCache = $factory($this->container->reveal());

        self::assertInstanceOf(Filesystem::class, $zendCache);
    }
}
