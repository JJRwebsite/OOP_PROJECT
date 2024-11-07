<?php

require_once 'Employee.php';

class HourlyEmployee extends Employee {
    private $hoursWorked;
    private $rate;

    public function __construct($name, $address, $age, $companyName, $hoursWorked, $rate) {
        parent::__construct($name, $address, $age, $companyName);
        $this->hoursWorked = $hoursWorked;
        $this->rate = $rate;
    }

    public function earnings() {
        $overtimeRate = ($this->hoursWorked > 40) ? $this->rate * 1.5 : $this->rate;
        return $this->hoursWorked * $overtimeRate;
    }

    public function toString() {
        return parent::toString() . ", Hours Worked: $this->hoursWorked, Rate: $this->rate";
    }

    // Getter methods
    public function getHoursWorked() {
        return $this->hoursWorked;
    }

    public function getRate() {
        return $this->rate;
    }
}
?>
