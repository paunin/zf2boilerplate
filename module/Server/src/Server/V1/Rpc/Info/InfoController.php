<?php
namespace Server\V1\Rpc\Info;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

class InfoController extends AbstractActionController
{
    public function infoAction()
    {
        return new JsonModel([
            'version' => '1.0.0'
        ]);
    }
}
