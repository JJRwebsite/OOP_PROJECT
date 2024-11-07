<?php

class EmployeeRoster {
    private array $roster;
    private int $maxSize;

    // Constructor to initialize the roster with a given size
    public function __construct($size) {
        $this->roster = array_fill(0, $size, null);  // Initialize roster with null values for available slots
        $this->maxSize = $size;
    }

    // Getter method to access the roster array
    public function getRoster() {
        return $this->roster;
    }

    // Add an employee to the roster
    public function add($employee) {
        // Find the first available slot (null)
        foreach ($this->roster as $index => $currentEmployee) {
            if ($currentEmployee === null) {
                $this->roster[$index] = $employee;  // Add the employee in the empty slot
                echo "Employee added successfully.\n";
                return;
            }
        }

        // If no available slot is found, the roster is full
        echo "Roster is full.\n";
    }

    public function remove($index) {
        if (isset($this->roster[$index]) && $this->roster[$index] !== null) {
            // Mark the slot as empty (null) instead of removing the element
            $this->roster[$index] = null;
            echo "Employee removed successfully.\n";
        } else {
            echo "Slot is empty.\n";  // If the slot is already empty
        }
    }

    // Count the number of employees in the roster (excluding nulls)
    public function count() {
        return count(array_filter($this->roster, fn($employee) => $employee !== null));
    }

    // Display all employees (excluding nulls)
    public function display() {
        foreach ($this->roster as $index => $employee) {
            if ($employee !== null) {  // Skip null values
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
    // Display employee payroll details (including regular salary, hours worked, etc.)
public function payroll() {
    echo "* Employee Payroll *\n";
    foreach ($this->roster as $index => $employee) {
        echo "Employee #" . ($index + 1) . " - ";
        echo "Name: " . $employee->getName() . ", ";
        echo "Address: " . $employee->getAddress() . ", ";
        echo "Age: " . $employee->getAge() . ", ";
        echo "Company: " . $employee->getCompanyName() . ", ";

        // Check the employee type and display appropriate details
        if ($employee instanceof CommissionEmployee) {
            echo "Regular Salary: " . $employee->getRegularSalary() . ", ";
            echo "Items Sold: " . $employee->getItemsSold() . ", ";
            echo "Commission Rate: " . $employee->getCommissionRate() . ", ";
            // Payroll calculation for commission-based employees
            $earnings = $employee->getRegularSalary() + ($employee->getItemsSold() * $employee->getCommissionRate());
        } elseif ($employee instanceof HourlyEmployee) {
            echo "Hours Worked: " . $employee->getHoursWorked() . ", ";
            echo "Hourly Rate: " . $employee->getRate() . ", ";
            // Payroll calculation for hourly employees
            $earnings = $employee->getHoursWorked() * $employee->getRate();
        } elseif ($employee instanceof PieceWorker) {
            echo "Items Finished: " . $employee->getNumberItems() . ", ";
            echo "Wage Per Item: " . $employee->getWagePerItem() . ", ";
            // Payroll calculation for piece workers
            $earnings = $employee->getNumberItems() * $employee->getWagePerItem();
        }

        // Display earnings for the employee
        echo "Earnings: $" . number_format($earnings, 2) . "\n";
    }
}

    // Display the available space for adding more employees
    public function availableSpace() {
        // Count the available slots (null values)
        return count(array_filter($this->roster, fn($employee) => $employee === null));
    }

    // Display employee by type (Commission, Hourly, PieceWorker)
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

    // Helper method to get the type of employee
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

    // Display employee count by type
    public function displayEmployeeCountByType() {
        echo "*** Employee Count by Type ***\n";
        echo "Commission Employees: " . $this->countByType('CommissionEmployee') . "\n";
        echo "Hourly Employees: " . $this->countByType('HourlyEmployee') . "\n";
        echo "Piece Workers: " . $this->countByType('PieceWorker') . "\n";
    }

    // Count total employees of each type
    public function countEmployeesByType() {
        echo "*** Employee Count by Type ***\n";
        echo "Total Commission Employees: " . $this->countByType('CommissionEmployee') . "\n";
        echo "Total Hourly Employees: " . $this->countByType('HourlyEmployee') . "\n";
        echo "Total Piece Workers: " . $this->countByType('PieceWorker') . "\n";
    }

    // Count employees of a specific type
    public function countByType($type) {
        return count(array_filter($this->roster, fn($employee) => get_class($employee) === $type));
    }
}

?>
