<?php

declare(strict_types = 1);
namespace AppTest\Form;

use App\Form\UaFactory;
use App\Form\UaForm;
use App\Model\InputFilter\UaInputFilter;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Zend\Expressive\Router\RouterInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

class UaFactoryTest extends TestCase
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
        $router          = $this->prophesize(RouterInterface::class);

        $this->container->get(RouterInterface::class)->willReturn($router);
        $this->container
            ->get(UaInputFilter::class)
            ->willReturn($this->prophesize(UaInputFilter::class));
    }

    /**
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function testFactoryWithTemplate(): void
    {
        $factory = new UaFactory();
        $this->container
            ->get(TemplateRendererInterface::class)
            ->willReturn($this->prophesize(TemplateRendererInterface::class));

        self::assertInstanceOf(UaFactory::class, $factory);

        $Ua = $factory($this->container->reveal());

        self::assertInstanceOf(UaForm::class, $Ua);
    }
}
