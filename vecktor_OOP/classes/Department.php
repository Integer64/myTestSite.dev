<?php

abstract class Department{
    protected $title;
    protected $employees = [];
    protected $wageCosts;
    protected $coffeeConsumption;
    protected $paperConsumption;
    protected $averageDischarge;

    public function addEmployee($employee)
    {
        $this->employees[] = $employee;
    }

    public function deleteEmployee($id){
        $arr = $this->getEmployees();
        if(array_key_exists($id, $arr)){
            unset($this->$arr[$id]);
            $this->setEmployees($arr);
        }
    }

    public function getCountEmployees()
    {
        return count($this->getEmployees());
    }

    public function getWageCosts()
    {
        $this->calculateWageCosts();
        return $this->wageCosts;
    }

    private function calculateWageCosts(){
        $employees = $this->getEmployees();
        $wageCosts = 0;
        foreach($employees as $employee)
        {
            $wageCosts += $employee->getPayment();
        }
        $this->wageCosts = $wageCosts;
    }

    public function getCoffeeConsumption()
    {
        $this->calculateCoffeeConsumption();
        return $this->coffeeConsumption;
    }

    private function calculateCoffeeConsumption(){
        $employees = $this->getEmployees();
        $coffeeConsumption = 0;
        foreach($employees as $employee)
        {
            $coffeeConsumption += $employee->getCoffee();
        }
        $this->coffeeConsumption = $coffeeConsumption;
    }

    public function getPaperConsumption()
    {
        $this->calculatePaperConsumption();
        return $this->paperConsumption;
    }

    private function calculatePaperConsumption(){
        $employees = $this->getEmployees();
        $paperConsumption = 0;
        foreach($employees as $employee)
        {
            $paperConsumption += $employee->getPaper();
        }
        $this->paperConsumption = $paperConsumption;
    }

    public function getAverageDischarge()
    {
        $this->calculateAverageDischarge();
        return $this->averageDischarge;
    }

    private function calculateAverageDischarge(){
        $average = $this->getWageCosts() / $this->getPaperConsumption();
        $this->averageDischarge = round($average, 2);
    }


    public function getEmployees()
    {
        return $this->employees;
    }

    public function setEmployees($employees)
    {
        $this->employees = $employees;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }



}