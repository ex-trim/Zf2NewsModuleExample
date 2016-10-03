<?php

namespace News\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use News\Form\NewsForm;

class NewsFormFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $realServiceLocator = $serviceLocator->getServiceLocator();
        $entityManager      = $realServiceLocator->get('Doctrine\ORM\EntityManager');

        return new NewsForm($entityManager);
    }
}