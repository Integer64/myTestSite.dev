<?php

class VecktorVersion2 extends Vecktor{

    public function __construct()
    {
        // Вызов родительского конструктора
        parent::__construct();

        // Проход по всем департаментам
        foreach($this->allDepartments as $department){

            // Получаем список работников в департаменте
            $employees = $department->getEmployees();

            // Запускаем процесс увелечения ЗП и кофе
            $this->upgradeAnalysts($employees);
        }
    }

    // Метод повышение ЗП и кофе работникам
    private function upgradeAnalysts(SplObjectStorage $employees)
    {
        // Шаблон самого умного Аналитика в департаменте
        $greatestAnalyst = new Analyst(1, false);

        // Проходимся по стороджу с работниками
        foreach ($employees as $employee)
        {
        // Если работник руководитель и не является аналитиоком
            if ($employee->getBoss() && !$employee instanceof Analyst)
            {
                // Понижаем до простого работника
                $employee->setBoss(false);
            }
            // Если работник класса Аналитик
            if ($employee instanceof Analyst)
            {
                // Подымаем зп
                $employee->setPayment(1100);

                // Увеличиваем потребление кофе
                $employee->setCoffee(75);

                // Если этот аналитик круче нашего шаблона
                if ($employee->getRank() > $greatestAnalyst->getRank())
                {
                    // Понижаем старого крутого аналитика
                    $greatestAnalyst->setBoss(false);

                    // Назначаем нового крутым аналитиком
                    $greatestAnalyst = $employee;

                    // Ставим его начальником
                    $greatestAnalyst->setBoss(true);
                }
            }
        }
    }

} 