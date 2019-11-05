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

use App\Action\CapabilitiesPageAction;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Router\RouterInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

final class CapabilitiesPageActionTest extends TestCase
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

    public function testReturnsHtmlResponseWhenTemplateRendererProvided(): void
    {
        $capabilities = json_decode((string) file_get_contents(__DIR__ . '/../../../src/App/data/capabilities.json'), true);

        $renderer = $this->prophesize(TemplateRendererInterface::class);
        $renderer
            ->render('app::capabilities-page', ['capabilities' => $capabilities])
            ->willReturn('');

        $CapabilitiesPage = new CapabilitiesPageAction($this->router->reveal(), $renderer->reveal());

        $response = $CapabilitiesPage->process(
            $this->prophesize(ServerRequestInterface::class)->reveal(),
            $this->prophesize(RequestHandlerInterface::class)->reveal()
        );

        static::assertInstanceOf(HtmlResponse::class, $response);
    }
}
