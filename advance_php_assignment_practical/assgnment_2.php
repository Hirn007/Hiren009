<?php
class Car {
    public $make;
    public $model;
    public $year;

    public function __construct($make, $model, $year) {
        $this->make = $make;
        $this->model = $model;
        $this->year = $year;
    }

    public function displayDetails() {
        echo "Car Details: " . $this->year . " " . $this->make . " " . $this->model . "\n";
    }
}

$car1 = new Car("Toyota", "Corolla", 2022);
$car2 = new Car("Ford", "Mustang", 2021);

$car1->displayDetails(); 
$car2->displayDetails(); 
