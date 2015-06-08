<?php

// Функция для автоматического подключения классов и моделей
function loadClass($class){
    if(file_exists(__DIR__ . '/models/' . $class . '.php')){
        require __DIR__ . '/models/' . $class . '.php';
    }else if(file_exists(__DIR__ . '/classes/' . $class . '.php')){
        require __DIR__ . '/classes/' . $class . '.php';
    }
}

spl_autoload_extensions('.php');
spl_autoload_register('loadClass');