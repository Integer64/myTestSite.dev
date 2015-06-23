<?php
namespace Application\CatMouse\models;

use Application\CatMouse\classes\Animal;

class Mouse extends Animal{

    public function walk(){
        $location = $this->getLocation();

    }

    private function seeCats(){

    }
} 