<?php
namespace Application\CatMouse\models;

use Application\CatMouse\classes\Animal;

/**
 * TODO: Обзор мыши вокруг: что бы не ходила на занятые клетки.
 */
class Mouse extends Animal
{
    CONST START_POINTS = 100;

    private $naturalEnemies = '\Application\CatMouse\models\Cat';
    private $friendAnimals = '\Application\CatMouse\models\Dog';

    public function __construct($fieldOfVision, $cruisingRange, $name, Field $field)
    {
        parent::__construct($fieldOfVision, $cruisingRange, $name, $field);
        $this->setFieldOfVision((int)floor($fieldOfVision / 2));
    }

    public function walk()
    {
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

        $this->setLocation($dest);
    }

    // Проверяем куда можно идти
    private function whereWeCanWalk()
    {
        $location = $this->getLocation();
        $field = $this->getField();
        $checkCells = $field->generateCoordinates($location);
        $emptyCells[] = $location;
        foreach ($checkCells as $cell) {
            $cellStatus = $field->checkCells($cell);
            if (is_null($cellStatus)) {
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
        $naturalEnemies = $this->naturalEnemies;
        foreach ($seeAnimals as $animal) {
            if ($animal instanceof $naturalEnemies) {
                $distance = $field->getDistanceToAnimalFromCell($animal, $cell);
                $startPoints = static::START_POINTS;
                $pointsCell += $startPoints + $distance;
            }
        }
        return $pointsCell;
    }

    public function getLabel()
    {
        return "M";
    }

}