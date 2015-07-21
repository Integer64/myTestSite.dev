<?php
namespace Application\CatMouse\models;

use Application\CatMouse\classes\Animal;

class Cat extends Animal
{
    private $naturalEnemies = '\Application\CatMouse\models\Dog';
    private $huntAnimals = '\Application\CatMouse\models\Mouse';

    public function walk()
    {
        $location = $this->getLocation();
        $seeAnimals = $this->getSeeAnimals();
        $huntAnimals = $this->huntAnimals;

        foreach ($seeAnimals as $animal) {
            if ($animal instanceof $huntAnimals) {
                $locationPrey = $animal->getLocation();
                switch (true) {
                    // Мышка вверху и слева
                    case ($locationPrey["x"] < $location["x"] && $locationPrey["y"] < $location["y"]):
                        $this->goUp();
                        $this->goLeft();
                        echo "Mouse is up and left\n";
                        return;
                        break;
                    // Мышка вверху и справа
                    case ($locationPrey["x"] > $location["x"] && $locationPrey["y"] < $location["y"]):
                        $this->goUp();
                        $this->goRight();
                        echo "Mouse is up and right\n";
                        return;
                        break;
                    // Мышка внизу и слева
                    case ($locationPrey["x"] < $location["x"] && $locationPrey["y"] > $location["y"]):
                        $this->goDown();
                        $this->goLeft();
                        echo "Mouse is down and left\n";
                        return;
                        break;
                    // Мышка внизу и слева
                    case ($locationPrey["x"] > $location["x"] && $locationPrey["y"] > $location["y"]):
                        $this->goDown();
                        $this->goRight();
                        echo "Mouse is down and right\n";
                        return;
                        break;
                    // Мышка внизу
                    case ($locationPrey["x"] == $location["x"] && $locationPrey["y"] > $location["y"]):
                        $this->goDown();
                        echo "Mouse is down\n";
                        return;
                        break;
                    // Мышка вверху
                    case ($locationPrey["x"] == $location["x"] && $locationPrey["y"] < $location["y"]):
                        $this->goUp();
                        echo "Mouse is up\n";
                        return;
                        break;
                    // Мышка справа
                    case ($locationPrey["x"] > $location["x"] && $locationPrey["y"] == $location["y"]):
                        $this->goRight();
                        echo "Mouse is right\n";
                        return;
                        break;
                    // Мышка слева
                    case ($locationPrey["x"] < $location["x"] && $locationPrey["y"] == $location["y"]):
                        $this->goLeft();
                        echo "Mouse is left\n";
                        return;
                        break;
                    // Мышку не видно
                    default:
                        echo "Can't see where is Mouse\n";
                        break;
                }
            }
        }

        $this->randomWalk();
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

    public function getLabel()
    {
        return "C";
    }
}