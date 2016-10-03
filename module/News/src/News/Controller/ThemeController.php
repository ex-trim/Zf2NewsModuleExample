<?php

namespace News\Controller;

use Doctrine\ORM\EntityManager;
use Zend\Form\FormInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class ThemeController extends AbstractActionController
{
    private $em,
            $themeForm;

    public function __construct(FormInterface $themeForm, EntityManager $entityManager)
    {
        $this->themeForm    = $themeForm;
        $this->em           = $entityManager;
    }

    public function indexAction()
    {
        return new ViewModel(array(
            'themes' => $this->em->getRepository('News\Entity\Theme')->findAll()
        ));
    }

    public function addAction()
    {
        $request = $this->getRequest();

        if ($request->isPost()) {
            $this->themeForm->setData($request->getPost());

            if ($this->themeForm->isValid()) {
                $this->em->persist($this->themeForm->getData());
                $this->em->flush();

                return $this->redirect()->toRoute('themes', array());
            }
        }

        return new ViewModel(array(
            'form'  => $this->themeForm
        ));
    }

    public function editAction()
    {
        $request = $this->getRequest();
        $theme   = $this->em->getRepository('News\Entity\Theme')->find($this->params('id'));

        if (!$theme) {
            return $this->redirect()->toRoute('news');
        }

        $this->themeForm->bind($theme);

        if ($request->isPost()) {
            $this->themeForm->setData($request->getPost());

            if ($this->themeForm->isValid()) {
                $this->em->flush();

                return $this->redirect()->toRoute('themes', array());
            }
        }

        return new ViewModel(array(
            'form'  => $this->themeForm
        ));
    }

    public function deleteAction()
    {
        $theme = $this->em->getRepository('News\Entity\Theme')->find($this->params('id'));

        if (!$theme) {
            return $this->redirect()->toRoute('themes');
        }

        $request = $this->getRequest();

        if ($request->isPost()) {
            $del = $request->getPost('delete_confirmation', 'no');

            if ($del === 'yes') {
                $this->em->remove($theme);
                $this->em->flush();
            }

            return $this->redirect()->toRoute('themes');
        }

        return new ViewModel(array(
            'theme'  => $theme
        ));
    }
}