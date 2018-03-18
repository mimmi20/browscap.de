<?php

declare(strict_types = 1);
namespace App\Action;

use App\Form\UaForm;
use BrowscapPHP\Browscap;
use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface as ServerMiddlewareInterface;
use Monolog\Logger;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\EmptyResponse;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\RedirectResponse;
use Zend\Expressive\Csrf\CsrfMiddleware;
use Zend\Expressive\Router;
use Zend\Expressive\Template;

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
                $detectedResult = $this->browscap->getBrowser($ua);
            } catch (\Exception $e) {
                $this->logger->error($e);

                return new EmptyResponse(500);
            }

            $result     = [];
            $showResult = true;

            foreach ($detectedResult as $key => $value) {
                if (true === $value) {
                    $result[$key] = 'true';
                } elseif (false === $value) {
                    $result[$key] = 'false';
                } else {
                    $result[$key] = $value;
                }
            }
            $headers    = [];
        } elseif ('GET' === $request->getMethod()) {
            $ua    = $request->getHeaderLine('user-agent');
            $token = $guard->generateToken();

            $showResult = false;
            $result     = [];
            $headers    = $request->getHeaders();
        } else {
            return new RedirectResponse(
                $this->router->generateUri('ua-lookup'),
                302
            );
        }

        return new HtmlResponse(
            $this->template->render(
                'app::lookup-result-page',
                [
                    '__csrf'     => $token,
                    'form'       => $this->form,
                    'ua'         => $ua,
                    'result'     => $result,
                    'showResult' => $showResult,
                    'headers'    => $headers,
                ]
            )
        );
    }
}
