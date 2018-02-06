<?php

declare(strict_types = 1);
namespace App\Action;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface as ServerMiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Router;
use Zend\Expressive\Template;

class CapabilitiesPageAction implements ServerMiddlewareInterface
{
    private $router;

    private $template;

    public function __construct(Router\RouterInterface $router, Template\TemplateRendererInterface $template)
    {
        $this->router   = $router;
        $this->template = $template;
    }

    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        $capabilities = json_decode(file_get_contents(__DIR__ . '/../data/capabilities.json'), true);

        return new HtmlResponse(
            $this->template->render(
                'app::capabilities-page',
                ['capabilities' => $capabilities]
            )
        );
    }
}
