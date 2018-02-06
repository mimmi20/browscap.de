<?php

declare(strict_types = 1);
namespace App\Model\InputFilter;

use Interop\Container\ContainerInterface;

class UaInputFilterFactory
{
    /**
     * @param ContainerInterface $container
     *
     * @return UaInputFilter
     */
    public function __invoke(ContainerInterface $container)
    {
        $inputFilter = new UaInputFilter();
        $inputFilter->init();

        return $inputFilter;
    }
}
