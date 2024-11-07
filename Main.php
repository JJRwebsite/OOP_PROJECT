<?php

require_once 'EmployeeRoster.php';
require_once 'CommissionEmployee.php';
require_once 'HourlyEmployee.php';
require_once 'PieceWorker.php';

class Main {

    private EmployeeRoster $roster;
    private int $size;

    // Initialize the roster system
    public function start() {
        $this->clear();
        echo $this->getHeader("Welcome to the Employee Roster System") . "\n";
        $this->size = (int)readline("Enter the size of the roster: ");

        if ($this->size < 1) {
            echo "Invalid input. Please try again.\n";
            readline("Press \"Enter\" key to continue...");
            $this->start();
        } else {
            $this->roster = new EmployeeRoster($this->size);
            echo "Available Space on the roster: " . $this->roster->availableSpace() . "\n";
            $this->entrance();
        }
    }

    // Main entrance to the menu options
    public function entrance() {
        while (true) {
            $this->clear();
            $this->menu();
            $choice = (int)readline("Pick from the menu: ");

            switch ($choice) {
                case 1:
                    $this->addMenu();
                    break;
                case 2:
                    $this->deleteMenu();
                    break;
                case 3:
                    $this->otherMenu();
                    break;
                case 0:
                    echo "Exiting...\n";
                    exit;
                default:
                    echo "Invalid input. Please try again.\n";
                    readline("Press \"Enter\" key to continue...");
                    break;
            }
        }
    }

    // Display main menu
    public function menu() {
        $availableSpace = $this->roster->availableSpace();
        echo $this->getHeader("EMPLOYEE ROSTER MENU") . "\n";
        echo "Available Space on the roster: $availableSpace\n";
        echo "[1] Add Employee\n";
        echo "[2] Delete Employee\n";
        echo "[3] Other Menu\n";
        echo "[0] Exit\n";
    }

    // Add employee menu
    public function addMenu() {
        $this->clear();

        // Check if the roster is full before allowing to add
        if ($this->roster->availableSpace() <= 0) {
            echo $this->getHeader("Roster is full. Cannot add more employees.") . "\n";
            readline("Press \"Enter\" key to continue...");
            return;
        }

        echo $this->getHeader("Add New Employee") . "\n";
        $name = readline("Enter name: ");
        $address = readline("Enter address: ");
        $age = (int)readline("Enter age: ");
        $companyName = readline("Enter company name: ");

        $this->empType($name, $address, $age, $companyName);
    }

    // Employee type selection
    public function empType($name, $address, $age, $companyName) {
        $this->clear();
        echo $this->getHeader("Select Employee Type") . "\n";
        echo "[1] Commission Employee\n";
        echo "[2] Hourly Employee\n";
        echo "[3] Piece Worker\n";
        $type = (int)readline("Select type of Employee: ");

        switch ($type) {
            case 1:
                $this->addOnsCE($name, $address, $age, $companyName);
                break;
            case 2:
                $this->addOnsHE($name, $address, $age, $companyName);
                break;
            case 3:
                $this->addOnsPE($name, $address, $age, $companyName);
                break;
            default:
                echo "Invalid input. Please try again.\n";
                readline("Press \"Enter\" key to continue...");
                $this->empType($name, $address, $age, $companyName);
                break;
        }
    }

    // Add Commission Employee
    public function addOnsCE($name, $address, $age, $companyName) {
        $regularSalary = (float)readline("Enter regular salary: ");
        $itemsSold = (int)readline("Enter total items sold: ");
        $commissionRate = (float)readline("Enter commission rate: ");

        $employee = new CommissionEmployee($name, $address, $age, $companyName, $regularSalary, $itemsSold, $commissionRate);
        $this->roster->add($employee);
        $this->repeat();
    }

    // Add Hourly Employee
    public function addOnsHE($name, $address, $age, $companyName) {
        $hoursWorked = (int)readline("Enter total hours worked: ");
        $rate = (float)readline("Enter hourly rate: ");

        $employee = new HourlyEmployee($name, $address, $age, $companyName, $hoursWorked, $rate);
        $this->roster->add($employee);
        $this->repeat();
    }

    // Add Piece Worker
    public function addOnsPE($name, $address, $age, $companyName) {
        $numberItems = (int)readline("Enter number of items finished: ");
        $wagePerItem = (float)readline("Enter wage per item: ");

        $employee = new PieceWorker($name, $address, $age, $companyName, $numberItems, $wagePerItem);
        $this->roster->add($employee);
        $this->repeat();
    }

    // Employee deletion menu
    public function deleteMenu() {
        $this->clear();
        
        // Check if the roster is empty
        if (count(array_filter($this->roster->getRoster())) === 0) {
            echo $this->getHeader("No employees in the current roster.") . "\n";
            readline("Press \"Enter\" key to continue...");
            return;
        }
    
        echo $this->getHeader("List of Employees on the current Roster") . "\n";
        $this->roster->display();
    
        $index = (int)readline("Enter the employee number to delete: ") - 1;
        $this->roster->remove($index);
    
        readline("\nPress \"Enter\" key to continue...");
    }
    

    // Additional menu for various operations
    public function otherMenu() {
        $this->clear();
        echo $this->getHeader("Additional Options") . "\n";
        echo "[1] Display Employees\n";
        echo "[2] Count Employees\n";
        echo "[3] View Payroll\n";
        echo "[0] Return to Main Menu\n";
        $choice = (int)readline("Select Menu: ");

        switch ($choice) {
            case 1:
                $this->displayEmployeeMenu();
                break;
            case 2:
                $this->countEmployeesMenu();
                break;
            case 3:
                $this->roster->payroll();
                break;
            case 0:
                return;
            default:
                echo "Invalid input. Please try again.\n";
                break;
        }

        readline("\nPress \"Enter\" key to continue...");
        $this->otherMenu();
    }

    // Menu for displaying employee types
    public function displayEmployeeMenu() {
        $this->clear();
        echo $this->getHeader("Display Employee Types") . "\n";
        echo "[1] Display All Employees\n";
        echo "[2] Display Commission Employees\n";
        echo "[3] Display Hourly Employees\n";
        echo "[4] Display Piece Workers\n";
        echo "[0] Return to Main Menu\n";
        $choice = (int)readline("Select Menu: ");

        switch ($choice) {
            case 1:
                $this->roster->display();
                break;
            case 2:
                $this->roster->displayByType('CommissionEmployee');
                break;
            case 3:
                $this->roster->displayByType('HourlyEmployee');
                break;
            case 4:
                $this->roster->displayByType('PieceWorker');
                break;
            case 0:
                return;
            default:
                echo "Invalid input. Please try again.\n";
                break;
        }

        readline("\nPress \"Enter\" key to continue...");
    }

    // Employee count menu
    public function countEmployeesMenu() {
        $this->clear();
        echo $this->getHeader("Employee Count") . "\n";
        echo "[1] Count All Employees\n";
        echo "[2] Count Commission Employees\n";
        echo "[3] Count Hourly Employees\n";
        echo "[4] Count Piece Workers\n";
        echo "[0] Return to Main Menu\n";
        $choice = (int)readline("Select Menu: ");

        switch ($choice) {
            case 1:
                echo "Total Employees on the Roster: " . $this->roster->count() . "\n";
                break;
            case 2:
                echo "Total Commission Employees on the Roster: " . $this->roster->countByType('CommissionEmployee') . "\n";
                break;
            case 3:
                echo "Total Hourly Employees on the Roster: " . $this->roster->countByType('HourlyEmployee') . "\n";
                break;
            case 4:
                echo "Total Piece Workers on the Roster: " . $this->roster->countByType('PieceWorker') . "\n";
                break;
            case 0:
                return;
            default:
                echo "Invalid input. Please try again.\n";
                break;
        }
    }

    // Clear console screen
    public function clear() {
        system('clear'); // Use 'cls' for Windows
    }

    // Repeat action based on roster availability
    public function repeat() {
        if ($this->roster->availableSpace() <= 0) {
            echo $this->getHeader("Roster is full.") . "\n";
            readline("Press \"Enter\" key to continue...");
            $this->entrance();
            return;
        }

        $choice = readline("Would you like to add another employee? (Y/N): ");
        if (strtoupper($choice) === "Y") {
            $this->addMenu();
        } else {
            $this->entrance();
        }
    }

    // Function to generate header with a border for sections
    public function getHeader($title) {
        $border = str_repeat("=", strlen($title) + 4);
        return "\n$border\n  $title\n$border";
    }
}

?>
