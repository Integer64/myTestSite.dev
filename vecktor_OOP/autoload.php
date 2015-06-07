<?php

// Функция для автоматического подключения классов и моделей
function __autoload($class){
    if(file_exists(__DIR__ . '/models/' . $class . '.php')){
        require __DIR__ . '/models/' . $class . '.php';
    }else if(file_exists(__DIR__ . '/classes/' . $class . '.php')){
        require __DIR__ . '/classes/' . $class . '.php';
    }
}