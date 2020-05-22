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
namespace App\Action;

use App\Form\UaFormInterface;
use BrowscapPHP\BrowscapInterface;
use Laminas\Diactoros\Response\EmptyResponse;
use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\Response\RedirectResponse;
use Mezzio\Csrf\CsrfGuardInterface;
use Mezzio\Csrf\CsrfMiddleware;
use Mezzio\Router;
use Mezzio\Template;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Log\LoggerInterface;
use UaRequest\GenericRequestFactory;

final class LookupPageAction implements MiddlewareInterface
{
    /** @var \Mezzio\Router\RouterInterface */
    private $router;

    /** @var \Mezzio\Template\TemplateRendererInterface */
    private $template;

    /** @var \App\Form\UaFormInterface */
    private $form;

    /** @var \BrowscapPHP\BrowscapInterface */
    private $browscap;

    /** @var \Psr\Log\LoggerInterface */
    private $logger;

    /**
     * @param \Mezzio\Router\RouterInterface             $router
     * @param \Mezzio\Template\TemplateRendererInterface $template
     * @param \App\Form\UaFormInterface                  $form
     * @param \BrowscapPHP\BrowscapInterface             $browscap
     * @param \Psr\Log\LoggerInterface                   $logger
     */
    public function __construct(Router\RouterInterface $router, Template\TemplateRendererInterface $template, UaFormInterface $form, BrowscapInterface $browscap, LoggerInterface $logger)
    {
        $this->router   = $router;
        $this->template = $template;
        $this->form     = $form;
        $this->browscap = $browscap;
        $this->logger   = $logger;
    }

    /**
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Psr\Http\Server\RequestHandlerInterface $handler
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $guard = $request->getAttribute(CsrfMiddleware::GUARD_ATTRIBUTE);
        \assert($guard instanceof CsrfGuardInterface, sprintf('$guard should be an instance of %s, but is %s', CsrfGuardInterface::class, get_class($guard)));

        if ('POST' === $request->getMethod()) {
            $data = (array) $request->getParsedBody();

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
            } catch (\Throwable $e) {
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

            $headers      = [];
            $otherHeaders = [];
            $showHeaders  = false;
        } elseif ('GET' === $request->getMethod()) {
            $ua    = $request->getHeaderLine('user-agent');
            $token = $guard->generateToken();

            $showResult     = false;
            $result         = [];
            $genericRequest = (new GenericRequestFactory())->createRequestFromPsr7Message($request);

            $headers      = $genericRequest->getFilteredHeaders();
            $otherHeaders = array_diff_key($genericRequest->getHeaders(), $genericRequest->getFilteredHeaders());
            $showHeaders  = true;
        } else {
            $response = new EmptyResponse(
                405
            );

            $response = $response->withAddedHeader('Allow', 'GET, POST');

            return $response->withAddedHeader('Location', $this->router->generateUri('ua-lookup'));
        }

        return new HtmlResponse(
            $this->template->render(
                'app::lookup-page',
                [
                    '__csrf' => $token,
                    'form' => $this->form,
                    'ua' => $ua,
                    'result' => $result,
                    'showResult' => $showResult,
                    'headers' => $headers,
                    'otherHeaders' => $otherHeaders,
                    'showHeaders' => $showHeaders,
                ]
            )
        );
    }
}
