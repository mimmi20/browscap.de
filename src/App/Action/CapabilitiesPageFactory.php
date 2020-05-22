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

use Mezzio\Template\TemplateRendererInterface;
use Psr\Container\ContainerInterface;

final class CapabilitiesPageFactory
{
    /**
     * @param \Psr\Container\ContainerInterface $container
     *
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     *
     * @return \App\Action\CapabilitiesPageAction
     */
    public function __invoke(ContainerInterface $container): CapabilitiesPageAction
    {
        $template = $container->get(TemplateRendererInterface::class);

        return new CapabilitiesPageAction($template);
    }
}
