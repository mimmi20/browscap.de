<?php

declare(strict_types = 1);
namespace App\Action;

use App\Form\UaForm;
use BrowscapPHP\BrowscapInterface;
use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface as ServerMiddlewareInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;
use Zend\Diactoros\Response\EmptyResponse;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\RedirectResponse;
use Zend\Expressive\Csrf\CsrfMiddleware;
use Zend\Expressive\Router;
use Zend\Expressive\Template;

class LookupPageAction implements ServerMiddlewareInterface
{
    /**
     * @var \Zend\Expressive\Router\RouterInterface
     */
    private $router;

    /**
     * @var \Zend\Expressive\Template\TemplateRendererInterface
     */
    private $template;

    /**
     * @var \App\Form\UaForm
     */
    private $form;

    /**
     * @var \BrowscapPHP\BrowscapInterface
     */
    private $browscap;

    /**
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;

    /**
     * LookupPageAction constructor.
     *
     * @param \Zend\Expressive\Router\RouterInterface             $router
     * @param \Zend\Expressive\Template\TemplateRendererInterface $template
     * @param \App\Form\UaForm                                    $form
     * @param \BrowscapPHP\BrowscapInterface                      $browscap
     * @param \Psr\Log\LoggerInterface                            $logger
     */
    public function __construct(Router\RouterInterface $router, Template\TemplateRendererInterface $template, UaForm $form, BrowscapInterface $browscap, LoggerInterface $logger)
    {
        $this->router   = $router;
        $this->template = $template;
        $this->form     = $form;
        $this->browscap = $browscap;
        $this->logger   = $logger;
    }

    /**
     * @param \Psr\Http\Message\ServerRequestInterface         $request
     * @param \Interop\Http\ServerMiddleware\DelegateInterface $delegate
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function process(ServerRequestInterface $request, DelegateInterface $delegate): ResponseInterface
    {
        /** @var \Zend\Expressive\Csrf\CsrfGuardInterface $guard */
        $guard = $request->getAttribute(CsrfMiddleware::GUARD_ATTRIBUTE);

        if ('POST' === $request->getMethod()) {
            $data = $request->getParsedBody();

            $this->form->setData((array) $data);

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

            foreach ((array) $detectedResult as $key => $value) {
                if (true === $value) {
                    $result[$key] = 'true';
                } elseif (false === $value) {
                    $result[$key] = 'false';
                } else {
                    $result[$key] = $value;
                }
            }
            $headers     = [];
            $showHeaders = false;
        } elseif ('GET' === $request->getMethod()) {
            $ua    = $request->getHeaderLine('user-agent');
            $token = $guard->generateToken();

            $showResult  = false;
            $result      = [];
            $headers     = $request->getHeaders();
            $showHeaders = true;
        } else {
            $response = new EmptyResponse(
                405
            );

            $response = $response->withAddedHeader('Allow', 'GET, POST');
            $response = $response->withAddedHeader('Location', $this->router->generateUri('ua-lookup'));

            return $response;
        }

        return new HtmlResponse(
            $this->template->render(
                'app::lookup-page',
                [
                    '__csrf'      => $token,
                    'form'        => $this->form,
                    'ua'          => $ua,
                    'result'      => $result,
                    'showResult'  => $showResult,
                    'headers'     => $headers,
                    'showHeaders' => $showHeaders,
                ]
            )
        );
    }
}
