<?php

namespace News\Factory;

use News\Controller\WriteController;
use News\Form\NewsForm;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class WriteControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $realServiceLocator = $serviceLocator->getServiceLocator();
        $entityManager      = $realServiceLocator->get('Doctrine\ORM\EntityManager');

        return new WriteController($entityManager);
    }
}