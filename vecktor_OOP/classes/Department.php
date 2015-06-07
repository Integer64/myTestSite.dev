<?php

//Абстрактный класс Департамент
abstract class Department{

    // Свойства класса
    protected $title;
    protected $employees = [];
    protected $wageCosts;
    protected $coffeeConsumption;
    protected $paperConsumption;
    protected $averageDischarge;

    // Метод для добавления сотрудника
    public function addEmployee($employee)
    {
        $this->employees[] = $employee;
    }

    // Метод для удаления сотрудника
    public function deleteEmployee($id){
        $arr = $this->getEmployees();
        if(array_key_exists($id, $arr)){
            unset($this->$arr[$id]);
            $this->setEmployees($arr);
        }
    }

    // Метод для подсчета общиего кол-ва сотрудников
    public function getCountEmployees()
    {
        return count($this->getEmployees());
    }

    // Метод для получения общей зарплаты
    public function getWageCosts()
    {
        $this->calculateWageCosts();
        return $this->wageCosts;
    }

    // Метод для подсчета общеё зарплаты
    private function calculateWageCosts(){
        $employees = $this->getEmployees();
        $wageCosts = 0;
        foreach($employees as $employee)
        {
            $wageCosts += $employee->getPayment();
        }
        $this->wageCosts = $wageCosts;
    }

    // Метод для получение общиего кол-ва литров кофе
    public function getCoffeeConsumption()
    {
        $this->calculateCoffeeConsumption();
        return $this->coffeeConsumption;
    }

    // Метод для подсчета общиего кол-ва литров кофе
    private function calculateCoffeeConsumption(){
        $employees = $this->getEmployees();
        $coffeeConsumption = 0;
        foreach($employees as $employee)
        {
            $coffeeConsumption += $employee->getCoffee();
        }
        $this->coffeeConsumption = $coffeeConsumption;
    }

    // Метод для получение общиего кол-ва бумаг
    public function getPaperConsumption()
    {
        $this->calculatePaperConsumption();
        return $this->paperConsumption;
    }

    // Метод для подсчета общиего кол-ва бумаг
    private function calculatePaperConsumption(){
        $employees = $this->getEmployees();
        $paperConsumption = 0;
        foreach($employees as $employee)
        {
            $paperConsumption += $employee->getPaper();
        }
        $this->paperConsumption = $paperConsumption;
    }

    // Метод для получение среднего расхода зарплаты на кол-во страниц
    public function getAverageDischarge()
    {
        $this->calculateAverageDischarge();
        return $this->averageDischarge;
    }

    // Метод для подсчета среднего расхода зарплаты на кол-во страниц
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