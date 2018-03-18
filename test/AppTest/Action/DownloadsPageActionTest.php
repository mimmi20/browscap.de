<?php

declare(strict_types = 1);
namespace AppTest\Action;

use App\Action\BrowscapVersionTrait;
use App\Action\DownloadsPageAction;
use Interop\Http\ServerMiddleware\DelegateInterface;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Router\RouterInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

class DownloadsPageActionTest extends TestCase
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
            ->render('app::downloads-page', ['version' => $this->getBrowscapVersion()])
            ->willReturn('');

        $DownloadsPage = new DownloadsPageAction($this->router->reveal(), $renderer->reveal());

        $response = $DownloadsPage->process(
            $this->prophesize(ServerRequestInterface::class)->reveal(),
            $this->prophesize(DelegateInterface::class)->reveal()
        );

        self::assertInstanceOf(HtmlResponse::class, $response);
    }
}
