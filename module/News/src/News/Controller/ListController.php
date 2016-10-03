<?php

namespace News\Controller;

use Doctrine\ORM\Query\ResultSetMapping;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Doctrine\ORM\EntityManager;
use News\Library\Paginator;

class ListController extends AbstractActionController
{
    private $em;

    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

    public function indexAction()
    {
        $rsMap = new ResultSetMapping();
        $rsMap->addEntityResult('News\Entity\News', 'n');
        $rsMap->addFieldResult('n', 'news_id', 'news_id');
        $rsMap->addFieldResult('n', 'date', 'date');
        $rsMap->addFieldResult('n', 'text', 'text');
        $rsMap->addFieldResult('n', 'title', 'title');
        $rsMap->addJoinedEntityResult('News\Entity\Theme', 't', 'n', 'theme');
        $rsMap->addFieldResult('t', 'theme_id', 'theme_id');
        $rsMap->addFieldResult('t', 'theme_title', 'name');

        $query = $this->em->createNativeQuery(
            'SELECT n.news_id, n.date, n.title, n.text, t.theme_id, t.theme_title'
            . ' FROM news n'
            . ' JOIN themes t ON n.theme_id = t.theme_id'
            . ' ORDER BY n.date DESC', $rsMap);

        $page           = $this->params()->fromRoute('page', 1);
        $news_per_page  = $this->params()->fromQuery('limit', 5);

        $paginator = new Paginator();
        $paginated = $paginator->paginate($query, $page, $news_per_page);

        return new ViewModel(array(
            'news'          => $paginated,
            'paginator'     => $paginator,
            'news_archive'  => $this->_getNewsArchive(),
            'by_topic'      => $this->_getNewsByTopic()
        ));
    }

    public function archiveAction()
    {
        $year   = $this->params()->fromRoute('year');
        $month  = $this->params()->fromRoute('month');

        $rsMap = new ResultSetMapping();
        $rsMap->addEntityResult('News\Entity\News', 'n');
        $rsMap->addFieldResult('n', 'news_id', 'news_id');
        $rsMap->addFieldResult('n', 'date', 'date');
        $rsMap->addFieldResult('n', 'text', 'text');
        $rsMap->addFieldResult('n', 'title', 'title');
        $rsMap->addJoinedEntityResult('News\Entity\Theme', 't', 'n', 'theme');
        $rsMap->addFieldResult('t', 'theme_id', 'theme_id');
        $rsMap->addFieldResult('t', 'theme_title', 'name');

        $sql = 'SELECT n.news_id, n.date, n.title, n.text, t.theme_id, t.theme_title'
             . ' FROM news n'
             . ' JOIN themes t ON n.theme_id = t.theme_id'
             . ' WHERE YEAR(date) = ?';

        if(!empty($month)) {
            $month_num = date('m', strtotime($month));
            $sql = $sql . ' AND MONTH(date) = ? ORDER BY n.date DESC';
            $query = $this->em->createNativeQuery($sql, $rsMap);
            $query->setParameters(array($year, $month_num));
        } else {
            $sql = $sql . ' ORDER BY n.date DESC';
            $query = $this->em->createNativeQuery($sql, $rsMap);
            $query->setParameter(1, $year);
        }

        $page           = $this->params()->fromRoute('page', 1);
        $news_per_page  = $this->params()->fromQuery('limit', 5);

        $paginator = new Paginator();
        $paginated = $paginator->paginate($query, $page, $news_per_page);

        return new ViewModel(array(
            'news'          => $paginated,
            'year'          => $year,
            'month'         => $month,
            'paginator'     => $paginator,
            'news_archive'  => $this->_getNewsArchive(),
            'by_topic'      => $this->_getNewsByTopic()
        ));
    }

    public function themeAction()
    {
        $theme = $this->params()->fromRoute('theme');
        $theme = strip_tags(trim($theme));

        $rsMap = new ResultSetMapping();
        $rsMap->addEntityResult('News\Entity\News', 'n');
        $rsMap->addFieldResult('n', 'news_id', 'news_id');
        $rsMap->addFieldResult('n', 'date', 'date');
        $rsMap->addFieldResult('n', 'text', 'text');
        $rsMap->addFieldResult('n', 'title', 'title');
        $rsMap->addJoinedEntityResult('News\Entity\Theme', 't', 'n', 'theme');
        $rsMap->addFieldResult('t', 'theme_id', 'theme_id');
        $rsMap->addFieldResult('t', 'theme_title', 'name');

        $query = $this->em
            ->createNativeQuery(
                'SELECT n.news_id, n.date, n.title, n.text, t.theme_id, t.theme_title'
                . ' FROM news n'
                . ' INNER JOIN themes t ON n.theme_id = t.theme_id'
                . ' WHERE t.theme_title = ?'
                . ' ORDER BY n.date DESC', $rsMap);
        $query->setParameter(1, $theme);


        $page           = $this->params()->fromRoute('page', 1);
        $news_per_page  = $this->params()->fromQuery('limit', 5);

        $paginator = new Paginator();
        $paginated = $paginator->paginate($query, $page, $news_per_page);

        return new ViewModel(array(
            'news'          => $paginated,
            'theme'         => $theme,
            'paginator'     => $paginator,
            'news_archive'  => $this->_getNewsArchive(),
            'by_topic'      => $this->_getNewsByTopic()
        ));

    }

    public function listAction()
    {
        $rsMap = new ResultSetMapping();
        $rsMap->addEntityResult('News\Entity\News', 'n');
        $rsMap->addFieldResult('n', 'news_id', 'news_id');
        $rsMap->addFieldResult('n', 'date', 'date');
        $rsMap->addFieldResult('n', 'text', 'text');
        $rsMap->addFieldResult('n', 'title', 'title');
        $rsMap->addMetaResult('n', 'theme_id', 'theme_id');

        $query = $this->em->createNativeQuery(
            'SELECT news_id, date, title, text'
            . ' FROM news'
            . ' ORDER BY date DESC', $rsMap);
        $news = $query->getResult();

        return new ViewModel(array(
            'news' => $news
        ));
    }

    public function detailAction()
    {
        $id = $this->params()->fromRoute('id');

        $rsMap = new ResultSetMapping();
        $rsMap->addEntityResult('News\Entity\News', 'n');
        $rsMap->addFieldResult('n', 'news_id', 'news_id');
        $rsMap->addFieldResult('n', 'date', 'date');
        $rsMap->addFieldResult('n', 'text', 'text');
        $rsMap->addFieldResult('n', 'title', 'title');
        $rsMap->addJoinedEntityResult('News\Entity\Theme', 't', 'n', 'theme');
        $rsMap->addFieldResult('t', 'theme_id', 'theme_id');
        $rsMap->addFieldResult('t', 'theme_title', 'name');


        $query = $this->em
            ->createNativeQuery(
                'SELECT n.news_id, n.date, n.title, n.text, t.theme_id, t.theme_title'
                . ' FROM news n'
                . ' INNER JOIN themes t ON n.theme_id = t.theme_id'
                . ' WHERE n.news_id = ?', $rsMap);
        $query->setParameter(1, $id);
        $newsItem = $query->getSingleResult();

        if (!$newsItem) {
            return $this->redirect()->toRoute('news');
        }

        return new ViewModel(array(
            'newsItem' => $newsItem,
            'news_archive'  => $this->_getNewsArchive(),
            'by_topic'      => $this->_getNewsByTopic()
        ));
    }

    private function _groupBy($array, $key)
    {
        $result = array();
        foreach ($array as $value) {
            $result[$value[$key]][] = $value;
        }
        return $result;
    }

    private function _getNewsArchive()
    {
        $rsMap = new ResultSetMapping();
        $rsMap->addScalarResult('year', 'year');
        $rsMap->addScalarResult('month', 'month');
        $rsMap->addScalarResult('count', 'count');

        $query = $this->em
            ->createNativeQuery(
                'SELECT YEAR(date) AS year, MONTH(date) AS month, COUNT(*) AS count'
                . ' FROM news'
                . ' GROUP BY year, month'
                . ' ORDER BY year DESC, month DESC', $rsMap);
        $result = $query->getScalarResult();

        return $this->_groupBy($result, 'year');
    }

    private function _getNewsByTopic()
    {
        $themeRsMap = new ResultSetMapping();
        $themeRsMap->addScalarResult('theme', 'theme');
        $themeRsMap->addScalarResult('count', 'news_count');

        $theme_query = $this->em
            ->createNativeQuery(
                'SELECT t.theme_title AS theme, COUNT(n.theme_id) AS count'
                . ' FROM news n INNER JOIN themes t'
                . ' ON t.theme_id = n.theme_id'
                . ' GROUP BY n.theme_id', $themeRsMap);
        return $theme_query->getScalarResult();
    }
}