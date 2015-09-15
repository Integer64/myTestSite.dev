<?php
namespace Application\CatMouse\models;

use Application\CatMouse\classes\Animal;

/**
 * TODO: Проверять рядом стоящие клетки с мышью.
 */
class Cat extends Animal
{
    private $naturalEnemies = '\Application\CatMouse\models\Dog';
    private $huntAnimals = '\Application\CatMouse\models\Mouse';
    private $sleep = false;
    private $countTurns = 0;
    CONST START_POINTS = 100;

    public function walk()
    {
        // Логика сна.
        if ($this->countTurns > 8) {
            $this->sleep = false;
            $this->countTurns = 0;
        }

        $this->countTurns += 1;
        if ($this->countTurns == 8) {
            $this->sleep = true;
        }

        if ($this->sleep) {
            return;
        }

        // Список куда можно сходить
        $listWhereWeCanGo = $this->whereWeCanWalk();

        $listWithPoints = [];

        foreach ($listWhereWeCanGo as $cell) {
            $points = $this->appraisal($cell);
            $listWithPoints[] = [$cell, $points];
            $c[] = $cell;
            $p[] = $points;
        }

        array_multisort($p, SORT_DESC, $listWithPoints);

        $maxPoints = $listWithPoints[0][1];
        $dest = $listWithPoints[0][0];


        foreach ($listWithPoints as $item) {
            if ($item[1] == $maxPoints) {
                $listWithMaxPoints[] = [$item[0], $item[1]];
            }
        }

        if (count($listWithMaxPoints) > 0) {
            $rand = mt_rand(0, count($listWithMaxPoints) - 1);
            $dest = $listWithMaxPoints[$rand][0];
        }

        $huntAnimals = $this->huntAnimals;
        $field = $this->getField();
        $prey = $field->checkCells($dest);

        if (is_null($prey)) {
            $this->setLocation($dest);
        } elseif ($prey instanceof $huntAnimals) {
            $this->setLocation($dest);
            $this->eat($prey);
        }
    }

    // Проверяем куда можно идти
    private function whereWeCanWalk()
    {
        $huntAnimals = $this->huntAnimals;
        $location = $this->getLocation();
        $field = $this->getField();
        $checkCells = $field->generateCoordinates($location);
        $emptyCells[] = $location;
        foreach ($checkCells as $cell) {
            $cellStatus = $field->checkCells($cell);
            if (is_null($cellStatus) || $cellStatus instanceof $huntAnimals) {
                $emptyCells[] = $cell;
            }
        }
        return $emptyCells;
    }

    // Оценка хода
    private function appraisal($cell)
    {
        $pointsCell = 0;
        $field = $this->getField();
        $seeAnimals = $this->getSeeAnimals();
        $huntAnimals = $this->huntAnimals;
        foreach ($seeAnimals as $animal) {
            if ($animal instanceof $huntAnimals) {
                $distance = $field->getDistanceToAnimalFromCell($animal, $cell);
                $countNearAnimals = $field->checkNearCells($cell, $huntAnimals);

                if ($distance == 0) {
                    $startPoints = static::START_POINTS * 2;
                } else {
                    $startPoints = static::START_POINTS;
                }

                if ($countNearAnimals == 2) {
                    $pointsCell += ($startPoints - $distance) / $countNearAnimals;
                } else {
                    $pointsCell += $startPoints - $distance;
                }
            }
        }
        return $pointsCell;
    }


    // Кушаем мышку
    private function eat(Animal $prey)
    {
        $locationPrey = $prey->getLocation();
        $location = $this->getLocation();
        if ($locationPrey["x"] == $location["x"] && $locationPrey["y"] == $location["y"]) {
            $field = $this->getField();
            $field->deleteAnimalFromField($prey);
            $this->sleep = true;
            $this->countTurns = 8;
            return true;
        } else {
            return false;
        }
    }


    public function getLabel()
    {
        if ($this->sleep) {
            return "@";
        }
        return "C";
    }
}