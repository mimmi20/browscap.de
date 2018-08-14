<?php

declare(strict_types = 1);
namespace AppTest\Action;

use App\Action\BrowscapVersionTrait;
use App\Action\HomePageAction;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Router\RouterInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

class HomePageActionTest extends TestCase
{
    /** @var \Prophecy\Prophecy\ObjectProphecy|\Zend\Expressive\Router\RouterInterface */
    private $router;

    /** @var \Prophecy\Prophecy\ObjectProphecy|\Zend\Expressive\Template\TemplateRendererInterface */
    private $template;

    protected function setUp(): void
    {
        $this->router   = $this->prophesize(RouterInterface::class);
        $this->template = $this->prophesize(TemplateRendererInterface::class);
    }

    use BrowscapVersionTrait;

    public function testReturnsHtmlResponseWhenTemplateRendererProvided(): void
    {
        $renderer = $this->prophesize(TemplateRendererInterface::class);
        $renderer
            ->render('app::home-page', ['version' => $this->getBrowscapVersion()])
            ->willReturn('');

        $homePage = new HomePageAction($this->router->reveal(), $renderer->reveal());

        $response = $homePage->process(
            $this->prophesize(ServerRequestInterface::class)->reveal(),
            $this->prophesize(RequestHandlerInterface::class)->reveal()
        );

        self::assertInstanceOf(HtmlResponse::class, $response);
    }
}
