<?php
/**
 * Created by IntelliJ IDEA.
 * User: Arsene
 * Date: 12/06/2020
 * Time: 10:38
 */

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
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
     * @var ArrayCollection
     */
    private $options;

    /**
     * PropertySearch constructor.
     */
    public function __construct()
    {
        $this->options = new ArrayCollection();
    }


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

    /**
     * @return ArrayCollection
     */
    public function getOptions(): ArrayCollection
    {
        return $this->options;
    }

    /**
     * @param ArrayCollection $options
     * @return PropertySearch
     */
    public function setOptions(ArrayCollection $options): PropertySearch
    {
        $this->options = $options;
        return $this;
    }

}