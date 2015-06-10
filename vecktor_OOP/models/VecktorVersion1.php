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

    // Метод для выяввления инженеров в департаменте
    // 1 параметр - стородж с работниками
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

        // Высчитываем сколько людей нужно уволить
        $countToFire = ceil(count($engineers) * 0.4);

        // Вызываем метод увольния работников
        $this->fire($countToFire, $engineers, $department);
    }

    // Метод увольнения работников
    // Спорная реализация.
    // Думаю, есть ли возможность сделать все через рекурсию?
    private function fire($countToFire, $engineers, Department $department)
    {
        // Проверяемый ранг с наименьшего
        $CheckRank = 1;

        // Пока нужно количество работников не уволено
        while($countToFire > 0)
        {
            // Проходимся по массиву с работниками под увольнение
            foreach($engineers as $key => $engineer)
            {
                // Если работник не руководитель и ешё не уволено
                // нужное количество работников
                if($engineer->getBoss() === false && $countToFire > 0)
                {
                    // Проверям что ранг работника
                    // соотвествует ли он наименьшему рангу для увольнения
                    if($engineer->getRank() == $CheckRank)
                    {
                        // Удаляем из массива работников
                        unset($engineers[$key]);

                        // Увольняем работника
                        // Удаляем из стороджа
                        $department->deleteEmployee($engineer);

                        // Уменьшаем кол-ва подлежащих увольнению на 1
                        $countToFire--;
                    }
                }
            }

            // После увольнение всех 1 ранг
            // Нужно проверить следующие ранги
            // Увеличиваем проверяемый ранг на 1.
            $CheckRank++;
        }
    }

} 