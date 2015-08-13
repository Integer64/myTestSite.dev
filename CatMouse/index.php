<?php
/**
 * TODO: Создать класс генерации животных, поля, игры. Или дописать в класс Game.
 */
use \Application\CatMouse\models\Mouse;
use \Application\CatMouse\models\Cat;
use \Application\CatMouse\models\Field;
use \Application\CatMouse\models\Game;

error_reporting(-1);
mb_internal_encoding("UTF-8");

// Подключине функции автоматического подключения классов и моделей
require_once __DIR__ . '/autoload.php';

$fieldSize = 5;

$field = new Field($fieldSize);
$mouse1 = new Mouse(9, 1, "Mouse1", $field);
$mouse2 = new Mouse(9, 1, "Mouse2", $field);
$mouse3 = new Mouse(9, 1, "Mouse3", $field);

$cat1 = new Cat($fieldSize, 1, "Cat1", $field);

$field->addAnimalToField($mouse1);
$field->addAnimalToField($mouse2);
$field->addAnimalToField($mouse3);

$field->addAnimalToField($cat1);

$x = mt_rand(1, $fieldSize);
$y = mt_rand(1, $fieldSize);

$mouse1->setLocation(["x" => $x, "y" => $y]);

$x = mt_rand(1, $fieldSize);
$y = mt_rand(1, $fieldSize);

$mouse2->setLocation(["x" => $x, "y" => $y]);

$x = mt_rand(1, $fieldSize);
$y = mt_rand(1, $fieldSize);

$mouse3->setLocation(["x" => $x, "y" => $y]);


$x = mt_rand(1, $fieldSize);
$y = mt_rand(1, $fieldSize);

$cat1->setLocation(["x" => $x, "y" => $y]);

$turns = 20;
$game = new Game(20, $field);
$game->start();



