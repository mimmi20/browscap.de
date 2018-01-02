<?php
/**
 * ZF3 book Vote my Pizza Example Application
 *
 * @author     Ralf Eggert <ralf@travello.de>
 * @link       https://github.com/zf3buch/vote-my-pizza
 * @license    http://opensource.org/licenses/MIT The MIT License (MIT)
 */

namespace App\Form;

use Zend\Form\Element\Hidden;
use Zend\Form\Element\Submit;
use Zend\Form\Element\Text;
use Zend\Form\Form;

/**
 * Class RestaurantPriceForm
 *
 * @package Pizza\Form
 */
class UaForm extends Form
{
    /**
     * Add form elements
     *
     * @return void
     */
    public function init()
    {
        $this->setName('ua');
        $this->setAttribute('class', 'form-horizontal');

        $this->add(
            [
                'name'       => 'ua',
                'type'       => Text::class,
                'options'    => [
                    'label'            => 'Name des Restaurants',
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
                'name'       => '__csrf',
                'type'       => Hidden::class,
            ]
        );

        $this->add(
            [
                'name'       => 'detect',
                'type'       => Submit::class,
                'attributes' => [
                    'class' => 'btn btn-success',
                    'value' => 'Look up &raquo;',
                    'id'    => 'detect',
                ],
            ]
        );
    }
}
