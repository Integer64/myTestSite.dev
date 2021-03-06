<?php

//Абстрактный класс Департамент
abstract class Department{

    // Свойства класса
    protected $title;
    protected $employees;

    public function __construct(){
        $this->employees = new SplObjectStorage();
    }

    // Метод для добавления сотрудника
    public function addEmployee(Employee $employee)
    {
        $this->employees->attach($employee);
    }

    // Метод для удаления сотрудника
    public function deleteEmployee(Employee $employee){
        if($this->getEmployees()->contains($employee)){
            $this->getEmployees()->detach($employee);
        }
    }

    // Метод для подсчета общиего кол-ва сотрудников
    public function getCountEmployees()
    {
        return $this->employees->count();
    }

    // Метод для получения общей зарплаты
    public function getWageCosts()
    {
        $employees = $this->getEmployees();
        $wageCosts = 0;
        foreach($employees as $employee)
        {
            try {
                $wageCosts += $employee->getPayment();
            }catch (RankException $e){
                die("Ошибка: {$e->getMessage()}\n");
            }
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

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }



}