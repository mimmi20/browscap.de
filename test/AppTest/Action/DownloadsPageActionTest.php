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

use App\Action\BrowscapVersionTrait;
use App\Action\DownloadsPageAction;
use Laminas\Diactoros\Response\HtmlResponse;
use Mezzio\Router\RouterInterface;
use Mezzio\Template\TemplateRendererInterface;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class DownloadsPageActionTest extends TestCase
{
    /** @var \Mezzio\Router\RouterInterface|\Prophecy\Prophecy\ObjectProphecy */
    private $router;

    /** @var \Mezzio\Template\TemplateRendererInterface|\Prophecy\Prophecy\ObjectProphecy */
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
            $this->prophesize(RequestHandlerInterface::class)->reveal()
        );

        static::assertInstanceOf(HtmlResponse::class, $response);
    }
}
