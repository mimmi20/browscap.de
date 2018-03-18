<?php

declare(strict_types = 1);
namespace AppTest;

use App\ConfigProvider;
use PHPUnit\Framework\TestCase;

class ConfigProviderTest extends TestCase
{
    /**
     * @throws \Exception
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function testInvoke(): void
    {
        $factory = new ConfigProvider();

        self::assertInstanceOf(ConfigProvider::class, $factory);

        $array = $factory();

        self::assertInternalType('array', $array);
    }

    /**
     * @throws \Exception
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function testGetDependencies(): void
    {
        $factory = new ConfigProvider();

        self::assertInstanceOf(ConfigProvider::class, $factory);

        $array = $factory->getDependencies();

        self::assertInternalType('array', $array);
    }

    /**
     * @throws \Exception
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function testGetTemplates(): void
    {
        $factory = new ConfigProvider();

        self::assertInstanceOf(ConfigProvider::class, $factory);

        $array = $factory->getTemplates();

        self::assertInternalType('array', $array);
    }
}
