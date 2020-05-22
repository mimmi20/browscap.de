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

use App\Action\LookupPageAction;
use App\Action\LookupPageFactory;
use App\Form\UaFormInterface;
use BrowscapPHP\BrowscapInterface;
use Mezzio\Router\RouterInterface;
use Mezzio\Template\TemplateRendererInterface;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

final class LookupPageFactoryTest extends TestCase
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

        $this->container
            ->get(UaFormInterface::class)
            ->willReturn($this->prophesize(UaFormInterface::class));

        $this->container
            ->get(BrowscapInterface::class)
            ->willReturn($this->prophesize(BrowscapInterface::class));

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
        $factory = new LookupPageFactory();
        $this->container
            ->get(TemplateRendererInterface::class)
            ->willReturn($this->prophesize(TemplateRendererInterface::class));

        self::assertInstanceOf(LookupPageFactory::class, $factory);

        $homePage = $factory($this->container->reveal());

        self::assertInstanceOf(LookupPageAction::class, $homePage);
    }
}
