<?php
/**
 * helper
 * 
 * @author
 * @version 
 */
namespace  Admin\Helpers;

use Zend\View\Helper\AbstractHelper;

/**
 * View Helper
 */
use Zend\Form\ElementInterface;
use Zend\Form\View\Helper\FormCollection as BaseFormCollection;

class FormCollection extends BaseFormCollection {
    public function render(ElementInterface $element) {
        $fielset = parent::render($element);
        $replace = str_replace(array("<fieldset>","</fieldset>"),"",$fielset);
        return $replace;
    }
}