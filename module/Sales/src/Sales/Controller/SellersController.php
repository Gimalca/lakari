<?php

namespace Sales\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Sales\Form\SellerForm;

class SellersController extends AbstractActionController
{

    public function indexAction()
    {
        return new ViewModel();
    }
}

