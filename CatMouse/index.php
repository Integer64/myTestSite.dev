<?php
use \Application\CatMouse\models\Mouse;
error_reporting(-1);
mb_internal_encoding("UTF-8");

// Подключине функции автоматического подключения классов и моделей
require_once __DIR__.'/autoload.php';

$mouse = new Mouse(9, 1);
