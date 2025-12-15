<?php
require_once 'Coffee.php';

class Menu {
    private $coffees = [];

    public function addCoffee($coffee) {
        $this->coffees[] = $coffee;
    }

    public function getMenu() {
        return $this->coffees;
    }
}
?>
