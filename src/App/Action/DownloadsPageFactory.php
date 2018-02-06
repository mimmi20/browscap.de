<?php

declare(strict_types = 1);
namespace App\Action;

use Psr\Container\ContainerInterface;
use Zend\Expressive\Router\RouterInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

class DownloadsPageFactory
{
    /**
     * @param \Psr\Container\ContainerInterface $container
     *
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     *
     * @return \App\Action\DownloadsPageAction
     */
    public function __invoke(ContainerInterface $container): DownloadsPageAction
    {
        $router   = $container->get(RouterInterface::class);
        $template = $container->get(TemplateRendererInterface::class);

        return new DownloadsPageAction($router, $template);
    }
}
