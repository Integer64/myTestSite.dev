<?php

//Абстрактный класс Employee - сотрудник
abstract class Employee {
    // Скрытые свойства класса
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
    }

    public function getCoffee()
    {
        if($this->getBoss()){
            return $this->coffee * 2;
        }
        return $this->coffee;
    }

    // Устанавливаем количество кофе литров
    // Делаем перерасчет
    public function setCoffee($coffee)
    {
        $this->coffee = $coffee;
    }

    public function getPaper()
    {
        if($this->getBoss()){
            return 0;
        }
        return $this->paper;
    }

    public function setPaper($paper)
    {
        $this->paper = $paper;
    }

    public function getPayment()
    {
        $isBoss = $this->getBoss();
        $rank = $this->getRank();
        $payment = $this->payment;

        // Если сотрудник руководитель
        // Пересчитываем с дополнительным коэффициентом
        if($isBoss)
        {
            switch($rank)
            {
                case 1:
                {
                    return $payment * 1.5;
                    break;
                }
                case 2:
                {
                    return  $payment * 1.875;
                    break;
                }
                case 3:
                {
                    return  $payment * 2.25;
                    break;
                }
                default:
                    break;
            }
        }
        // Если же нет то
        // Перерасчитываем без дополнительного коэффициента
        else
        {
            switch($rank) {
                case 1: {
                    return $payment;
                    break;
                }
                case 2: {
                    return  $payment * 1.25;
                    break;
                }
                case 3:
                {
                    return  $payment * 1.5;
                    break;
                }
                default:
                    break;
            }
        }
    }

    // Устанавливаем зарплату
    // Делаем перерасчет
    public function setPayment($payment)
    {
        $this->$payment = $payment;
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
    }



} 