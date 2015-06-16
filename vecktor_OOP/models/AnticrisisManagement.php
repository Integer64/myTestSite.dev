<?php

class AnticrisisManagement {

    // План 1
    // Сокращение.
    public function applyPlan1(Vecktor $vector){
        // Проход по всем департаментам
        foreach($vector->getAllDepartments() as $department){

            // Получаем список работников в департаменте
            $employees = $department->getEmployees();

            // Запускаем процесс увольнения Инженеров
            $this->fireEngineers($employees, $department);
        }

        echo "План 1.Сокращение.\n";
        $vector->printStatistic();
        echo "\n";
    }

    // План 2
    // Повысить ЗП.
    public function applyPlan2(Vecktor $vector){
        // Проход по всем департаментам
        foreach($vector->getAllDepartments() as $department){

            // Получаем список работников в департаменте
            $employees = $department->getEmployees();

            // Запускаем процесс увелечения ЗП и кофе
            $this->upgradeAnalysts($employees);
        }
        echo "План 2.Повысить ЗП.\n";
        $vector->printStatistic();
        echo "\n";
    }

    // План 3
    // Повысить сотрудников.
    public function applyPlan3(Vecktor $vector){

        // Проход по всем департаментам
        foreach($vector->getAllDepartments() as $department){

            // Получаем список работников в департаменте
            $employees = $department->getEmployees();

            // Запускаем процесс апгрейда
            $this->upgradeManager($employees);
        }
        echo "План 3.Повысить сотрудников.\n";
        $vector->printStatistic();
        echo "\n";
    }


    // Метод сортировки массива для usort
    private function compareEngineers(Employee $objectOne, Employee $objectTwo)
    {
        if($objectOne->getBoss() && !$objectTwo->getBoss()){
            return 1;
        }
        if(!$objectOne->getBoss() && $objectTwo->getBoss()){
            return -1;
        }

        if ($objectOne->getRank() == $objectTwo->getRank()) {
            return 0;
        }
        return ($objectOne->getRank() < $objectTwo->getRank()) ? -1 : 1;
    }

    // Метод для выяввления инженеров в департаменте
    // 1 параметр - стородж с работниками
    // 2 параметр - департамент
    public function fireEngineers(SplObjectStorage $employees, Department $department){

        //Массив инженеров
        $engineers = [];

        // Проходимся по стороджу с работниками
        foreach($employees as $employee){

            // Если работник класса Инженер
            if($employee instanceof Engineer){
                // Заносим его в массив
                $engineers[] = $employee;
            }
        }

        // Сортирумем массив
        usort($engineers, array($this, 'compareEngineers'));

        // Высчитываем сколько людей нужно уволить
        $countToFire = ceil(count($engineers) * 0.4);

        // Массив под увольнение
        $fireEngineers = array_slice($engineers, 0, $countToFire);

        // Вызываем метод увольния работников
        $this->fire($fireEngineers, $department);
    }

    // Метод увольнения работников
    private function fire($fireEngineers, Department $department)
    {
        foreach($fireEngineers as $engineer){
            $department->deleteEmployee($engineer);
        }
    }

    // Метод сортировки массива для usort
    private function compareEmployee(Employee $objectOne, Employee $objectTwo)
    {
        if ($objectOne->getRank() == $objectTwo->getRank()) {
            return 0;
        }
        return ($objectOne->getRank() < $objectTwo->getRank()) ? -1 : 1;
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

    // Метод для выяввления инженеров в департаменте
    // 1 параметр - стородж с работниками
    // 2 параметр - департамент
    private function upgradeManager(SplObjectStorage $employees){

        //Массив менеджеров
        $managers = [];

        // Проходимся по стороджу с работниками
        foreach($employees as $employee){
            // Если работник класса Менеджер
            if($employee instanceof Manager){
                // Заносим его в массив
                $managers[] = $employee;
            }
        }

        // Высчитываем сколько людей нужно проапгрейдить
        $countToUpgrade = ceil(count($managers) * 0.5);

        // Сортирумем массив
        usort($managers, array($this, 'compareEmployee'));

        // Массив для повышения
        $upgradeManagers = array_slice($managers, 0, $countToUpgrade);

        // Вызываем метод апгрейда работников
        $this->upgrade($upgradeManagers);
    }

    // Метод апгрейда работников
    private function upgrade($upgradeManagers)
    {
        foreach($upgradeManagers as $manager){
            $rank = $manager->getRank();
            try{
            $manager->setRank($rank + 1);
            } catch (RankException $e){
                die("Ошибка: {$e->getMessage()}\n");
            }
        }
    }


} 