<?php
namespace Application\CatMouse\classes;

use \SplObjectStorage;

abstract class Animal
{
    public $name;
    CONST RAND_FOR_WALK = 1;
    private $fieldOfVision;
    private $cruisingRange;
    private $location = ["x" => 0, "y" => 0];
    private $seeAnimals;
    private $hashOfAnimal;
    private $naturalEnemies;
    private $fieldSize;

    public function __construct($fieldOfVision, $cruisingRange, $name, $fieldSize)
    {
        $this->fieldOfVision = $fieldOfVision;
        $this->cruisingRange = $cruisingRange;
        $this->name = $name;
        $this->hashOfAnimal = spl_object_hash($this);
        $this->fieldSize = $fieldSize;
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

    protected function getRangeView()
    {
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

    public function lookAround(SplObjectStorage $listOfAnimals)
    {
        $seeAnimals = new SplObjectStorage();
        $range = $this->getRangeView();

        foreach ($listOfAnimals as $animal) {
            if (spl_object_hash($animal) === $this->hashOfAnimal) continue;

            $animalLocation = $animal->getLocation();

            if (
                ($animalLocation["x"] >= $range["x"]["xMin"] && $animalLocation["x"] <= $range["x"]["xMax"])
                && ($animalLocation["y"] >= $range["y"]["yMin"] && $animalLocation["y"] <= $range["y"]["yMax"])
            ) {
                $seeAnimals->attach($animal);
            }
        }
        $this->setSeeAnimals($seeAnimals);
    }

    public function getSeeAnimals()
    {
        return $this->seeAnimals;
    }

    public function setSeeAnimals(SplObjectStorage $seeAnimals)
    {
        $this->seeAnimals = $seeAnimals;
    }

    public function getFieldSize()
    {
        return $this->fieldSize;
    }

    protected function goUp(){
        $this->location["y"] = $this->location["y"] - $this->cruisingRange < 1 ? 1 : $this->location["y"] - $this->cruisingRange;
        echo "Go up\n";
    }

    protected function goDown(){
        $this->location["y"] = $this->location["y"] + $this->cruisingRange > $this->fieldSize ? $this->fieldSize : $this->location["y"] + $this->cruisingRange;
        echo "Go down\n";
    }

    protected function goLeft(){
        $this->location["x"] = $this->location["x"] - $this->cruisingRange < 1 ? 1 : $this->location["x"] - $this->cruisingRange;
        echo "Go left\n";
    }

    protected function goRight(){
        $this->location["x"] = $this->location["x"] + $this->cruisingRange > $this->fieldSize ? $this->fieldSize : $this->location["x"] + $this->cruisingRange;
        echo "Go right\n";
    }

    abstract public function walk();

    abstract protected function randomWalk();

    abstract public function getLabel();


} 