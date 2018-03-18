<?php

declare(strict_types = 1);
namespace AppTest;

use App\LoggerFactory;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

class LoggerFactoryTest extends TestCase
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
     * @throws \Exception
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function testFactoryWithTemplate(): void
    {
        $factory = new LoggerFactory();

        self::assertInstanceOf(LoggerFactory::class, $factory);

        $logger = $factory($this->container->reveal());

        self::assertInstanceOf(LoggerInterface::class, $logger);
    }
}
