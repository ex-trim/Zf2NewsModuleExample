<?php

namespace News\Form;

use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Zend\Form\Form;
use News\Entity\Theme;

class ThemeForm extends Form
{
    public function __construct(ObjectManager $objectManager, $name = null, $options = array())
    {
        parent::__construct('theme_form', $options);

        $this->setHydrator(new DoctrineObject($objectManager))
             ->setObject(new Theme());

        $themeFieldset = new ThemeFieldset($objectManager, 'theme-fieldset');
        $themeFieldset->setUseAsBaseFieldset(true);
        $this->add($themeFieldset);

        $this->add(array(
            'name'      => 'submit',
            'type'      => 'submit',
            'attributes'    => array(
                'value'     => 'Add new theme',
                'class'     => 'btn btn-default'
            )
        ));
    }
}