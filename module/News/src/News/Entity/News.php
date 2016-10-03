<?php

namespace News\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\JoinColumn;

/**
 * Class News
 *
 * @ORM\Entity
 * @ORM\Table(name="news")
 */
class News
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $news_id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;

    /**
     * @ManyToOne(targetEntity="Theme")
     * @JoinColumn(name="theme_id", referencedColumnName="theme_id")
     */
    /*
     * @ORM\Column(name="theme_id", type="integer")
     */
    private $theme;

    /**
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(name="text", type="text", nullable=true)
     */
    private $text;

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->news_id;
    }

    /**
     * @param integer $news_id
     */
    public function setId($news_id)
    {
        $this->news_id = (int) $news_id;
    }

    /**
     * @return string
     */
    public function getDate()
    {
        if (is_object($this->date))
            return date_format($this->date, 'd/m/Y');
    }

    /**
     * @param string $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return mixed
     */
    public function getTheme()
    {
        return $this->theme;
    }

    /**
     * @param $theme
     */
    public function setTheme($theme)
    {
        $this->theme = $theme;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param string $text
     */
    public function setText($text)
    {
        $this->text = $text;
    }

    public function exchangeArray($data)
    {
        $this->news_id  = (!empty($data['news_id']))    ? $data['news_id']  : null;
        $this->date     = (!empty($data['date']))       ? $data['date']     : null;
        $this->theme    = (!empty($data['theme']))      ? $data['theme']    : null;
        $this->title    = (!empty($data['title']))      ? $data['title']    : null;
        $this->text     = (!empty($data['text']))       ? $data['text']     : null;
    }

    public function getArrayCopy()
    {
        return array(
            'news_id'   => $this->getId(),
            'date'      => $this->getDate(),
            'theme'     => $this->getTheme(),//is_object($this->getTheme()) ? $this->getTheme()->getId() : null,
            'title'     => $this->getTitle(),
            'text'      => $this->getText(),
        );
    }
}