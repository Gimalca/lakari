<?php
/**
 * helper
 * 
 * @author
 * @version 
 */
namespace  Admin\View\Helper;

use Zend\View\Helper\AbstractHelper;

/**
 * View Helper
 */
class MyHelper extends AbstractHelper
{

    public function __invoke($in)
    {
        $in = $in.' THIS HELPER';
        // TODO Auto-generated MyHelper::__invoke
        return $in;
    }
}
