<?php

declare(strict_types = 1);
namespace AppTest\Action;

use App\Action\LookupPageAction;
use App\Action\LookupPageFactory;
use App\Form\UaForm;
use BrowscapPHP\BrowscapInterface;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Zend\Expressive\Router\RouterInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

class LookupPageFactoryTest extends TestCase
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
        $router          = $this->prophesize(RouterInterface::class);

        $this->container->get(RouterInterface::class)->willReturn($router);

        $this->container
            ->get(UaForm::class)
            ->willReturn($this->prophesize(UaForm::class));

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
