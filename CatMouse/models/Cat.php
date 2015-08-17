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
    CONST MIN_DISTANCE = 10000;

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

        $location = $this->getLocation();
        $seeAnimals = $this->getSeeAnimals();
        $huntAnimals = $this->huntAnimals;

        $nearAnimal = null;
        $minDistance = static::MIN_DISTANCE;

        foreach ($seeAnimals as $animal) {
            if ($animal instanceof $huntAnimals) {
                $distance = $this->getDistanceToAnimal($animal);
                if ($distance < $minDistance) {
                    $nearAnimal = $animal;
                    $minDistance = $distance;
                }
            }
        }

        if(is_null($nearAnimal)){
            $this->randomWalk();
        } else {
            $this->hunt($nearAnimal);
        }
    }

    // Охотимся на жертву
    private function hunt(Animal $prey){
        $location = $this->getLocation();
        $locationPrey = $prey->getLocation();
        $huntAnimals = $this->huntAnimals;
        switch (true) {
            // Мышка вверху и слева
            case ($locationPrey["x"] < $location["x"] && $locationPrey["y"] < $location["y"]):
                $this->checkNearCells($prey, $huntAnimals);
                $this->goUpAndLeft(true);
                $this->eat($prey);
                return;
                break;
            // Мышка вверху и справа
            case ($locationPrey["x"] > $location["x"] && $locationPrey["y"] < $location["y"]):
                $this->checkNearCells($prey, $huntAnimals);
                $this->goUpAndRight(true);
                $this->eat($prey);
                return;
                break;
            // Мышка внизу и слева
            case ($locationPrey["x"] < $location["x"] && $locationPrey["y"] > $location["y"]):
                $this->checkNearCells($prey, $huntAnimals);
                $this->goDownAndLeft(true);
                $this->eat($prey);
                return;
                break;
            // Мышка внизу и слева
            case ($locationPrey["x"] > $location["x"] && $locationPrey["y"] > $location["y"]):
                $this->checkNearCells($prey, $huntAnimals);
                $this->goDownAndRight(true);
                $this->eat($prey);
                return;
                break;
            // Мышка внизу
            case ($locationPrey["x"] == $location["x"] && $locationPrey["y"] > $location["y"]):
                $this->checkNearCells($prey, $huntAnimals);
                $this->goDown(true);
                $this->eat($prey);
                return;
                break;
            // Мышка вверху
            case ($locationPrey["x"] == $location["x"] && $locationPrey["y"] < $location["y"]):
                $this->checkNearCells($prey, $huntAnimals);
                $this->goUp(true);
                $this->eat($prey);
                return;
                break;
            // Мышка справа
            case ($locationPrey["x"] > $location["x"] && $locationPrey["y"] == $location["y"]):
                $this->checkNearCells($prey, $huntAnimals);
                $this->goRight(true);
                $this->eat($prey);
                return;
                break;
            // Мышка слева
            case ($locationPrey["x"] < $location["x"] && $locationPrey["y"] == $location["y"]):
                $this->checkNearCells($prey, $huntAnimals);
                $this->goLeft(true);
                $this->eat($prey);
                return;
                break;
            case ($locationPrey["x"] == $location["x"] && $locationPrey["y"] == $location["y"]):
                $this->checkNearCells($prey, $huntAnimals);
                $this->eat($prey);
                return;
                break;
            // Мышку не видно
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
                break;
            // Идем влево
            case ($xRand == -1 && $yRand == 0):
                $this->goLeft();
                break;
            // Идем вниз
            case ($xRand == 0 && $yRand == 1):
                $this->goDown();
                break;
            // Идем вверх
            case ($xRand == 0 && $yRand == -1):
                $this->goUp();
                break;
            // Идем вниз и влево
            case ($xRand == -1 && $yRand == -1):
                $this->goDown();
                $this->goLeft();
                break;
            // Идем вверх и вправо
            case ($xRand == 1 && $yRand == 1):
                $this->goUp();
                $this->goRight();
                break;
            // Идем вверх и влево
            case ($xRand == -1 && $yRand == 1):
                $this->goUp();
                $this->goLeft();
                break;
            // Идем вниз и вправо
            case ($xRand == 1 && $yRand == -1):
                $this->goDown();
                $this->goRight();
                break;
            // Стоим
            default:
                echo "Stay\n";
                break;
        }
    }

    // Кушаем мышку
    private function eat(Animal $prey){
        $locationPrey = $prey->getLocation();
        $location = $this->getLocation();
        if($locationPrey["x"] == $location["x"] && $locationPrey["y"] == $location["y"]) {
            $field = $this->getField();
            $field->deleteAnimalFromField($prey);
            $this->sleep = true;
            $this->countTurns = 8;
            return true;
        }else{
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