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

use App\ConfigProvider;
use PHPUnit\Framework\TestCase;

final class ConfigProviderTest extends TestCase
{
    /**
     * @throws \Exception
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function testInvoke(): void
    {
        $factory = new ConfigProvider();

        static::assertInstanceOf(ConfigProvider::class, $factory);

        $array = $factory();

        static::assertIsArray($array);
    }

    /**
     * @throws \Exception
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function testGetDependencies(): void
    {
        $factory = new ConfigProvider();

        static::assertInstanceOf(ConfigProvider::class, $factory);

        $array = $factory->getDependencies();

        static::assertIsArray($array);
    }

    /**
     * @throws \Exception
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function testGetTemplates(): void
    {
        $factory = new ConfigProvider();

        static::assertInstanceOf(ConfigProvider::class, $factory);

        $array = $factory->getTemplates();

        static::assertIsArray($array);
    }
}
