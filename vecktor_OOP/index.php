<?php
error_reporting(-1);
mb_internal_encoding("UTF-8");

// Подключине функции автоматического подключения классов и моделей
require_once __DIR__.'/autoload.php';

// Создаем новый объект Вектор
$vector = new Vecktor();

// Вызываем у объекта метод вывода статиски на экран
$vector->printStatistic();

echo "\n";

$vector1 = new VecktorVersion1();
$vector1->printStatistic();

echo "\n";

$vector2 = new VecktorVersion2();
$vector2->printStatistic();

echo "\n";

$vector3 = new VecktorVersion3();
$vector3->printStatistic();