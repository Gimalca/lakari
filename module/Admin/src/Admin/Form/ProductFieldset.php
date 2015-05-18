<?php
namespace Admin\Form;


use Catalog\Model\Entity\Product;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;

class ProductFieldset extends Fieldset implements InputFilterProviderInterface
{
    public function __construct()
    {
        parent::__construct('product');

        $this
        ->setHydrator(new ClassMethodsHydrator(false))
        ->setObject(new Product())
        ;
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Collection',
            'name' => 'quantity',
            'attributes' => array(
               
                'class' => 'form-control gui-input',
                'placeholder' => 'enter quantity',
                'required' => true,
                'autofocus' => true,
            
            ),
            'options' => array(
                
                'count' => 1,
                'target_element' => array(
                    'type' => 'Admin\Form\QuantityFieldset',
                ),
            ),
        ));
     
    }

    /**
     * @return array
     */
    public function getInputFilterSpecification()
    {
        return array(
            'number' => array(
                'required' => true,
            ),
        );
    }
}
?>