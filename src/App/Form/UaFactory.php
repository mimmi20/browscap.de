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
namespace App\Form;

use App\Model\InputFilter\UaInputFilterInterface;
use Psr\Container\ContainerInterface;

final class UaFactory
{
    /**
     * @param ContainerInterface $container
     *
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     *
     * @return \App\Form\UaForm
     */
    public function __invoke(ContainerInterface $container): UaForm
    {
        $inputFilter = $container->get(UaInputFilterInterface::class);

        $form = new UaForm();
        $form->setInputFilter($inputFilter);
        $form->init();

        return $form;
    }
}
