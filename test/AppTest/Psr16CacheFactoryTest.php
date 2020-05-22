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

use App\Psr16CacheFactory;
use Laminas\Cache\Storage\StorageInterface;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Stickee\Cache\SimpleCache;

final class Psr16CacheFactoryTest extends TestCase
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

        $this->container
            ->get(StorageInterface::class)
            ->willReturn($this->prophesize(StorageInterface::class));
    }

    /**
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     *
     * @return void
     */
    public function testFactoryWithTemplate(): void
    {
        $factory = new Psr16CacheFactory();

        self::assertInstanceOf(Psr16CacheFactory::class, $factory);

        $psr16Cache = $factory($this->container->reveal());

        self::assertInstanceOf(SimpleCache::class, $psr16Cache);
    }
}
