<?php

declare(strict_types = 1);
namespace App\Action;

use App\Form\UaForm;
use BrowscapPHP\BrowscapInterface;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Zend\Expressive\Router\RouterInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

class LookupPageFactory
{
    /**
     * @param \Psr\Container\ContainerInterface $container
     *
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     *
     * @return \App\Action\LookupPageAction
     */
    public function __invoke(ContainerInterface $container): LookupPageAction
    {
        $router   = $container->get(RouterInterface::class);
        $template = $container->get(TemplateRendererInterface::class);
        $form     = $container->get(UaForm::class);
        $browscap = $container->get(BrowscapInterface::class);
        $logger   = $container->get(LoggerInterface::class);

        return new LookupPageAction($router, $template, $form, $browscap, $logger);
    }
}
