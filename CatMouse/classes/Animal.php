<?php
namespace Application\CatMouse\classes;

abstract class Animal{
    CONST RANDFORWALK = 1;
    private $fieldOfVision;
    private $cruisingRange;
    private $location = ["x" => 0, "y" => 0];
    protected $seeAnimals;

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

    protected function getRangeView(){
        $location = $this->getLocation();
        $cruisingRange = $this->getCruisingRange();
        $xMin = $location["x"] - $cruisingRange < 0 ? 0 : $location["x"] - $cruisingRange;
        $xMax = $location["x"] + $cruisingRange;
        $xRange = ["xMin" => $xMin, "xMax" => $xMax];

        $yMin = $location["y"] - $cruisingRange < 0 ? 0 : $location["y"] - $cruisingRange;
        $yMax = $location["y"] + $cruisingRange;
        $yRange = ["yMin" => $yMin, "yMax" => $yMax];

        return ["x" => $xRange, "y" => $yRange];
    }

    abstract public function getLabel();

    abstract public function walk();

} 