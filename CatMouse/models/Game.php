<?php
namespace Application\CatMouse\models;


class Game {
    private $numberOfTurns;
    private $field;

    public function __construct($numberOfTurns, Field $field){
        $this->numberOfTurns = $numberOfTurns;
        $this->field = $field;
    }

    public function start(){
        $this->printField();
        for($i = 0; $i < $this->numberOfTurns; $i++){
            echo "Turn № $i\n";
            $this->turn();
            $this->printField();
        }
    }

    private function turn(){
        $listOfAnimals = $this->field->getListOfAnimals();
        foreach($listOfAnimals as $animal){
            $animal->lookAround($listOfAnimals);
//            echo "Before \n";
//            foreach($animal->getLocation() as $coord => $val){
//                echo "$coord : $val \n";
//            }
//            echo "\n";
            $animal->walk();
//            echo "After \n";
//            foreach($animal->getLocation() as $coord => $val){
//                echo "$coord : $val \n";
//            }
//            echo "\n\n";
        }
    }

    private function printField(){
        $field = $this->field;
        for($i = 0; $i < $field->getSize(); $i++){
            for($j = 0; $j < $field->getSize(); $j++){
                foreach($field->getListOfAnimals() as $animal){
                    $coordinates = $animal->getLocation();
                    if($i == $coordinates[0] && $j == $coordinates[1]){
                        echo $animal->getLabel();
                        continue 2;
                    }
                }
                echo ".";
            }
            echo "\n";
        }
        echo "\n";
    }
} 