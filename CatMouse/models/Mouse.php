<?php
namespace Application\CatMouse\models;

use Application\CatMouse\classes\Animal;


class Mouse extends Animal
{

    public function walk()
    {
        $location = $this->getLocation();
        $cruisingRange = $this->getCruisingRange();

        $X = $location["x"];
        $Y = $location["y"];

        if ($this->seeAnimals->count() === 0) {

            $xRand = mt_rand(-self::RANDFORWALK, self::RANDFORWALK);
            $yRand = mt_rand(-self::RANDFORWALK, self::RANDFORWALK);

//            echo "Random x = $xRand, y = $yRand\n";

            if ($xRand > 0) {
                $X = $location["x"] + $cruisingRange;
            } elseif ($xRand < 0) {
                $X = $location["x"] - $cruisingRange < 0 ? 0 : $location["x"] - $cruisingRange;
            }

            if ($yRand > 0) {
                $Y = $location["y"] + $cruisingRange;
            } elseif ($yRand < 0) {
                $Y = $location["y"] - $cruisingRange < 0 ? 0 : $location["y"] - $cruisingRange;
            }
        }

        $this->setLocation(["x" => $X, "y" => $Y]);
    }


    public function getLabel()
    {
        return "M";
    }

} 