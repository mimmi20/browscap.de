<?php

declare(strict_types = 1);
namespace App\Action;

use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Router;
use Zend\Expressive\Template;

class CapabilitiesPageAction implements MiddlewareInterface
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
     * @param \Psr\Http\Message\ServerRequestInterface     $request
     * @param \Psr\Http\Server\RequestHandlerInterface $handler
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
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
