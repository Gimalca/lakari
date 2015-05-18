<?php
/**
 * helper
 * 
 * @author
 * @version 
 */
namespace  Application\View\helper;

use Zend\View\Helper\AbstractHelper;

/**
 * View Helper
 */
use Zend\Form\ElementInterface;
use Zend\Form\View\Helper\FormCollection as BaseFormCollection;

class FormCollection extends BaseFormCollection {
    public function render(ElementInterface $element) {
        return '<ul>'.parent::render($element).'</ul>';
    }
}