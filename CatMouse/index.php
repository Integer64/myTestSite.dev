<?php
use \Application\CatMouse\models\Mouse;
use \Application\CatMouse\models\Field;
use \Application\CatMouse\models\Game;

error_reporting(-1);
mb_internal_encoding("UTF-8");

// Подключине функции автоматического подключения классов и моделей
require_once __DIR__.'/autoload.php';

$field = new Field(25);
$mouse1 = new Mouse(9, 1);
$mouse2 = new Mouse(9, 1);
$mouse3 = new Mouse(9, 1);

$field->addAnimalToField($mouse1);
$field->addAnimalToField($mouse2);
$field->addAnimalToField($mouse3);

$x = mt_rand(0, 25);
$y = mt_rand(0, 25);

$mouse1->setLocation(["x" => $x,"y" => $y]);

$x = mt_rand(0, 25);
$y = mt_rand(0, 25);

$mouse2->setLocation(["x" => $x,"y" => $y]);

$x = mt_rand(0, 25);
$y = mt_rand(0, 25);

$mouse3->setLocation(["x" => $x,"y" => $y]);

$game = new Game(5, $field);
$game->start();



