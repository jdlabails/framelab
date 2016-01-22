<?php

namespace Framelab\Bundle\TwitterBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Retweeter
 *
 * @ORM\Table(name="retweeter")
 * @ORM\Entity()
 */
class Retweeter
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="query", type="string", length=255)
     */
    private $query;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="frequencyPerDay", type="integer")
     */
    private $frequencyPerDay;

    /**
     * @var bool
     *
     * @ORM\Column(name="actif", type="boolean")
     */
    private $actif;

    /**
     * @var string
     *
     * @ORM\Column(name="nbMonthKeeping", type="integer")
     */
    private $nbMonthKeeping;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="lastLaunch", type="datetime", nullable=true)
     */
    private $lastLaunch;

    public function __construct()
    {
        $this->lastLaunch = new \DateTime;
    }
    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set query
     *
     * @param string $query
     *
     * @return Retweeter
     */
    public function setQuery($query)
    {
        $this->query = $query;

        return $this;
    }

    /**
     * Get query
     *
     * @return string
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Retweeter
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set frequencyPerDay
     *
     * @param string $frequencyPerDay
     *
     * @return Retweeter
     */
    public function setFrequencyPerDay($frequencyPerDay)
    {
        $this->frequencyPerDay = $frequencyPerDay;

        return $this;
    }

    /**
     * Get frequencyPerDay
     *
     * @return string
     */
    public function getFrequencyPerDay()
    {
        return $this->frequencyPerDay;
    }

    /**
     * Set actif
     *
     * @param boolean $actif
     *
     * @return Retweeter
     */
    public function setActif($actif)
    {
        $this->actif = $actif;

        return $this;
    }

    /**
     * Get actif
     *
     * @return bool
     */
    public function getActif()
    {
        return $this->actif;
    }

    /**
     * Set nbMonthKeeping
     *
     * @param string $nbMonthKeeping
     *
     * @return Retweeter
     */
    public function setNbMonthKeeping($nbMonthKeeping)
    {
        $this->nbMonthKeeping = $nbMonthKeeping;

        return $this;
    }

    /**
     * Get nbMonthKeeping
     *
     * @return string
     */
    public function getNbMonthKeeping()
    {
        return $this->nbMonthKeeping;
    }

    /**
     * Set lastLaunch
     *
     * @param \DateTime lastLaunch
     *
     * @return RetweetStat
     */
    public function setLastLaunch($lastLaunch)
    {
        $this->lastLaunch = $lastLaunch;

        return $this;
    }

    /**
     * Get lastLaunch
     *
     * @return \DateTime
     */
    public function getLastLaunch()
    {
        return $this->lastLaunch;
    }
}
