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
namespace AppTest\Action;

use App\Action\DownloadsPageAction;
use App\Action\DownloadsPageFactory;
use Mezzio\Router\RouterInterface;
use Mezzio\Template\TemplateRendererInterface;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

final class DownloadsPageFactoryTest extends TestCase
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
        $router          = $this->prophesize(RouterInterface::class);

        $this->container->get(RouterInterface::class)->willReturn($router);
    }

    /**
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     *
     * @return void
     */
    public function testFactoryWithTemplate(): void
    {
        $factory = new DownloadsPageFactory();
        $this->container
            ->get(TemplateRendererInterface::class)
            ->willReturn($this->prophesize(TemplateRendererInterface::class));

        self::assertInstanceOf(DownloadsPageFactory::class, $factory);

        $downloadsPage = $factory($this->container->reveal());

        self::assertInstanceOf(DownloadsPageAction::class, $downloadsPage);
    }
}
