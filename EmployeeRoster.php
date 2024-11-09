<?php

class EmployeeRoster {
    private array $roster;
    private int $maxSize;


    public function __construct($size) {
        $this->roster = array_fill(0, $size, null);
        $this->maxSize = $size;
    }


    public function getRoster() {
        return $this->roster;
    }


    public function add($employee) {
        foreach ($this->roster as $index => $currentEmployee) {
            if ($currentEmployee === null) {
                $this->roster[$index] = $employee;
                echo "Employee added successfully.\n";
                return;
            }
        }

        echo "Roster is full.\n";
    }

    public function remove($index) {
        if (isset($this->roster[$index]) && $this->roster[$index] !== null) {
            $this->roster[$index] = null;
            echo "Employee removed successfully.\n";
        } else {
            echo "Slot is empty.\n";
        }
    }

    public function count() {
        return count(array_filter($this->roster, fn($employee) => $employee !== null));
    }

    public function display() {
        if (empty($this->roster) || count(array_filter($this->roster)) === 0) {
            echo "No employees have been added.\n";
            return; 
        }
    
        foreach ($this->roster as $index => $employee) {
            if ($employee !== null) { 
                $employeeType = $this->getEmployeeType($employee);
                echo "Employee #" . ($index + 1) . " - ";
                echo "Name: " . $employee->getName() . ", ";
                echo "Address: " . $employee->getAddress() . ", ";
                echo "Age: " . $employee->getAge() . ", ";
                echo "Company Name: " . $employee->getCompanyName() . ", ";
                echo "Type: " . $employeeType . "\n";
            }
        }
    }
    

    public function payroll() {
        echo "* Employee Payroll *\n";
    
        if (empty($this->roster) || count(array_filter($this->roster)) === 0) {
            echo "No employees have been added.\n";
            return;
        }
    
        foreach ($this->roster as $index => $employee) {
            if ($employee === null) {
                continue;
            }
    
            echo "Employee #" . ($index + 1) . " - ";
            echo "Name: " . $employee->getName() . ", ";
            echo "Address: " . $employee->getAddress() . ", ";
            echo "Age: " . $employee->getAge() . ", ";
            echo "Company: " . $employee->getCompanyName() . ", ";
    
            if ($employee instanceof CommissionEmployee) {
                echo "Regular Salary: " . $employee->getRegularSalary() . ", ";
                echo "Items Sold: " . $employee->getItemsSold() . ", ";
                echo "Commission Rate: " . $employee->getCommissionRate() . ", ";
                $earnings = $employee->getRegularSalary() + ($employee->getItemsSold() * $employee->getCommissionRate());
            } elseif ($employee instanceof HourlyEmployee) {
                echo "Hours Worked: " . $employee->getHoursWorked() . ", ";
                echo "Hourly Rate: " . $employee->getRate() . ", ";
                $earnings = $employee->getHoursWorked() * $employee->getRate();
            } elseif ($employee instanceof PieceWorker) {
                echo "Items Finished: " . $employee->getNumberItems() . ", ";
                echo "Wage Per Item: " . $employee->getWagePerItem() . ", ";
                $earnings = $employee->getNumberItems() * $employee->getWagePerItem();
            }
    
            echo "Earnings: $" . number_format($earnings, 2) . "\n";
        }
    }
    
    
    
    public function availableSpace() {
        return count(array_filter($this->roster, fn($employee) => $employee === null));
    }

    public function displayByType($type) {
        $found = false;
        foreach ($this->roster as $index => $employee) {
            if ($employee !== null && get_class($employee) === $type) {
                echo "Employee #" . ($index + 1) . " - ";
                echo "Name: " . $employee->getName() . ", ";
                echo "Address: " . $employee->getAddress() . ", ";
                echo "Age: " . $employee->getAge() . ", ";
                echo "Company Name: " . $employee->getCompanyName() . ", ";
                echo "Type: " . get_class($employee) . "\n";
                $found = true;
            }
        }
    
        if (!$found) {
            echo "No employees of type $type found.\n";
        }
    }

    private function getEmployeeType($employee) {
        if ($employee instanceof CommissionEmployee) {
            return "Commission Employee";
        } elseif ($employee instanceof HourlyEmployee) {
            return "Hourly Employee";
        } elseif ($employee instanceof PieceWorker) {
            return "Piece Worker";
        }
        return "Unknown Type";
    }

    public function displayEmployeeCountByType() {
        echo "*** Employee Count by Type ***\n";
        echo "Commission Employees: " . $this->countByType('CommissionEmployee') . "\n";
        echo "Hourly Employees: " . $this->countByType('HourlyEmployee') . "\n";
        echo "Piece Workers: " . $this->countByType('PieceWorker') . "\n";
    }

    public function countEmployeesByType() {
        echo "*** Employee Count by Type ***\n";
        echo "Total Commission Employees: " . $this->countByType('CommissionEmployee') . "\n";
        echo "Total Hourly Employees: " . $this->countByType('HourlyEmployee') . "\n";
        echo "Total Piece Workers: " . $this->countByType('PieceWorker') . "\n";
    }

    public function countByType($type) {
        return count(array_filter($this->roster, fn($employee) => get_class($employee) === $type));
    }
}

?>
