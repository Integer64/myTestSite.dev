<?php
error_reporting(-1);
mb_internal_encoding("UTF-8");

require_once __DIR__.'/autoload.php';

$vector = new Vecktor();
$vector->printStatistic();