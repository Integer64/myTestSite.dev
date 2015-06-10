<?php

//Абстрактный класс Employee - сотрудник
abstract class Employee {
    // Скрытые свойства класса
    protected $defaultPayment = 0;
    protected $payment;
    protected $coffee;
    protected $paper;
    protected $rank;
    protected $boss;

    // Конструктор
    // Заполняем ранг
    // И является ли сотрудник руководителем
    public function __construct($rank, $boss)
    {
        $this->rank = $rank;
        $this->boss = $boss;
        $this->recalculationPayment();
    }

    // Метод для перерасчета зарплаты
    private function recalculationPayment(){

        // Получаем все необходимые данные
        $isBoss = $this->getBoss();
        $rank = $this->getRank();
        $defaultPayment = $this->defaultPayment;

        // Если сотрудник руководитель
        // Пересчитываем с дополнительным коэффициентом
        if($isBoss)
        {
            $coffee = $this->getCoffee();
            switch($rank)
            {
                case 1:
                {
                    $this->payment += $defaultPayment * 0.5;
                    break;
                }
                case 2:
                {
                    $defaultPayment += $defaultPayment * 0.25;
                    $defaultPayment = $defaultPayment + ($defaultPayment * 0.5);
                    $this->payment = $defaultPayment;
                    break;
                }
                case 3:
                {
                    $defaultPayment += $defaultPayment * 0.5;
                    $defaultPayment = $defaultPayment + ($defaultPayment * 0.5);
                    $this->payment = $defaultPayment;
                    break;
                }
                default:
                    break;
            }

            $this->coffee = $coffee * 2;
            $this->paper = 0;
        }
        // Если же нет то
        // Перерасчитываем без дополнительного коэффициента
        else
        {
            switch($rank) {
                case 1: {
                    $this->payment = $defaultPayment;
                    break;
                }
                case 2: {
                    $defaultPayment += $defaultPayment * 0.25;
                    $this->payment = $defaultPayment;
                    break;
                }
                case 3:
                {
                    $defaultPayment += $defaultPayment * 0.5;
                    $this->payment = $defaultPayment;
                    break;
                }
                default:
                    break;
            }
        }
    }

    // Методы для доступа к свойствам класса

    public function getBoss()
    {
        return $this->boss;
    }

    // Если устанавливаем свойство $boss - руководитель
    // то необходимо произвести перерасчет зарплаты
    public function setBoss($boss)
    {
        $this->boss = $boss;
        $this->recalculationPayment();
    }

    public function getCoffee()
    {
        return $this->coffee;
    }

    // Устанавливаем количество кофе литров
    // Делаем перерасчет
    public function setCoffee($coffee)
    {
        $this->coffee = $coffee;
        $this->recalculationPayment();
    }

    public function getPaper()
    {
        return $this->paper;
    }

    public function setPaper($paper)
    {
        $this->paper = $paper;
    }

    public function getPayment()
    {
        return $this->payment;
    }

    // Устанавливаем зарплату
    // Делаем перерасчет
    public function setPayment($payment)
    {
        $this->payment = $payment;
        $this->recalculationPayment();
    }

    public function getRank()
    {
        return $this->rank;
    }

    // Устанавливаем ранг
    // Делаем перерасчет
    public function setRank($rank)
    {
        $this->rank = $rank;
        $this->recalculationPayment();
    }



} 