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

use Laminas\Filter\StringTrim;
use Laminas\Filter\StripTags;
use Laminas\InputFilter\InputFilter;
use Laminas\Validator\NotEmpty;
use Laminas\Validator\StringLength;

final class UaInputFilter extends InputFilter implements UaInputFilterInterface
{
    /**
     * Init input filter
     *
     * @return void
     */
    public function init(): void
    {
        $this->add(
            [
                'name' => 'ua',
                'required' => true,
                'filters' => [
                    [
                        'name' => StripTags::class,
                    ],
                    [
                        'name' => StringTrim::class,
                    ],
                ],
                'validators' => [
                    [
                        'name' => NotEmpty::class,
                        'break_chain_on_failure' => true,
                        'options' => ['message' => 'Please insert a user agent!'],
                    ],
                    [
                        'name' => StringLength::class,
                        'options' => [
                            'min' => 3,
                            'message' => 'Please insert %min% Chars!',
                        ],
                    ],
                ],
            ]
        );

        $this->add(
            [
                'name' => '__csrf',
                'required' => true,
                'filters' => [
                    [
                        'name' => StripTags::class,
                    ],
                    [
                        'name' => StringTrim::class,
                    ],
                ],
                'validators' => [
                    [
                        'name' => NotEmpty::class,
                        'break_chain_on_failure' => true,
                        'options' => ['message' => 'the CSRF token is missing!'],
                    ],
                ],
            ]
        );
    }
}
