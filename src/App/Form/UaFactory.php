<?php

declare(strict_types = 1);
namespace App\Form;

use App\Model\InputFilter\UaInputFilter;
use Interop\Container\ContainerInterface;
use Zend\Form\Form;

class UaFactory extends Form
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
        $inputFilter = $container->get(UaInputFilter::class);

        $form = new UaForm();
        $form->setInputFilter($inputFilter);
        $form->init();

        return $form;
    }
}
