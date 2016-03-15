<?php

namespace Framelab\Bundle\RateBundle\Entity\Traits;

/**
 * trait used to make an entity ratable
 */
trait RatableTrait
{
    /**
     * @ORM\OneToMany(targetEntity="Framelab\Bundle\RateBundle\Entity\Rate", mappedBy="ratable")
     *
     */
    protected $rates;

    /**
     * Get id
     *
     * @return integer
     */
    public function getRates()
    {
        return $this->rates;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function setRates($rates)
    {
        return $this->rates = $rates;
    }
}
