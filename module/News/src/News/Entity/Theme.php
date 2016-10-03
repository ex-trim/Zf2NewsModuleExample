<?php

namespace News\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Theme
 *
 * @ORM\Entity
 * @ORM\Table(name="themes")
 */
class Theme
{
    /**
     * @ORM\Id
     * @ORM\Column(name="theme_id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $theme_id;

    /**
     * @ORM\Column(name="theme_title", type="string", length=255)
     */
    private $name;

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->theme_id;
    }

    /**
     * @param integer $theme_id
     */
    public function setId($theme_id)
    {
        $this->theme_id = (int) $theme_id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    public function __toString()
    {
        return $this->name;
    }

    public function __get($name)
    {
        if (property_exists($this, $name)) {
            return $this->$name;
        }

        return null;
    }

    public function __set($name, $value)
    {
        if (property_exists($this, $name)) {
            $this->$name = $value;
        }
    }

    public function exchangeArray($data)
    {
        $this->theme_id     = (!empty($data['id']))         ? $data['id']    : null;
        $this->name         = (!empty($data['name']))       ? $data['name']  : null;
    }

    public function getArrayCopy()
    {
        return array(
            'theme_id'      => $this->getId(),
            'name'          => $this->getName()
        );
    }
}