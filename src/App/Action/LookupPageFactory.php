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

use App\Form\UaForm;
use BrowscapPHP\BrowscapInterface;
use Mezzio\Router\RouterInterface;
use Mezzio\Template\TemplateRendererInterface;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

final class LookupPageFactory
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
