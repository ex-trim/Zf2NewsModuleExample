<?php

namespace News\Form;

use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use News\Entity\Theme;
use Zend\Form\Form;

class NewsForm extends Form
{
    public function __construct(ObjectManager $objectManager, $name = null, $options = array())
    {
        parent::__construct('news_form', $options);

        $this->setHydrator(new DoctrineObject($objectManager))
             ->setObject(new Theme());

        $newsFieldset = new NewsFieldset($objectManager, 'news-fieldset');
        $newsFieldset->setUseAsBaseFieldset(true);
        $this->add($newsFieldset);

        $this->add(array(
            'name'      => 'submit',
            'type'      => 'submit',
            'attributes'    => array(
                'value'     => 'Add News Item',
                'class'     => 'btn btn-default'
            )
        ));
    }
}