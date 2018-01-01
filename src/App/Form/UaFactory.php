<?php
/**
 * ZF3 book Vote my Pizza Example Application
 *
 * @author     Ralf Eggert <ralf@travello.de>
 * @link       https://github.com/zf3buch/vote-my-pizza
 * @license    http://opensource.org/licenses/MIT The MIT License (MIT)
 */

namespace App\Form;

use App\Model\InputFilter\UaInputFilter;
use Interop\Container\ContainerInterface;
use Zend\Form\Form;

/**
 * Class RestaurantPriceFactory
 *
 * @package Pizza\Form
 */
class UaFactory extends Form
{
    /**
     * @param ContainerInterface $container
     *
     * @return \App\Form\UaForm
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
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