<?php

abstract class Employee {
    protected $payment;
    protected $coffee;
    protected $paper;
    protected $rank;
    protected $boss;

    public function __construct($rank, $boss)
    {
        $this->setRank($rank);
        $this->setBoss($boss);
    }


    private function recalculationPayment(){
        $isBoss = $this->getBoss();
        $rank = $this->getRank();
        $payment = $this->getPayment();
        $coffee = $this->getCoffee();

        if($isBoss)
        {
            switch($rank)
            {
                case 1:
                {
                    $this->payment += $payment * 0.5;
                    break;
                }
                case 2:
                {
                    $payment += $payment * 0.25;
                    $payment = $payment + ($payment * 0.5);
                    $this->setPayment($payment);
                    break;
                }
                case 3:
                {
                    $payment += $payment * 0.5;
                    $payment = $payment + ($payment * 0.5);
                    $this->setPayment($payment);
                    break;
                }
                default:
                    break;
            }

            $this->coffee = $coffee * 2;
            $this->paper = 0;
        }
        else
        {
            switch($rank) {
                case 2: {
                    $payment += $payment * 0.25;
                    $this->setPayment($payment);
                    break;
                }
                case 3:
                {
                    $payment += $payment * 0.5;
                    $this->setPayment($payment);
                    break;
                }
                default:
                    break;
            }
        }
    }

    public function getCoffee()
    {
        return $this->coffee;
    }

    public function setCoffee($coffee)
    {
        $this->coffee = $coffee;
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

    public function setPayment($payment)
    {
        $this->payment = $payment;
    }

    public function getRank()
    {
        return $this->rank;
    }

    public function setRank($rank)
    {
        $this->rank = $rank;
    }

    public function getBoss()
    {
        return $this->boss;
    }

    public function setBoss($boss)
    {
        $this->boss = $boss;
        $this->recalculationPayment();
    }

} 