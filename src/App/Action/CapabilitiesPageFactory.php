<?php

namespace App\Action;

use Psr\Container\ContainerInterface;
use Zend\Expressive\Router\RouterInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

class CapabilitiesPageFactory
{
    /**
     * @param \Psr\Container\ContainerInterface $container
     *
     * @return \App\Action\CapabilitiesPageAction
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container): CapabilitiesPageAction
    {
        $router   = $container->get(RouterInterface::class);
        $template = $container->get(TemplateRendererInterface::class);

        return new CapabilitiesPageAction($router, $template);
    }
}
