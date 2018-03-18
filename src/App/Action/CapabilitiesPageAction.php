<?php

declare(strict_types = 1);
namespace App\Action;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface as ServerMiddlewareInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Router;
use Zend\Expressive\Template;

class CapabilitiesPageAction implements ServerMiddlewareInterface
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
     * CapabilitiesPageAction constructor.
     *
     * @param \Zend\Expressive\Router\RouterInterface             $router
     * @param \Zend\Expressive\Template\TemplateRendererInterface $template
     */
    public function __construct(Router\RouterInterface $router, Template\TemplateRendererInterface $template)
    {
        $this->router   = $router;
        $this->template = $template;
    }

    /**
     * @param \Psr\Http\Message\ServerRequestInterface         $request
     * @param \Interop\Http\ServerMiddleware\DelegateInterface $delegate
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function process(ServerRequestInterface $request, DelegateInterface $delegate): ResponseInterface
    {
        $capabilities = json_decode(file_get_contents(__DIR__ . '/../data/capabilities.json'), true);

        return new HtmlResponse(
            $this->template->render(
                'app::capabilities-page',
                [
                    'capabilities' => $capabilities,
                ]
            )
        );
    }
}
