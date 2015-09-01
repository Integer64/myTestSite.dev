<?php
namespace Application\CatMouse\classes;

use Application\CatMouse\models\Field;
use \SplObjectStorage;

abstract class Animal
{
    public $name;
    private $fieldOfVision;
    private $cruisingRange;
    private $location = ["x" => 0, "y" => 0];
    private $seeAnimals;
    private $naturalEnemies;
    private $field;

    public function __construct($fieldOfVision, $cruisingRange, $name,  Field $field)
    {
        $this->fieldOfVision = $fieldOfVision;
        $this->cruisingRange = $cruisingRange;
        $this->name = $name;
        $this->field = $field;
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

    public function lookAround()
    {
        $listOfAnimals = clone $this->getField()->getListOfAnimals();

        $seeAnimals = new SplObjectStorage();
        $range = $this->getRangeView();

        foreach ($listOfAnimals as $animal) {
            if ($animal === $this) continue;

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

    public function getField()
    {
        return $this->field;
    }

    protected function getDistanceToAnimal(Animal $animal, $cellCoordinates){
        $location = $cellCoordinates;
        $locationCell = $animal->getLocation();
        $distance = sqrt(pow($location["x"] - $locationCell["x"], 2) + pow($location["y"] - $locationCell["y"], 2));
        return round($distance, 2);
    }

    protected function checkNearCells(Animal $nearAnimal, $checkAnimal){
        $countOfNearAnimals = 0;
        $locationMouse = $nearAnimal->getLocation();
        $coordinatesToCheck = $this->generateCoordinates($locationMouse);

        foreach($coordinatesToCheck as $coordinates){
            $cell = $this->checkCells($coordinates);
            if($cell instanceof $checkAnimal){
                $countOfNearAnimals += 1;
            }
        }
        return $countOfNearAnimals;
    }

    // Проверить массив на дубликаты
    private function checkArrayOnDuplicate($array, $checkValue){
        foreach($array as $value){
            $arr = array_diff_assoc($value, $checkValue);
            if(count($arr) == 0){
                return true;
            }
        }
        return false;
    }

    protected function generateCoordinates($center)
    {
        $coordinatesToCheck = [];

        $coordinates[] = ["x" => $center["x"] - 1 < 1 ? $center["x"] : $center["x"] - 1,
            "y" => $center["y"] - 1 < 1 ? $center["y"] : $center["y"] - 1];

        $coordinates[] = ["x" => $center["x"] - 1 < 1 ? $center["x"] : $center["x"] - 1,
            "y" => $center["y"]];

        $coordinates[] = ["x" => $center["x"] - 1 < 1 ? $center["x"] : $center["x"] - 1,
            "y" => $center["y"] + 1 > $this->field->getSize() ? $center["y"] : $center["y"] + 1];

        $coordinates[] = ["x" => $center["x"],
            "y" => $center["y"] + 1 > $this->field->getSize() ? $center["y"] : $center["y"] + 1];

        $coordinates[] = ["x" => $center["x"] + 1 > $this->field->getSize() ? $center["x"] : $center["x"] + 1,
            "y" => $center["y"] + 1 > $this->field->getSize() ? $center["y"] : $center["y"] + 1];

        $coordinates[] = ["x" => $center["x"] + 1 > $this->field->getSize() ? $center["x"] : $center["x"] + 1,
            "y" => $center["y"]];

        $coordinates[] = ["x" => $center["x"] + 1 > $this->field->getSize() ? $center["x"] : $center["x"] + 1,
            "y" => $center["y"] - 1 < 1 ? $center["y"] : $center["y"] - 1];

        $coordinates[] = ["x" => $center["x"],
            "y" => $center["y"] - 1 < 1 ? $center["y"] : $center["y"] - 1];

        foreach ($coordinates as $coordinate) {
            if (count(array_diff_assoc($center, $coordinate)) != 0) {
                $isDuplicate = $this->checkArrayOnDuplicate($coordinatesToCheck, $coordinate);
                if ($isDuplicate == false) {
                    $coordinatesToCheck[] = $coordinate;
                }
            }
        }

        return $coordinatesToCheck;
    }

    // Проверить ячейку
    protected function checkCells($coordinatesCell){
        $list = $this->getField()->getListOfAnimals();
        foreach ($list as $animal){
            $coordinates = $animal->getLocation();
            if($coordinates["x"] == $coordinatesCell["x"] && $coordinates["y"] == $coordinatesCell["y"]){
                return $animal;
            }
        }
        return null;
    }

    abstract public function walk();

    abstract public function getLabel();


} 