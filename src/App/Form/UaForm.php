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

use Zend\Form\Element\Hidden;
use Zend\Form\Element\Submit;
use Zend\Form\Element\Text;
use Zend\Form\Form;

class UaForm extends Form
{
    /**
     * Add form elements
     *
     * @return void
     */
    public function init(): void
    {
        $this->setName('ua');
        $this->setAttribute('class', 'form-horizontal');

        $this->add(
            [
                'name' => 'ua',
                'type' => Text::class,
                'options' => [
                    'label' => 'Name des Restaurants',
                    'label_attributes' => [
                        'class' => 'col-sm-4 control-label',
                    ],
                ],
                'attributes' => [
                    'class' => 'form-control',
                ],
            ]
        );

        $this->add(
            [
                'name' => '__csrf',
                'type' => Hidden::class,
            ]
        );

        $this->add(
            [
                'name' => 'detect',
                'type' => Submit::class,
                'attributes' => [
                    'class' => 'btn btn-success',
                    'value' => 'Look up &raquo;',
                    'id' => 'detect',
                ],
            ]
        );
    }
}
