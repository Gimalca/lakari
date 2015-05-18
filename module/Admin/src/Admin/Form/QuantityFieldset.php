<?php
namespace Admin\Form;


use Admin\Model\Entity\Quantity;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;

class QuantityFieldset extends Fieldset implements InputFilterProviderInterface
{
    public function __construct()
    {
        parent::__construct('Quantity');

        $this
        ->setHydrator(new ClassMethodsHydrator(false))
        ->setObject(new Quantity())
        ;

        $this->add(array(
            'name' => 'number',          
            'attributes' => array(
                'required' => 'required',
            ),
        ));
    }

    /**
     * @return array
     */
    public function getInputFilterSpecification()
    {
        return array(
            'name' => array(
                'required' => true,
            ),
        );
    }
}
?>