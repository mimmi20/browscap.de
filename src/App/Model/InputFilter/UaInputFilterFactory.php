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
namespace App\Model\InputFilter;

use Psr\Container\ContainerInterface;

final class UaInputFilterFactory
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
