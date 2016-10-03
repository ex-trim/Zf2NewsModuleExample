<?php

namespace News\Library;

use Doctrine\ORM\Query\ResultSetMappingBuilder;

class Paginator
{
    private $count;
    private $currentPage;
    private $totalPages;

    /**
     * paginate results
     *
     * @param $query can be NativeQuery
     * @param int $page
     * @param $limit
     * @return array
     */
    public function paginate($query, $page = 1, $limit = 5)
    {
        $this->currentPage = $page;
        $limit = (int) $limit;

        if(is_a($query, 'Doctrine\ORM\NativeQuery')) {
            $sqlInitial = $query->getSQL();

            $rsMap = new ResultSetMappingBuilder($query->getEntityManager());
            $rsMap->addScalarResult('count', 'count');

            $sqlCount = 'SELECT COUNT(*) AS count FROM (' . $sqlInitial . ') AS item';
            $qCount = $query->getEntityManager()->createNativeQuery($sqlCount, $rsMap);
            $qCount->setParameters($query->getParameters());

            $resultCount = (int) $qCount->getSingleScalarResult();
            $this->count = $resultCount;

            $query->setSQL($query->getSQL() . ' LIMIT ' . (($page - 1) * $limit) . ', ' . $limit);
        }

        $this->totalPages = ceil($this->count / $limit);

        return $query->getResult();
    }

    public function getCurrentPage()
    {
        return $this->currentPage;
    }

    public function getTotalPages()
    {
        return $this->totalPages;
    }

    public function getCount()
    {
        return $this->count;
    }
}