<?php

// Класс Вектор
class Vecktor {
    // Департаменты
    public $departmentOfPurchases;
    public $salesDepartment;
    public $departmentOfAdvertising;
    public $departmentOfLogistics;

    // Массив для департаментов
    // нужен для более простого заполнения
    protected  $allDepartments = [];

    // Конструктор.
    // Заполняем все департаменты работниками
    public function __construct()
    {
        // Создаем департаменты
        $this->departmentOfPurchases = new DepartmentOfPurchases();
        $this->salesDepartment = new SalesDepartment();
        $this->departmentOfAdvertising = new DepartmentOfAdvertising();
        $this->departmentOfLogistics = new DepartmentOfLogistics();

        // Массив сотрудников.
        // Для департамента закупок
        $employeesDepartmentOfPurchases = [
            array(9 => ['Manager', 1, false]),
            array(3 => ['Manager', 2, false]),
            array(2 => ['Manager', 3, false]),
            array(2 => ['Marketer', 1, false]),
            array(1 => ['Manager', 2, true])
        ];

        // Вызываем метод для заполнения департамента
        // 1 параметр - департамент
        // 2 параметр - массив с сотрудниками
        $this->fillTheDepartment($this->departmentOfPurchases, $employeesDepartmentOfPurchases);

        // Массив сотрудников.
        // Для департамента продаж
        $employeesSalesDepartment = [
            array(12 => ['Manager', 1, false]),
            array(6 =>  ['Marketer', 1, false]),
            array(3 =>  ['Analyst', 1, false]),
            array(2 =>  ['Analyst', 2, false]),
            array(1 =>  ['Marketer', 2, true])
        ];

        // Вызываем метод для заполнения департамента
        // 1 параметр - департамент
        // 2 параметр - массив с сотрудниками
        $this->fillTheDepartment($this->salesDepartment, $employeesSalesDepartment);

        // Массив сотрудников.
        // Для департамента рекламы
        $employeesDepartmentOfAdvertising = [
            array(15 => ['Marketer', 1, false]),
            array(10 => ['Marketer', 2, false]),
            array(8 =>  ['Manager', 1, false]),
            array(2 => ['Engineer', 1, false]),
            array(1 => ['Marketer', 3, true]),
        ];

        // Вызываем метод для заполнения департамента
        // 1 параметр - департамент
        // 2 параметр - массив с сотрудниками
        $this->fillTheDepartment($this->departmentOfAdvertising, $employeesDepartmentOfAdvertising);

        // Массив сотрудников.
        // Для департамента логистики
        $employeesDepartmentOfLogistics = [
            array(13 => ['Manager', 1, false]),
            array(5 =>  ['Manager', 2, false]),
            array(5 =>  ['Engineer', 1, false]),
            array(1 =>  ['Manager', 1, true]),
        ];

        // Вызываем метод для заполнения департамента
        // 1 параметр - департамент
        // 2 параметр - массив с сотрудниками
        $this->fillTheDepartment($this->departmentOfLogistics, $employeesDepartmentOfLogistics);

        // Заносим все департаменты в массив
        $this->allDepartments[] = $this->departmentOfPurchases;
        $this->allDepartments[] = $this->salesDepartment;
        $this->allDepartments[] = $this->departmentOfAdvertising;
        $this->allDepartments[] = $this->departmentOfLogistics;
    }

    // Метод для заполнения департаментов.
    // 1 параметр - департамент
    // 2 параметр - массив с сотрудниками
    private function fillTheDepartment(Department $department,$addToDepartment)
    {
        foreach($addToDepartment as $item)
        {
            foreach($item as $count => $employee)
            {
                for($i = 0; $i < $count; $i++)
                {
                    $em = new $employee[0]($employee[1],$employee[2]);
                   $department->addEmployee($em);
               }
            }
        }
    }

    // Метод вывода таблицы с статистикой
    public function printStatistic(){
        // Ширина колонок
        $col1 = 15;
        $col2 = 10;
        $col3 = 10;
        $col4 = 10;
        $col5 = 10;
        $col6 = 10;

        // Заголовок таблицы
        echo $this->padRight("Департамент", $col1) .
            $this->padLeft("сотр.", $col2) .
            $this->padLeft("тугр.", $col3) .
            $this->padLeft("кофе", $col4) .
            $this->padLeft("стр.", $col5) .
            $this->padLeft("тугр./стр.", $col6) . "\n";
        echo "----------------------------------------------------------------------------" . "\n";

        // Переменные для подсчета строки "Всего"
        $totalEmployees = 0;
        $totalWageCosts = 0;
        $totalCoffeeConsumption = 0;
        $totalPaperConsumption = 0;
        $totalAverageDischarge = 0;

        // Сама таблица
        foreach ($this->allDepartments as $department) {

            // Вывод данных в строку
            echo $this->padRight($department->getTitle(), $col1) .
                $this->padLeft($department->getCountEmployees(), $col2) .
                $this->padLeft($department->getWageCosts(),$col3).
                $this->padLeft($department->getCoffeeConsumption(), $col4) .
                $this->padLeft($department->getPaperConsumption(), $col5) .
                $this->padLeft($department->getAverageDischarge(), $col6) . "\n";

            // Суммируем данные и записываем в переменные
            $totalEmployees += $department->getCountEmployees();
            $totalWageCosts += $department->getWageCosts();
            $totalCoffeeConsumption += $department->getCoffeeConsumption();
            $totalPaperConsumption += $department->getPaperConsumption();
            $totalAverageDischarge += $department->getAverageDischarge();
        }

        // Переменные для подсчета строки "Среднее"
        $averageEmployees = round($totalEmployees / 4, 2);
        $averageWageCosts = round($totalWageCosts / 4, 2);
        $averageCoffeeConsumption = round($totalCoffeeConsumption / 4, 2);
        $averagePaperConsumption = round($totalPaperConsumption / 4, 2);
        $averageAverageDischarge = round($totalAverageDischarge / 4, 2);


        // Конец таблица
        // Вывод "Среднее"
        echo $this->padRight("Среднее", $col1) .
            $this->padLeft($averageEmployees, $col2) .
            $this->padLeft($averageWageCosts,$col3).
            $this->padLeft($averageCoffeeConsumption, $col4) .
            $this->padLeft($averagePaperConsumption, $col5) .
            $this->padLeft($averageAverageDischarge, $col6) . "\n";

        // Вывод "Всего"
        echo $this->padRight("Всего", $col1) .
            $this->padLeft($totalEmployees, $col2) .
            $this->padLeft($totalWageCosts,$col3).
            $this->padLeft($totalCoffeeConsumption, $col4) .
            $this->padLeft($totalPaperConsumption, $col5) .
            $this->padLeft($totalAverageDischarge, $col6) . "\n";
    }

    // Метод для вывода данных с смещением вправо
    private function padRight($string,$length){

        // Вычитаем длину строки из колонки
        $length=$length-mb_strlen($string);
        $space = str_repeat(" ",$length);
        return $string . $space;
    }

    // Метод для вывода данных с смещением влево
    private function padLeft($string,$length){

        // Вычитаем длину строки из колонки
        $length = $length - mb_strlen($string)+2;
        $space = str_repeat(" ",$length);
        $result = $space . $string;
        return $result;
    }

}