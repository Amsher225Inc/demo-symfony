<?php
/**
 * Created by IntelliJ IDEA.
 * User: Arsene
 * Date: 12/06/2020
 * Time: 10:38
 */

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class PropertySearch
{

    /**
     * @var int | null
     * @Assert\Range(min=80000)
     */
    private $maxPrice;


    /**
     * @var int | null
     * @Assert\Range(min=10, max=1000)
     */
    private $minSurface;


    /**
     * @return mixed
     */
    public function getMaxPrice()
    {
        return $this->maxPrice;
    }

    /**
     * @param mixed $maxPrice
     * @return PropertySearch
     */
    public function setMaxPrice($maxPrice)
    {
        $this->maxPrice = $maxPrice;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMinSurface()
    {
        return $this->minSurface;
    }

    /**
     * @param mixed $minSurface
     * @return PropertySearch
     */
    public function setMinSurface($minSurface)
    {
        $this->minSurface = $minSurface;
        return $this;
    }

}