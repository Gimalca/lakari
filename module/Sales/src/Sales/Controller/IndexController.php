<?php

namespace Sales\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{

    public function indexAction()
    {
        $product = new Product;
                
                return new ViewModel();
    }

    public function pruebaAction()
    {
        return new ViewModel();
    }


}

