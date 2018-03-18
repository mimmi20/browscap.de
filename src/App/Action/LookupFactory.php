<?php

declare(strict_types = 1);
namespace App\Action;

use App\Form\UaForm;
use BrowscapPHP\Browscap;
use Monolog\Logger;
use Psr\Container\ContainerInterface;
use Zend\Expressive\Router\RouterInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

class LookupFactory
{
    /**
     * @param \Psr\Container\ContainerInterface $container
     *
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     *
     * @return \App\Action\LookupAction
     */
    public function __invoke(ContainerInterface $container): LookupAction
    {
        $router   = $container->get(RouterInterface::class);
        $template = $container->get(TemplateRendererInterface::class);
        $form     = $container->get(UaForm::class);
        $browscap = $container->get(Browscap::class);
        $logger   = $container->get(Logger::class);

        return new LookupAction($router, $template, $form, $browscap, $logger);
    }
}
