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
use Mezzio\Template\TemplateRendererInterface;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class DownloadsPageActionTest extends TestCase
{
    use BrowscapVersionTrait;

    /**
     * @return void
     */
    public function testReturnsHtmlResponseWhenTemplateRendererProvided(): void
    {
        $renderer = $this->prophesize(TemplateRendererInterface::class);
        $renderer
            ->render('app::downloads-page', ['version' => $this->getBrowscapVersion()])
            ->willReturn('');

        $downloadsPage = new DownloadsPageAction($renderer->reveal());

        $response = $downloadsPage->process(
            $this->prophesize(ServerRequestInterface::class)->reveal(),
            $this->prophesize(RequestHandlerInterface::class)->reveal()
        );

        self::assertInstanceOf(HtmlResponse::class, $response);
    }
}
