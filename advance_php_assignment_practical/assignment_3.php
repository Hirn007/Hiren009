<?php
class Car {
    private $make;
    private $model;
    private $year;

    public function __construct($make, $model, $year) {
        $this->make = $make;
        $this->model = $model;
        $this->year = $year;
    }

    public function getMake() {
        return $this->make;
    }

    public function setMake($make) {
        $this->make = $make;
    }

    public function getModel() {
        return $this->model;
    }

    public function setModel($model) {
        $this->model = $model;
    }

    public function getYear() {
        return $this->year;
    }

    public function setYear($year) {
        $this->year = $year;
    }

    public function displayDetails() {
        echo "Car Details: $this->year $this->make $this->model\n";
    }
}

$car1 = new Car("Toyota", "Corolla", 2022);
$car2 = new Car("Ford", "Mustang", 2021);

echo $car1->getMake() . "\n";   
$car1->setYear(2025);         
$car1->displayDetails();         

$car2->displayDetails();         
?>
