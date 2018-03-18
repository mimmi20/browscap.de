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

class DownloadsPageAction implements ServerMiddlewareInterface
{
    /**
     * @var \Zend\Expressive\Router\RouterInterface
     */
    private $router;

    /**
     * @var \Zend\Expressive\Template\TemplateRendererInterface
     */
    private $template;

    use BrowscapVersionTrait;

    /**
     * DownloadsPageAction constructor.
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
        return new HtmlResponse(
            $this->template->render(
                'app::downloads-page',
                [
                    'version' => $this->getBrowscapVersion(),
                ]
            )
        );
    }
}
