<?php

namespace News\Controller;

use Doctrine\ORM\EntityManager;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class DeleteController extends AbstractActionController
{
    private $em;

    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

    public function deleteAction()
    {
        $newsitem = $this->em->getRepository('News\Entity\News')->find($this->params('id'));

        if (!$newsitem) {
            return $this->redirect()->toRoute('news');
        }

        $request = $this->getRequest();

        if ($request->isPost()) {
            $del = $request->getPost('delete_confirmation', 'no');

            if ($del === 'yes') {
                $this->em->remove($newsitem);
                $this->em->flush();
            }

            return $this->redirect()->toRoute('news');
        }

        return new ViewModel(array(
            'newsitem'  => $newsitem
        ));
    }
}