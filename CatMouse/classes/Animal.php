<?php
namespace Application\CatMouse\classes;

abstract class Animal{
    private $fieldOfVision;
    private $cruisingRange;
    private $location = [0, 0];

    public function __construct($fieldOfVision, $cruisingRange){
        $this->fieldOfVision = $fieldOfVision;
        $this->cruisingRange = $cruisingRange;
    }

    public function getCruisingRange()
    {
        return $this->cruisingRange;
    }

    public function setCruisingRange($cruisingRange)
    {
        $this->cruisingRange = $cruisingRange;
    }

    public function getFieldOfVision()
    {
        return $this->fieldOfVision;
    }

    public function setFieldOfVision($fieldOfVision)
    {
        $this->fieldOfVision = $fieldOfVision;
    }

    public function getLocation()
    {
        return $this->location;
    }

    public function setLocation($location)
    {
        $this->location = $location;
    }



} 