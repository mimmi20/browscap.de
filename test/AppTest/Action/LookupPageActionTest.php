<?php

declare(strict_types = 1);
namespace AppTest\Action;

use App\Action\LookupPageAction;
use App\Form\UaForm;
use BrowscapPHP\BrowscapInterface;
use Interop\Http\ServerMiddleware\DelegateInterface;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;
use Zend\Diactoros\Response\EmptyResponse;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\RedirectResponse;
use Zend\Expressive\Csrf\CsrfGuardInterface;
use Zend\Expressive\Csrf\CsrfMiddleware;
use Zend\Expressive\Router\RouterInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

class LookupPageActionTest extends TestCase
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
            $this->prophesize(DelegateInterface::class)->reveal()
        );

        self::assertInstanceOf(EmptyResponse::class, $response);
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
            $this->prophesize(DelegateInterface::class)->reveal()
        );

        self::assertInstanceOf(RedirectResponse::class, $response);
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
            $this->prophesize(DelegateInterface::class)->reveal()
        );

        self::assertInstanceOf(RedirectResponse::class, $response);
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
            'ua'     => 'test-useragent',
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
            ->getBrowser()
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
            $this->prophesize(DelegateInterface::class)->reveal()
        );

        self::assertInstanceOf(EmptyResponse::class, $response);
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
            'ua'     => $ua,
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
            'Browser'  => 'Test',
            'Crawler'  => true,
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
                    'form'   => $form->reveal(),
                    'ua'     => $ua,
                    'result' => [
                        'Browser'  => 'Test',
                        'Crawler'  => 'true',
                        'isMobile' => 'false',
                    ],
                    'showResult'  => true,
                    'headers'     => [],
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
            $this->prophesize(DelegateInterface::class)->reveal()
        );

        self::assertInstanceOf(HtmlResponse::class, $response);
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
            'ua'     => $ua,
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
            'Browser'  => 'Test',
            'Crawler'  => true,
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
                    '__csrf'      => $secret,
                    'form'        => $form->reveal(),
                    'ua'          => $ua,
                    'result'      => [],
                    'showResult'  => false,
                    'headers'     => [], //$headers,
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
            $this->prophesize(DelegateInterface::class)->reveal()
        );

        self::assertInstanceOf(HtmlResponse::class, $response);
    }
}
