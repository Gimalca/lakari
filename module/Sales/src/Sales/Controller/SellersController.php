<?php

namespace Sales\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class SellersController extends AbstractActionController
{

    public function indexAction()
    {
        return new ViewModel();
    }


}

