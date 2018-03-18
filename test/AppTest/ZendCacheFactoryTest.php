<?php

declare(strict_types = 1);
namespace AppTest;

use App\ZendCacheFactory;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Zend\Cache\Storage\Adapter\Filesystem;

class ZendCacheFactoryTest extends TestCase
{
    /** @var \Prophecy\Prophecy\ObjectProphecy|\Psr\Container\ContainerInterface */
    private $container;

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

        self::assertInstanceOf(Filesystem::class, $ZendCache);
    }
}
