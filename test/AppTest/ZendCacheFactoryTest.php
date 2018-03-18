<?php

declare(strict_types = 1);
namespace AppTest;

use App\ZendCacheFactory;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Stickee\Cache\SimpleCache;

class ZendCacheFactoryTest extends TestCase
{
    /** @var \Prophecy\Prophecy\ObjectProphecy|\Psr\Container\ContainerInterface */
    protected $container;

    /**
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    protected function setUp(): void
    {
        $this->container = $this->prophesize(ContainerInterface::class);
    }

    /**
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function testFactoryWithTemplate(): void
    {
        $factory = new ZendCacheFactory();

        self::assertInstanceOf(ZendCacheFactory::class, $factory);

        $ZendCache = $factory($this->container->reveal());

        self::assertInstanceOf(SimpleCache::class, $ZendCache);
    }
}
