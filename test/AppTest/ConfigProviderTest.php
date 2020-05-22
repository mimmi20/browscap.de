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
     *
     * @return void
     */
    public function testInvoke(): void
    {
        $factory = new ConfigProvider();

        self::assertInstanceOf(ConfigProvider::class, $factory);

        $array = $factory();

        self::assertIsArray($array);
    }

    /**
     * @throws \Exception
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     *
     * @return void
     */
    public function testGetDependencies(): void
    {
        $factory = new ConfigProvider();

        self::assertInstanceOf(ConfigProvider::class, $factory);

        $array = $factory->getDependencies();

        self::assertIsArray($array);
    }

    /**
     * @throws \Exception
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     *
     * @return void
     */
    public function testGetTemplates(): void
    {
        $factory = new ConfigProvider();

        self::assertInstanceOf(ConfigProvider::class, $factory);

        $array = $factory->getTemplates();

        self::assertIsArray($array);
    }
}
