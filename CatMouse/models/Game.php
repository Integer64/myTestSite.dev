<?php
namespace Application\CatMouse\models;

class Game
{
    private $numberOfTurns;
    private $field;

    public function __construct($numberOfTurns, Field $field)
    {
        $this->numberOfTurns = $numberOfTurns;
        $this->field = $field;
    }

    public function start()
    {
        echo "This is game field\n";
        $this->printField();
        for ($i = 1; $i <= $this->numberOfTurns; $i++) {
            echo "Turn № $i\n";
            $this->turn();
            $this->printField();
        }
    }

    private function turn()
    {
        $listOfAnimals = $this->field->getListOfAnimals();

        $listToAnimal = new \SplObjectStorage();    // Костыли.
        foreach ($listOfAnimals as $animal) {        // SplObjectStorage не может в рекурсию вроде как.
            $listToAnimal->attach($animal);         // Как это побороть не знаю.
        }                                           // Есть идеи?

        foreach ($listOfAnimals as $animal) {
            echo "This is: " . $animal->name . "\n";
            $animal->lookAround($listToAnimal);
            $animal->walk();
//            echo "Before \n";
//            foreach($animal->getLocation() as $coord => $val){
//                echo "$coord : $val \n";
//            }
//            echo "\n";
//            echo "After \n";
//            foreach($animal->getLocation() as $coord => $val){
//                echo "$coord : $val \n";
//            }
        }

    }

    private function printField()
    {
        $field = $this->field;
        echo "0  ";
        for ($i = 1; $i <= $field->getSize(); $i++) {
            echo($i < 10 ? $i . "  " : $i . " ");
        }
        echo "\n";
        for ($i = 1; $i <= $field->getSize(); $i++) {

            echo($i < 10 ? $i . "  " : $i . " ");

            for ($j = 1; $j <= $field->getSize(); $j++) {
                foreach ($field->getListOfAnimals() as $animal) {
                    $coordinates = $animal->getLocation();
                    if ($j == $coordinates["x"] && $i == $coordinates["y"]) {
                        echo $animal->getLabel() . "  ";
                        continue 2;
                    }
                }
                echo ".  ";
            }
            echo "\n";
        }
        echo "\n";
    }
} 