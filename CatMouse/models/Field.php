<?php
namespace Application\CatMouse\models;

use Application\CatMouse\classes\Animal;
use \SplObjectStorage;

class Field
{
    private $size;
    private $listOfAnimals;

    public function __construct($size)
    {
        $this->size = $size;
        $this->listOfAnimals = new SplObjectStorage();
    }

    public function addAnimalToField(Animal $animal)
    {
        $this->listOfAnimals->attach($animal);
    }

    public function deleteAnimalFromField(Animal $animal)
    {
        if ($this->getListOfAnimals()->contains($animal)) {
            $this->getListOfAnimals()->detach($animal);
        }
    }

    public function getListOfAnimals()
    {
        return $this->listOfAnimals;
    }

    public function getSize()
    {
        return $this->size;
    }

    public function getDistanceToAnimalFromCell(Animal $animal, $cellCoordinates)
    {
        $location = $cellCoordinates;
        $locationCell = $animal->getLocation();
        $distance = sqrt(pow($location["x"] - $locationCell["x"], 2) + pow($location["y"] - $locationCell["y"], 2));
        return $distance;
    }

    public function checkNearCells($cells, $checkAnimal)
    {
        $countOfNearAnimals = 0;
        $locationMouse = $cells;
        $coordinatesToCheck = $this->generateCoordinates($locationMouse);
        foreach ($coordinatesToCheck as $coordinates) {
            $cell = $this->checkCells($coordinates);
            if ($cell instanceof $checkAnimal) {
                $countOfNearAnimals += 1;
            }
        }
        return $countOfNearAnimals;
    }

    // Проверить массив на дубликаты
    private function checkArrayOnDuplicate($array, $checkValue)
    {
        foreach ($array as $value) {
            $arr = array_diff_assoc($value, $checkValue);
            if (count($arr) == 0) {
                return true;
            }
        }
        return false;
    }

    public function generateCoordinates($center)
    {
        $coordinatesToCheck = [];

        $coordinates[] = ["x" => $center["x"] - 1 < 1 ? $center["x"] : $center["x"] - 1,
            "y" => $center["y"] - 1 < 1 ? $center["y"] : $center["y"] - 1];

        $coordinates[] = ["x" => $center["x"] - 1 < 1 ? $center["x"] : $center["x"] - 1,
            "y" => $center["y"]];

        $coordinates[] = ["x" => $center["x"] - 1 < 1 ? $center["x"] : $center["x"] - 1,
            "y" => $center["y"] + 1 > $this->getSize() ? $center["y"] : $center["y"] + 1];

        $coordinates[] = ["x" => $center["x"],
            "y" => $center["y"] + 1 > $this->getSize() ? $center["y"] : $center["y"] + 1];

        $coordinates[] = ["x" => $center["x"] + 1 > $this->getSize() ? $center["x"] : $center["x"] + 1,
            "y" => $center["y"] + 1 > $this->getSize() ? $center["y"] : $center["y"] + 1];

        $coordinates[] = ["x" => $center["x"] + 1 > $this->getSize() ? $center["x"] : $center["x"] + 1,
            "y" => $center["y"]];

        $coordinates[] = ["x" => $center["x"] + 1 > $this->getSize() ? $center["x"] : $center["x"] + 1,
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
    public function checkCells($coordinatesCell)
    {
        $listOfAnimals = $this->getListOfAnimals();
        foreach ($listOfAnimals as $animal) {
            $coordinates = $animal->getLocation();
            if ($coordinates["x"] == $coordinatesCell["x"] && $coordinates["y"] == $coordinatesCell["y"]) {
                return $animal;
            }
        }
        return null;
    }
}