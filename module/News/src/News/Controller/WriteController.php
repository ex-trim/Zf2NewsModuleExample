<?php

namespace News\Controller;

use Doctrine\ORM\EntityManager;
use News\Form\NewsForm;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class WriteController extends AbstractActionController
{
    private $newsForm,
            $em;

    public function __construct(EntityManager $entityManager)
    {
        $this->newsForm = new NewsForm($entityManager);
        $this->em       = $entityManager;
    }

    public function addAction()
    {
        $request = $this->getRequest();

        if ($request->isPost()) {
            $this->newsForm->setData($request->getPost());

            if ($this->newsForm->isValid()) {
                $this->em->persist($this->newsForm->getData());
                $this->em->flush();

                return $this->redirect()->toRoute('news/list', array());
            }
        }

        return new ViewModel(array(
            'form'  => $this->newsForm
        ));
    }

    public function editAction()
    {
        $request = $this->getRequest();
        $newsitem   = $this->em->getRepository('News\Entity\News')->find($this->params('id'));

        if (!$newsitem) {
            return $this->redirect()->toRoute('news');
        }

        $this->newsForm->bind($newsitem);

        if ($request->isPost()) {
            $this->newsForm->setData($request->getPost());

            if ($this->newsForm->isValid()) {
                $this->em->flush();

                return $this->redirect()->toRoute('news/detail', array('id' => $newsitem->getId()));
            }
        }

        return new ViewModel(array(
            'form'  => $this->newsForm
        ));
    }
}