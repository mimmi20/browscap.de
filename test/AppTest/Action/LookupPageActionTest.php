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
use App\Form\UaForm;
use BrowscapPHP\BrowscapInterface;
use Laminas\Diactoros\Response\EmptyResponse;
use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\Response\RedirectResponse;
use Mezzio\Csrf\CsrfGuardInterface;
use Mezzio\Csrf\CsrfMiddleware;
use Mezzio\Router\RouterInterface;
use Mezzio\Template\TemplateRendererInterface;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Log\LoggerInterface;

final class LookupPageActionTest extends TestCase
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

    public function testReturnsEmptyResponseWhenNoSupportedMethodWasUsed(): void
    {
        $renderer = $this->prophesize(TemplateRendererInterface::class);
        $renderer
            ->render('app::lookup-page', [])
            ->willReturn('');

        $this->router
            ->generateUri('ua-lookup')
            ->willReturn('');

        $homePage = new LookupPageAction(
            $this->router->reveal(),
            $renderer->reveal(),
            $this->prophesize(UaForm::class)->reveal(),
            $this->prophesize(BrowscapInterface::class)->reveal(),
            $this->prophesize(LoggerInterface::class)->reveal()
        );

        $response = $homePage->process(
            $this->prophesize(ServerRequestInterface::class)->reveal(),
            $this->prophesize(RequestHandlerInterface::class)->reveal()
        );

        static::assertInstanceOf(EmptyResponse::class, $response);
    }

    public function testReturnsRedirectResponseWhenFormIsInvalid(): void
    {
        $renderer = $this->prophesize(TemplateRendererInterface::class);
        $renderer
            ->render('app::lookup-page', [])
            ->willReturn('');

        $this->router
            ->generateUri('ua-lookup')
            ->willReturn('');

        $request = $this->prophesize(ServerRequestInterface::class);
        $request
            ->getMethod()
            ->willReturn('POST');

        $guard = 'secret';
        $request
            ->getAttribute(CsrfMiddleware::GUARD_ATTRIBUTE)
            ->willReturn($guard);
        $body = ['__csrf' => $guard];
        $request
            ->getParsedBody()
            ->willReturn($body);

        $form = $this->prophesize(UaForm::class);
        $form
            ->isValid()
            ->willReturn(false);

        $form
            ->setData($body)
            ->willReturn(false);

        $homePage = new LookupPageAction(
            $this->router->reveal(),
            $renderer->reveal(),
            $form->reveal(),
            $this->prophesize(BrowscapInterface::class)->reveal(),
            $this->prophesize(LoggerInterface::class)->reveal()
        );

        $response = $homePage->process(
            $request->reveal(),
            $this->prophesize(RequestHandlerInterface::class)->reveal()
        );

        static::assertInstanceOf(RedirectResponse::class, $response);
    }

    public function testReturnsRedirectResponseWhenGuardIsInvalid(): void
    {
        $renderer = $this->prophesize(TemplateRendererInterface::class);
        $renderer
            ->render('app::lookup-page', [])
            ->willReturn('');

        $this->router
            ->generateUri('ua-lookup')
            ->willReturn('');

        $request = $this->prophesize(ServerRequestInterface::class);
        $request
            ->getMethod()
            ->willReturn('POST');

        $secret = 'secret';
        $guard  = $this->prophesize(CsrfGuardInterface::class);
        $guard
            ->validateToken($secret)
            ->willReturn(false);
        $request
            ->getAttribute(CsrfMiddleware::GUARD_ATTRIBUTE)
            ->willReturn($guard);

        $body = ['__csrf' => $secret];
        $request
            ->getParsedBody()
            ->willReturn($body);

        $form = $this->prophesize(UaForm::class);
        $form
            ->isValid()
            ->willReturn(true);

        $form
            ->setData($body)
            ->willReturn(false);

        $homePage = new LookupPageAction(
            $this->router->reveal(),
            $renderer->reveal(),
            $form->reveal(),
            $this->prophesize(BrowscapInterface::class)->reveal(),
            $this->prophesize(LoggerInterface::class)->reveal()
        );

        $response = $homePage->process(
            $request->reveal(),
            $this->prophesize(RequestHandlerInterface::class)->reveal()
        );

        static::assertInstanceOf(RedirectResponse::class, $response);
    }

    public function testReturnsRedirectResponseWhenBrowscapThrowsException(): void
    {
        $renderer = $this->prophesize(TemplateRendererInterface::class);
        $renderer
            ->render('app::lookup-page', [])
            ->willReturn('');

        $this->router
            ->generateUri('ua-lookup')
            ->willReturn('');

        $request = $this->prophesize(ServerRequestInterface::class);
        $request
            ->getMethod()
            ->willReturn('POST');

        $secret = 'secret';
        $guard  = $this->prophesize(CsrfGuardInterface::class);
        $guard
            ->validateToken($secret)
            ->willReturn(true);
        $request
            ->getAttribute(CsrfMiddleware::GUARD_ATTRIBUTE)
            ->willReturn($guard);

        $body = [
            '__csrf' => $secret,
            'ua' => 'test-useragent',
        ];
        $request
            ->getParsedBody()
            ->willReturn($body);

        $form = $this->prophesize(UaForm::class);
        $form
            ->isValid()
            ->willReturn(true);

        $form
            ->setData($body)
            ->willReturn(false);

        $browscap = $this->prophesize(BrowscapInterface::class);
        $browscap
            ->getBrowser($body['ua'])
            ->willThrow(new \Exception('something went wrong'));

        $homePage = new LookupPageAction(
            $this->router->reveal(),
            $renderer->reveal(),
            $form->reveal(),
            $browscap->reveal(),
            $this->prophesize(LoggerInterface::class)->reveal()
        );

        $response = $homePage->process(
            $request->reveal(),
            $this->prophesize(RequestHandlerInterface::class)->reveal()
        );

        static::assertInstanceOf(EmptyResponse::class, $response);
    }

    public function testReturnsHtmlResponseOnPost(): void
    {
        $this->router
            ->generateUri('ua-lookup')
            ->willReturn('');

        $request = $this->prophesize(ServerRequestInterface::class);
        $request
            ->getMethod()
            ->willReturn('POST');

        $secret = 'secret';
        $guard  = $this->prophesize(CsrfGuardInterface::class);
        $guard
            ->validateToken($secret)
            ->willReturn(true);
        $request
            ->getAttribute(CsrfMiddleware::GUARD_ATTRIBUTE)
            ->willReturn($guard);

        $ua   = 'test-useragent';
        $body = [
            '__csrf' => $secret,
            'ua' => $ua,
        ];
        $request
            ->getParsedBody()
            ->willReturn($body);

        $form = $this->prophesize(UaForm::class);
        $form
            ->isValid()
            ->willReturn(true);

        $form
            ->setData($body)
            ->willReturn(false);

        $detectedResult = [
            'Browser' => 'Test',
            'Crawler' => true,
            'isMobile' => false,
        ];

        $browscap = $this->prophesize(BrowscapInterface::class);
        $browscap
            ->getBrowser($ua)
            ->willReturn((object) $detectedResult);

        $logger = $this->prophesize(LoggerInterface::class);
        $logger
            ->error()
            ->willThrow(new \Exception('something went wrong'));

        $renderer = $this->prophesize(TemplateRendererInterface::class);
        $renderer
            ->render(
                'app::lookup-page',
                [
                    '__csrf' => $secret,
                    'form' => $form->reveal(),
                    'ua' => $ua,
                    'result' => [
                        'Browser' => 'Test',
                        'Crawler' => 'true',
                        'isMobile' => 'false',
                    ],
                    'showResult' => true,
                    'headers' => [],
                    'otherHeaders' => [],
                    'showHeaders' => false,
                ]
            )
            ->willReturn('');

        $homePage = new LookupPageAction(
            $this->router->reveal(),
            $renderer->reveal(),
            $form->reveal(),
            $browscap->reveal(),
            $logger->reveal()
        );

        $response = $homePage->process(
            $request->reveal(),
            $this->prophesize(RequestHandlerInterface::class)->reveal()
        );

        static::assertInstanceOf(HtmlResponse::class, $response);
    }

    public function testReturnsHtmlResponseOnGet(): void
    {
        $this->router
            ->generateUri('ua-lookup')
            ->willReturn('');

        $request = $this->prophesize(ServerRequestInterface::class);
        $request
            ->getMethod()
            ->willReturn('GET');

        $secret = 'secret';
        $guard  = $this->prophesize(CsrfGuardInterface::class);
        $guard
            ->generateToken()
            ->willReturn($secret);
        $request
            ->getAttribute(CsrfMiddleware::GUARD_ATTRIBUTE)
            ->willReturn($guard);

        $ua   = 'test-useragent';
        $body = [
            '__csrf' => $secret,
            'ua' => $ua,
        ];
        $request
            ->getHeaderLine('user-agent')
            ->willReturn($ua);
        $request
            ->getHeaders()
            ->willReturn([]);

        $form = $this->prophesize(UaForm::class);
        $form
            ->isValid()
            ->willReturn(true);

        $form
            ->setData($body)
            ->willReturn(false);

        $detectedResult = [
            'Browser' => 'Test',
            'Crawler' => true,
            'isMobile' => false,
        ];

        $browscap = $this->prophesize(BrowscapInterface::class);
        $browscap
            ->getBrowser($ua)
            ->willReturn((object) $detectedResult);

        $logger = $this->prophesize(LoggerInterface::class);
        $logger
            ->error()
            ->willThrow(new \Exception('something went wrong'));

        $renderer = $this->prophesize(TemplateRendererInterface::class);
        $renderer
            ->render(
                'app::lookup-page',
                [
                    '__csrf' => $secret,
                    'form' => $form->reveal(),
                    'ua' => $ua,
                    'result' => [],
                    'showResult' => false,
                    'headers' => [],
                    'otherHeaders' => [],
                    'showHeaders' => true,
                ]
            )
            ->willReturn('');

        $homePage = new LookupPageAction(
            $this->router->reveal(),
            $renderer->reveal(),
            $form->reveal(),
            $browscap->reveal(),
            $logger->reveal()
        );

        $response = $homePage->process(
            $request->reveal(),
            $this->prophesize(RequestHandlerInterface::class)->reveal()
        );

        static::assertInstanceOf(HtmlResponse::class, $response);
    }
}
