<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 10.06.15
 * Time: 13:03
 */

class VecktorVersion3 extends Vecktor{

    public function __construct()
    {
        // Вызов родительского конструктора
        parent::__construct();

        // Проход по всем департаментам
        foreach($this->allDepartments as $department){

            // Получаем список работников в департаменте
            $employees = $department->getEmployees();

            // Запускаем процесс апгрейда
            $this->upgradeManager($employees);
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
            $manager->setRank($rank + 1);
        }
    }

} 