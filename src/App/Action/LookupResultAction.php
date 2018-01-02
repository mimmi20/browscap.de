<?php

namespace App\Action;

use App\Form\UaForm;
use BrowscapPHP\Browscap;
use BrowscapPHP\Exception;
use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface as ServerMiddlewareInterface;
use Monolog\Logger;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\EmptyResponse;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\JsonResponse;
use Zend\Diactoros\Response\RedirectResponse;
use Zend\Expressive\Csrf\CsrfMiddleware;
use Zend\Expressive\Router;
use Zend\Expressive\Template;
use Zend\Expressive\Plates\PlatesRenderer;
use Zend\Expressive\Twig\TwigRenderer;
use Zend\Expressive\ZendView\ZendViewRenderer;

class LookupResultAction implements ServerMiddlewareInterface
{
    private $router;

    private $template;

    private $form;

    private $browscap;

    private $logger;

    public function __construct(Router\RouterInterface $router, Template\TemplateRendererInterface $template, UaForm $form, Browscap $browscap, Logger $logger)
    {
        $this->router   = $router;
        $this->template = $template;
        $this->form     = $form;
        $this->browscap = $browscap;
        $this->logger   = $logger;
    }

    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        $guard = $request->getAttribute(CsrfMiddleware::GUARD_ATTRIBUTE);
        $result = [];
        $showResult = false;

        if ('POST' === $request->getMethod()) {
            $data = $request->getParsedBody();

            $this->form->setData($data);

            if (!$this->form->isValid()) {
                return new RedirectResponse(
                    $this->router->generateUri('ua-lookup'),
                    302
                );
            }

            $token = $data['__csrf'] ?? '';

            if (!$guard->validateToken($token)) {
                return new RedirectResponse(
                    $this->router->generateUri('ua-lookup'),
                    302
                );
            }

            $ua = $data['ua'];

            try {
                $result = $this->browscap->getBrowser($ua);
            } catch (\Exception $e) {
                $this->logger->error($e);

                return new EmptyResponse(500);
            }

            $showResult = true;
        } elseif ('GET' === $request->getMethod()) {
            $ua = $request->getHeaderLine('user-agent');
            $token = $guard->generateToken();
        } else {
            return new RedirectResponse(
                $this->router->generateUri('ua-lookup'),
                302
            );
        }

        return new HtmlResponse($this->template->render('app::lookup-result-page', ['__csrf' => $token, 'form' => $this->form, 'ua' => $ua, 'result' => (array) $result, 'showResult' => $showResult]));
    }
}
