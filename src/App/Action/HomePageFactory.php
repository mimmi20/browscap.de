<?php

declare(strict_types = 1);
namespace App\Action;

use Psr\Container\ContainerInterface;
use Zend\Expressive\Router\RouterInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

class HomePageFactory
{
    /**
     * @param \Psr\Container\ContainerInterface $container
     *
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     *
     * @return \App\Action\HomePageAction
     */
    public function __invoke(ContainerInterface $container): HomePageAction
    {
        $router   = $container->get(RouterInterface::class);
        $template = $container->get(TemplateRendererInterface::class);

        return new HomePageAction($router, $template);
    }
}
