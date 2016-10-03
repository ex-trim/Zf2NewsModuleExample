<?php

namespace News\Form;

use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use News\Entity\News;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;

class NewsFieldset extends Fieldset implements InputFilterProviderInterface
{
    public function __construct(ObjectManager $objectManager, $name = null, $options = array())
    {
        parent::__construct($name, $options);

        $this->setHydrator(new DoctrineObject($objectManager));
        $this->setObject(new News());

        $this->add(array(
            'type'          => 'hidden',
            'name'          =>  'news_id'
        ));

        $this->add(array(
            'type'          => 'text',
            'name'          => 'date',
            'options'       => array(
                'label'     => 'Date'
            ),
            'attributes'    => array(
                'class'     => 'form-control',
                'id'        => 'datepicker'
            )
        ));

        $this->add(array(
            'type'          => 'text',
            'name'          => 'title',
            'options'       => array(
                'label'     => 'News Title'
            ),
            'attributes'    => array(
                'class'     => 'form-control'
            )
        ));

        $this->add(array(
            'type'          => 'textarea',
            'name'          => 'text',
            'options'       => array(
                'label'     => 'News Text'
            ),
            'attributes'    => array(
                'class'     => 'form-control'
            )
        ));

        $this->add(array(
            'name' => 'theme',
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'options' => array(
                'object_manager'    => $objectManager,
                'target_class'      => 'News\Entity\Theme',
                'property'          => 'name',
            ),
        ));
    }

    public function getInputFilterSpecification()
    {
        return array(
            'title'  => array(
                'required'  => true
            ),
            'date'  => array(
                'required'  => true,
                'filters'   => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                    array('name' => 'Callback',
                        'options' => array(
                            'callback' => function($value) {
                                if (is_string($value)) {
                                    $value = \DateTime::createFromFormat('d/m/Y', $value);
                                }
                                return $value;
                            }
                        )
                    )
                ),
                'validators'    => array(
                    array(
                        'name'      => 'Date',
                        'options'   => array(
                            'format'    => 'd/m/Y'
                        )
                    )
                )
            ),
            'text'  => array(
                'filters'   => array(
                    array('name' => 'Callback',
                        'options' => array(
                            'callback'    => function($text) {
                                $text = strip_tags($text, '<br><img><ul><li><b><i><p><a><h3><h4><div>');
                                return $text;
                            }
                        )
                    )
                )
            )
        );
    }
}