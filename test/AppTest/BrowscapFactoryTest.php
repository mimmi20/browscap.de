<?php

declare(strict_types = 1);
namespace AppTest;

use App\BrowscapFactory;
use BrowscapPHP\BrowscapInterface;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Psr\SimpleCache\CacheInterface;

class BrowscapFactoryTest extends TestCase
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
     */
    public function testFactoryWithTemplate(): void
    {
        $factory = new BrowscapFactory();

        self::assertInstanceOf(BrowscapFactory::class, $factory);

        $browscap = $factory($this->container->reveal());

        self::assertInstanceOf(BrowscapInterface::class, $browscap);
    }
}
