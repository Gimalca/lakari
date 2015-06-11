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
class AlertHelper extends AbstractHelper
{

    public function __invoke($type, $message)
    {
        switch ($type) {
            case 'succes':
                $alert = '<div class="alert alert-success pastel alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <i class="fa fa-check pr10"></i>'.
                                $message
                          .'</div>'
            ;
            break;
            
            default:
                $alert = '<div class="alert alert-micro alert-primary light alert-dismissable">
                              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                              <i class="fa fa-cubes pr10 "></i>'.
                             $message
                          .'</div>';
                ;
            break;
        }
      
        return $alert;
    }
}
