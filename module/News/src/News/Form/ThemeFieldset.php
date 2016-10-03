<?php

namespace News\Form;

use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use News\Entity\Theme;
use Zend\Form\Fieldset;

class ThemeFieldset extends Fieldset
{
    public function __construct(ObjectManager $objectManager, $name = null, $options = array())
    {
        parent::__construct($name, $options);

        $this->setHydrator(new DoctrineObject($objectManager));
        $this->setObject(new Theme);

        $this->add(array(
            'type' => 'hidden',
            'name' => 'theme_id'
        ));

        $this->add(array(
            'type' => 'text',
            'name' => 'name',
            'options' => array(
                'label' => 'Theme',
            ),
            'attributes' => array(
                'class' => 'form-control'
            )
        ));
    }
}