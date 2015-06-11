<?php

class VecktorVersion1 extends Vecktor{

    public function __construct()
    {
        // Вызов родительского конструктора
        parent::__construct();

        // Проход по всем департаментам
        foreach($this->allDepartments as $department){

            // Получаем список работников в департаменте
            $employees = $department->getEmployees();

            // Запускаем процесс увольнения Инженеров
            $this->fireEngineers($employees, $department);
        }
    }

    // Метод сортировки массива для usort
    private function compareEmployee(Employee $objectOne, Employee $objectTwo)
    {
        if($objectOne->getBoss() || $objectTwo->getBoss()){
            return 1;
        }
        if ($objectOne->getRank() == $objectTwo->getRank()) {
            return 0;
        }
        return ($objectOne->getRank() < $objectTwo->getRank()) ? -1 : 1;
    }


    // Метод для выяввления инженеров в департаменте
    // 1 параметр - стородж с работниками
    // 2 параметр - департамент
    private function fireEngineers(SplObjectStorage $employees, Department $department){

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
        usort($engineers, array($this, 'compareEmployee'));

        // Высчитываем сколько людей нужно уволить
        $countToFire = ceil(count($engineers) * 0.4);

        $fireEngineers = array_slice($engineers, 0,$countToFire);

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

} 