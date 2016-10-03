<?php

namespace News\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use News\Form\ThemeForm;

class ThemeFormFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $realServiceLocator = $serviceLocator->getServiceLocator();
        $entityManager      = $realServiceLocator->get('Doctrine\ORM\EntityManager');

        return new ThemeForm($entityManager);
    }
}