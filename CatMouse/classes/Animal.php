<?php
namespace Application\CatMouse\classes;

use \SplObjectStorage;

abstract class Animal{
    CONST RANDFORWALK = 1;
    private $fieldOfVision;
    private $cruisingRange;
    private $location = ["x" => 0, "y" => 0];
    protected $seeAnimals;

    public function __construct($fieldOfVision, $cruisingRange){
        $this->fieldOfVision = (int) floor($fieldOfVision/2);
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
        $fieldOfVision = $this->getFieldOfVision();
        $xMin = $location["x"] - $fieldOfVision < 0 ? 0 : $location["x"] - $fieldOfVision;
        $xMax = $location["x"] + $fieldOfVision;
        $xRange = ["xMin" => $xMin, "xMax" => $xMax];

        $yMin = $location["y"] - $fieldOfVision < 0 ? 0 : $location["y"] - $fieldOfVision;
        $yMax = $location["y"] + $fieldOfVision;
        $yRange = ["yMin" => $yMin, "yMax" => $yMax];

        return ["x" => $xRange, "y" => $yRange];
    }

    public function lookAround(SplObjectStorage $animals)
    {
        $this->seeAnimals = new SplObjectStorage();
        $range = $this->getRangeView();
        foreach ($animals as $animal) {
            if ($animal === $this) continue;
            $animalLocation = $animal->getLocation();
            if (($animalLocation["x"] >= $range["x"]["xMin"] || $animalLocation["x"] <= $range["x"]["xMax"])
                && ($animalLocation["y"] >= $range["y"]["yMin"] || $animalLocation["y"] <= $range["y"]["yMax"])
            ) {
                $this->seeAnimals->attach($animal);
            }
        }
    }

    abstract public function getLabel();

    abstract public function walk();

} 