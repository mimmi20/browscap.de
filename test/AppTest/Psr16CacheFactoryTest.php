<?php

declare(strict_types = 1);
namespace AppTest;

use App\Psr16CacheFactory;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Stickee\Cache\SimpleCache;
use Zend\Cache\Storage\StorageInterface;

class Psr16CacheFactoryTest extends TestCase
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

        $this->container
            ->get(StorageInterface::class)
            ->willReturn($this->prophesize(StorageInterface::class));
    }

    /**
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function testFactoryWithTemplate(): void
    {
        $factory = new Psr16CacheFactory();

        self::assertInstanceOf(Psr16CacheFactory::class, $factory);

        $Psr16Cache = $factory($this->container->reveal());

        self::assertInstanceOf(SimpleCache::class, $Psr16Cache);
    }
}
