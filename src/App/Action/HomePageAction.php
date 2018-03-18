<?php

declare(strict_types = 1);
namespace App\Action;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface as ServerMiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Router;
use Zend\Expressive\Template;

class HomePageAction implements ServerMiddlewareInterface
{
    private $router;

    private $template;

    use BrowscapVersionTrait;

    public function __construct(Router\RouterInterface $router, Template\TemplateRendererInterface $template)
    {
        $this->router   = $router;
        $this->template = $template;
    }

    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        return new HtmlResponse(
            $this->template->render(
                'app::home-page',
                [
                    'version' => $this->getBrowscapVersion(),
                ]
            )
        );
    }
}
