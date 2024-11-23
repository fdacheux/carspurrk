<?php

namespace App\Entity;
use Symfony\Component\Validator\Constraints as Assert;
class CarSearch
{
    /**
     *
     */
    #[Assert\LessThanOrEqual(propertyPath:"maxYear", message:"The min year must be less than the max year")]
    private $minYear;
        /**
     *
     */
    
     #[Assert\GreaterThanOrEqual(propertyPath:"minYear", message:"The max year must be higher than the min year")]
    private $maxYear;  

    function getMinYear(): ?int
    {
        return $this->minYear;
    }

    function getMaxYear(): ?int 
    {
        return $this->maxYear;
    }

    public function setMinYear(int $year)
    {
        $this->minYear = $year;

        return $this;
    }

    public function setMaxYear(int $year)
    {
        $this->maxYear = $year;

        return $this;
    }

   
}
?>