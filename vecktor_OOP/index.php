<?php
error_reporting(-1);
mb_internal_encoding("UTF-8");

// Подключине функции автоматического подключения классов и моделей
require_once __DIR__.'/autoload.php';

// Создаем новый объект Вектор
$vector = new Vecktor();

// Вызываем у объекта метод вывода статиски на экран
$vector->printStatistic();