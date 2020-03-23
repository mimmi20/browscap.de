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

use Laminas\Diactoros\Response\HtmlResponse;
use Mezzio\Router;
use Mezzio\Template;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class DownloadsPageAction implements MiddlewareInterface
{
    /**
     * @var \Mezzio\Router\RouterInterface
     */
    private $router;

    /**
     * @var \Mezzio\Template\TemplateRendererInterface
     */
    private $template;

    use BrowscapVersionTrait;

    /**
     * DownloadsPageAction constructor.
     *
     * @param \Mezzio\Router\RouterInterface             $router
     * @param \Mezzio\Template\TemplateRendererInterface $template
     */
    public function __construct(Router\RouterInterface $router, Template\TemplateRendererInterface $template)
    {
        $this->router   = $router;
        $this->template = $template;
    }

    /**
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Psr\Http\Server\RequestHandlerInterface $handler
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
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
