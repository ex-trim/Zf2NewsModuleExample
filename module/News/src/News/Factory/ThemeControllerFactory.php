<?php

namespace News\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use News\Controller\ThemeController;

class ThemeControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $realServiceLocator = $serviceLocator->getServiceLocator();
        $themeForm          = $realServiceLocator->get('FormElementManager')->get('News\Form\ThemeForm');
        $entityManager      = $realServiceLocator->get('Doctrine\ORM\EntityManager');

        return new ThemeController(
            $themeForm,
            $entityManager
        );
    }
}