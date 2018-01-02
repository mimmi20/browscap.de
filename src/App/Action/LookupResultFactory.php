<?php
declare(strict_types = 1);
namespace App\Action;

use App\Form\UaForm;
use BrowscapPHP\Browscap;
use Monolog\Logger;
use Psr\Container\ContainerInterface;
use Zend\Expressive\Router\RouterInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

class LookupResultFactory
{
    /**
     * @param \Psr\Container\ContainerInterface $container
     *
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     *
     * @return \App\Action\LookupResultAction
     */
    public function __invoke(ContainerInterface $container): LookupResultAction
    {
        $router   = $container->get(RouterInterface::class);
        $template = $container->get(TemplateRendererInterface::class);
        $form     = $container->get(UaForm::class);
        $browscap = $container->get(Browscap::class);
        $logger   = $container->get(Logger::class);

        return new LookupResultAction($router, $template, $form, $browscap, $logger);
    }
}
