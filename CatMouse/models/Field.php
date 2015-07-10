<?php
namespace Application\CatMouse\models;

use Application\CatMouse\classes\Animal;
use \SplObjectStorage;

class Field {
    private $size;
    private $listOfAnimals;

    public function __construct($size){
        $this->size = $size;
        $this->listOfAnimals = new SplObjectStorage();
    }

    public function addAnimalToField(Animal $animal){
        $this->listOfAnimals->attach($animal);
    }

    public function deleteAnimalFromField(Animal $animal){
        if($this->getListOfAnimals()->contains($animal)){
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
}