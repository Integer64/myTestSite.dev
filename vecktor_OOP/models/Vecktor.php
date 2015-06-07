<?php

class Vecktor {
    public $departmentOfPurchases;
    public $salesDepartment;
    public $departmentOfAdvertising;
    public $departmentOfLogistics;
    private $allDepartments = [];

    public function __construct()
    {
        $this->departmentOfPurchases = new DepartmentOfPurchases();
        $this->salesDepartment = new SalesDepartment();
        $this->departmentOfAdvertising = new DepartmentOfAdvertising();
        $this->departmentOfLogistics = new DepartmentOfLogistics();

        $employeesDepartmentOfPurchases = [
            array(9 => new Manager(1, false)),
            array(3 => new Manager(2, false)),
            array(2 => new Manager(3, false)),
            array(2 => new Marketer(1, false)),
            array(1 => new Manager(2, true))
        ];
        $this->fillTheDepartment($this->departmentOfPurchases, $employeesDepartmentOfPurchases);

        $employeesSalesDepartment = [
            array(12 => new Manager(1, false)),
            array(6 => new Marketer(1, false)),
            array(3 => new Analyst(1, false)),
            array(2 => new Analyst(2, false)),
            array(1 => new Marketer(2, true))
        ];
        $this->fillTheDepartment($this->salesDepartment, $employeesSalesDepartment);

        $employeesDepartmentOfAdvertising = [
            array(15 => new Marketer(1, false)),
            array(10 => new Marketer(2, false)),
            array(8 => new Manager(1, false)),
            array(2 => new Engineer(1, false)),
            array(1 => new Marketer(3, true)),
        ];

        $this->fillTheDepartment($this->departmentOfAdvertising, $employeesDepartmentOfAdvertising);

        $employeesDepartmentOfLogistics = [
            array(13 => new Manager(1, false)),
            array(5 => new Manager(2, false)),
            array(5 => new Engineer(1, false)),
            array(1 => new Manager(1, true)),
        ];

        $this->fillTheDepartment($this->departmentOfLogistics, $employeesDepartmentOfLogistics);

        $this->allDepartments[] = $this->departmentOfPurchases;
        $this->allDepartments[] = $this->salesDepartment;
        $this->allDepartments[] = $this->departmentOfAdvertising;
        $this->allDepartments[] = $this->departmentOfLogistics;
    }

    private function fillTheDepartment($department,$addToDepartment)
    {
        foreach($addToDepartment as $item)
        {
            foreach($item as $count => $employee)
            {
                for($i = 0; $i < $count; $i++)
                {
                   $department->addEmployee($employee);
               }
            }
        }
    }

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

        // Сама таблица
        $totalEmployees = 0;
        $totalWageCosts = 0;
        $totalCoffeeConsumption = 0;
        $totalPaperConsumption = 0;
        $totalAverageDischarge = 0;

        $averageEmployees = 0;
        $averageWageCosts = 0;
        $averageCoffeeConsumption = 0;
        $averagePaperConsumption = 0;
        $averageAverageDischarge = 0;

        foreach ($this->allDepartments as $department) {
            echo $this->padRight($department->getTitle(), $col1) .
                $this->padLeft($department->getCountEmployees(), $col2) .
                $this->padLeft($department->getWageCosts(),$col3).
                $this->padLeft($department->getCoffeeConsumption(), $col4) .
                $this->padLeft($department->getPaperConsumption(), $col5) .
                $this->padLeft($department->getAverageDischarge(), $col6) . "\n";

            $totalEmployees += $department->getCountEmployees();
            $totalWageCosts += $department->getWageCosts();
            $totalCoffeeConsumption += $department->getCoffeeConsumption();
            $totalPaperConsumption += $department->getPaperConsumption();
            $totalAverageDischarge += $department->getAverageDischarge();
        }

        // Конец таблица
        echo $this->padRight("Всего", $col1) .
            $this->padLeft($totalEmployees, $col2) .
            $this->padLeft($totalWageCosts,$col3).
            $this->padLeft($totalCoffeeConsumption, $col4) .
            $this->padLeft($totalPaperConsumption, $col5) .
            $this->padLeft($totalAverageDischarge, $col6) . "\n";
    }

    private function padRight($string,$length){
        $space="";

        $length=$length-mb_strlen($string);
        for($i = 0;$i < $length; $i++){
            $space = $space." " ;
        }
        return $string.$space;
    }

    private function padLeft($string,$length){
        $space="";

        // Вычитаем длину строки из колонки
        $length = $length - mb_strlen($string)+2;

        for ($i = 0; $i < $length; $i++) {
            $space = $space . " ";
        }
        $result = $space . $string;
        return $result;
    }

}