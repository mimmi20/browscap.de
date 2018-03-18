<?php

declare(strict_types = 1);
namespace AppTest\Action;

use App\Action\BrowscapVersionTrait;
use App\Action\CapabilitiesPageAction;
use Interop\Http\ServerMiddleware\DelegateInterface;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Router\RouterInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

class CapabilitiesPageActionTest extends TestCase
{
    /** @var \Prophecy\Prophecy\ObjectProphecy|\Zend\Expressive\Router\RouterInterface */
    protected $router;

    /** @var \Prophecy\Prophecy\ObjectProphecy|\Zend\Expressive\Template\TemplateRendererInterface */
    private $template;

    protected function setUp(): void
    {
        $this->router   = $this->prophesize(RouterInterface::class);
        $this->template = $this->prophesize(TemplateRendererInterface::class);
    }

    public function testReturnsHtmlResponseWhenTemplateRendererProvided(): void
    {
        $capabilities = json_decode(file_get_contents(__DIR__ . '/../../../src/App/data/capabilities.json'), true);

        $renderer = $this->prophesize(TemplateRendererInterface::class);
        $renderer
            ->render('app::capabilities-page', ['capabilities' => $capabilities])
            ->willReturn('');

        $CapabilitiesPage = new CapabilitiesPageAction($this->router->reveal(), $renderer->reveal());

        $response = $CapabilitiesPage->process(
            $this->prophesize(ServerRequestInterface::class)->reveal(),
            $this->prophesize(DelegateInterface::class)->reveal()
        );

        self::assertInstanceOf(HtmlResponse::class, $response);
    }
}
