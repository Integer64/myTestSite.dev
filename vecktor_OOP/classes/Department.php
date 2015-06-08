<?php

//Абстрактный класс Департамент
abstract class Department{

    // Свойства класса
    protected $title;
    protected $employees = [];

    // Метод для добавления сотрудника
    public function addEmployee($employee)
    {
        $this->employees[] = $employee;
    }

    // Метод для удаления сотрудника
    public function deleteEmployee(Employee $employee){
        $employees = $this->getEmployees();
        if(array_key_exists($employee, $this->getEmployees())){
            $key_employee = array_search($employee,$employees, true);
            unset($employees[$key_employee]);
            $this->employees = $employees;
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
        $employees = $this->getEmployees();
        $wageCosts = 0;
        foreach($employees as $employee)
        {
            $wageCosts += $employee->getPayment();
        }
        return $wageCosts;
    }

    // Метод для получение общиего кол-ва литров кофе
    public function getCoffeeConsumption()
    {
        $employees = $this->getEmployees();
        $coffeeConsumption = 0;
        foreach($employees as $employee)
        {
            $coffeeConsumption += $employee->getCoffee();
        }
        return $coffeeConsumption;
    }

    // Метод для получение общиего кол-ва бумаг
    public function getPaperConsumption()
    {
        $employees = $this->getEmployees();
        $paperConsumption = 0;
        foreach($employees as $employee)
        {
            $paperConsumption += $employee->getPaper();
        }
        return $paperConsumption;
    }


    // Метод для получение среднего расхода зарплаты на кол-во страниц
    public function getAverageDischarge()
    {
        $average = $this->getWageCosts() / $this->getPaperConsumption();
        return round($average, 2);
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