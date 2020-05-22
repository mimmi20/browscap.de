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

use App\BrowscapFactory;
use BrowscapPHP\BrowscapInterface;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Psr\SimpleCache\CacheInterface;

final class BrowscapFactoryTest extends TestCase
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
            ->get(CacheInterface::class)
            ->willReturn($this->prophesize(CacheInterface::class));

        $this->container
            ->get(LoggerInterface::class)
            ->willReturn($this->prophesize(LoggerInterface::class));
    }

    /**
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     *
     * @return void
     */
    public function testFactoryWithTemplate(): void
    {
        $factory = new BrowscapFactory();

        self::assertInstanceOf(BrowscapFactory::class, $factory);

        $browscap = $factory($this->container->reveal());

        self::assertInstanceOf(BrowscapInterface::class, $browscap);
    }
}
