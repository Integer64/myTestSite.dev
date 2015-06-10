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

            // Запускаем процесс увелечения ЗП и кофе
            $this->upgradeManager($employees, $department);
        }
    }

    // Метод для выяввления инженеров в департаменте
    // 1 параметр - стородж с работниками
    private function upgradeManager(SplObjectStorage $employees, Department $department){

        //Массив менеджеров
        $managers = [];

        // Проходимся по стороджу с работниками
        foreach($employees as $employee){
            // Если работник класса Менеджер
            if(is_a($employee, 'Manager')){
                // Заносим его в массив
                $managers[] = $employee;
            }
        }

        // Высчитываем сколько людей нужно уволить
        $countToUpgrade = ceil(count($managers) * 0.5);

        // Вызываем метод увольния работников
        $this->upgrade($countToUpgrade, $managers, $department);
    }

    // Метод апгрейда работников
    // Спорная реализация.
    // Думаю, есть ли возможность сделать все через рекурсию?
    private function upgrade($countToUpgrade, $engineers, Department $department)
    {
        // Пока нужно количество работников не уволено
        while($countToUpgrade > 0)
        {
            // Проходимся по массиву с работниками под увольнение
            foreach($engineers as $key => $engineer)
            {
                // Если ешё не уволено
                // нужное количество работников
                if($countToUpgrade > 0)
                {
                    // Записываем ранг
                    $rank = $engineer->getRank();

                    // Проверям что ранг работника
                    // соотвествует ли он наименьшему рангу для апгрейда
                    if($rank == 1 ||  $rank == 2)
                    {
                       $engineer->setRank(++$rank);
                        // Уменьшаем кол-ва подлежащих апгрейду на 1
                        $countToUpgrade--;
                    }
                }
            }
        }
    }

} 