<?php
namespace Application\CatMouse\models;

use Application\CatMouse\classes\Animal;

/**
 * TODO: Обзор мыши вокруг: что бы не ходила на занятые клетки.
 */

class Mouse extends Animal
{
    CONST DIRECTION_FIRST = 0;
    CONST DIRECTION_SECOND = 2;

    private $naturalEnemies = '\Application\CatMouse\models\Cat';
    private $friendAnimals = '\Application\CatMouse\models\Dog';

    public function __construct($fieldOfVision, $cruisingRange, $name, Field $field){
        parent::__construct($fieldOfVision, $cruisingRange, $name, $field);
        $this->setFieldOfVision((int)floor($fieldOfVision / 2));
    }

    public function walk()
    {
        $seeAnimals = $this->getSeeAnimals();
        $naturalEnemies = $this->naturalEnemies;

        $animalEnemies = null;

        foreach ($seeAnimals as $animal) {
            if ($animal instanceof $naturalEnemies) {
                $animalEnemies = $animal;
            }
        }

        if(is_null($animalEnemies)){
            $this->randomWalk();
        }else{
            $this->goAwayFromNaturalEnemies($animalEnemies);
        }

    }

    private function goAwayFromNaturalEnemies(Animal $animalEnemies){
        $location = $this->getLocation();
        $direction = mt_rand(self::DIRECTION_FIRST, self::DIRECTION_SECOND);
        $locationEnemies = $animalEnemies->getLocation();
        switch (true) {
            // Кот вверху и слева
            case ($locationEnemies["x"] < $location["x"] && $locationEnemies["y"] < $location["y"]):
                if ($direction > self::DIRECTION_FIRST) {
                    $this->goRight();
                } else {
                    $this->goDown();
                }
                return;
                break;
            // Кот вверху и справа
            case ($locationEnemies["x"] > $location["x"] && $locationEnemies["y"] < $location["y"]):
                if ($direction > self::DIRECTION_FIRST) {
                    $this->goLeft();
                } else {
                    $this->goDown();
                }
                return;
                break;
            // Кот внизу и слева
            case ($locationEnemies["x"] < $location["x"] && $locationEnemies["y"] > $location["y"]):
                if ($direction > self::DIRECTION_FIRST) {
                    $this->goRight();
                } else {
                    $this->goUp();
                }
                return;
                break;
            // Кот внизу и справа
            case ($locationEnemies["x"] > $location["x"] && $locationEnemies["y"] > $location["y"]):
                if ($direction > self::DIRECTION_FIRST) {
                    $this->goLeft();
                } else {
                    $this->goUp();
                }
                return;
                break;
            // Кот внизу
            case ($locationEnemies["x"] == $location["x"] && $locationEnemies["y"] > $location["y"]):
                if($direction == self::DIRECTION_FIRST) {
                    $this->goUp();
                } elseif ($direction == self::DIRECTION_SECOND) {
                    $this->goLeft();
                } else {
                    $this->goRight();
                }
                return;
                break;
            // Кот вверху
            case ($locationEnemies["x"] == $location["x"] && $locationEnemies["y"] < $location["y"]):
                if($direction == self::DIRECTION_FIRST) {
                    $this->goDown();
                } elseif ($direction == self::DIRECTION_SECOND) {
                    $this->goLeft();
                } else {
                    $this->goRight();
                }
                return;
                break;
            // Кот справо
            case ($locationEnemies["x"] > $location["x"] && $locationEnemies["y"] == $location["y"]):
                if($direction == self::DIRECTION_FIRST) {
                    $this->goUp();
                } elseif ($direction == self::DIRECTION_SECOND) {
                    $this->goLeft();
                } else {
                    $this->goDown();
                }
                return;
                break;
            // Кот слева
            case ($locationEnemies["x"] < $location["x"] && $locationEnemies["y"] == $location["y"]):
                if($direction == self::DIRECTION_FIRST) {
                    $this->goUp();
                } elseif ($direction == self::DIRECTION_SECOND) {
                    $this->goRight();
                } else {
                    $this->goDown();
                }
                return;
                break;
            // Не видно кота
            default:
                break;
        }
    }


    // Выбор случайного направления
    protected function randomWalk()
    {
        // Псевдослучайные числа для выбора направления
        $xRand = mt_rand(-self::RAND_FOR_WALK, self::RAND_FOR_WALK);
        $yRand = mt_rand(-self::RAND_FOR_WALK, self::RAND_FOR_WALK);

        switch (true) {
            // Идем вправо
            case ($xRand == 1 && $yRand == 0):
                $this->goRight();
                return;
                break;
            // Идем влево
            case ($xRand == -1 && $yRand == 0):
                $this->goLeft();
                return;
                break;
            // Идем вниз
            case ($xRand == 0 && $yRand == 1):
                $this->goDown();
                return;
                break;
            // Идем вверх
            case ($xRand == 0 && $yRand == -1):
                $this->goUp();
                return;
                break;
            // Стоим
            default:
                break;
        }
    }

    public function getLabel()
    {
        return "M";
    }

} 