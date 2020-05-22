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
use App\Action\HomePageAction;
use Laminas\Diactoros\Response\HtmlResponse;
use Mezzio\Template\TemplateRendererInterface;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class HomePageActionTest extends TestCase
{
    use BrowscapVersionTrait;

    /**
     * @return void
     */
    public function testReturnsHtmlResponseWhenTemplateRendererProvided(): void
    {
        $renderer = $this->prophesize(TemplateRendererInterface::class);
        $renderer
            ->render('app::home-page', ['version' => $this->getBrowscapVersion()])
            ->willReturn('');

        $homePage = new HomePageAction($renderer->reveal());

        $response = $homePage->process(
            $this->prophesize(ServerRequestInterface::class)->reveal(),
            $this->prophesize(RequestHandlerInterface::class)->reveal()
        );

        self::assertInstanceOf(HtmlResponse::class, $response);
    }
}
