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
        $this->setRank($rank);
        $this->setBoss($boss);
    }

    // Методы для доступа к свойствам класса
    public function getBoss()
    {
        return $this->boss;
    }

    // Устанавливаем своство босс
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

    // Устанавливаем количество бумаги
    public function setPaper($paper)
    {
        $this->paper = $paper;
    }

    public function getPayment()
    {
        $isBoss = $this->getBoss();
        $rank = $this->getRank();
        $payment = $this->payment;

        // Перерасчет ЗП взависимости от ранга и является ли сотрудник руководителем
        switch($rank) {
            case 1:
            {
                if($isBoss){
                    return $payment * 1.5;
                }else{
                    return $payment;
                }
                break;
            }
            case 2:
            {
                if($isBoss){
                    return  $payment * 1.875;
                }else{
                    return  $payment * 1.25;
                }
                break;
            }
            case 3:
            {
                if($isBoss){
                    return  $payment * 2.25;
                }else{
                    return $payment * 1.5;
                }
                break;
            }
            default:
                throw new RankException("invalid rank: $rank");
                break;
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
        if($rank < 1 || $rank > 3){
            throw new RankException("invalid rank: $rank");
        }
        $this->rank = $rank;
    }



} 