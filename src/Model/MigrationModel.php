<?php 

declare(strict_types=1);

namespace App\Model;

use Throwable;

class MigrationModel extends AbstractModel
{
    public function migrate()
    {
        try {
            $this->createPackageTypeTable();
            $this->createPackageTable();
            $this->createContactPersonTable();
            $this->createEmployeeTable();
            $this->createClientTable();
        } catch (Throwable $e) {
            dump($e->getMessage());
            die;
        }
    }

    private function createClientTable()
    {
        $query = "CREATE TABLE client (
            client_id INT AUTO_INCREMENT PRIMARY KEY,
            client_name VARCHAR(255),
            NIP VARCHAR(20),
            address VARCHAR(255),
            country VARCHAR(255),
            city VARCHAR(255),
            package_id INT,
            contact_person_id INT
        )";
        $this->conn->exec($query);

        $query = "ALTER TABLE client ADD FOREIGN KEY (package_id) REFERENCES package(package_id)";
        $this->conn->exec($query);

        $query = "CREATE TABLE client_employee (
            client_id INT,
            employee_id INT
        )";
        $this->conn->exec($query);

        $query = "ALTER TABLE client ADD FOREIGN KEY (contact_person_id) REFERENCES contact_person(contact_id)";
        $this->conn->exec($query);
    }

    private function createEmployeeTable()
    {
        $query = "CREATE TABLE employee (
            employee_id INT AUTO_INCREMENT PRIMARY KEY,
            first_name VARCHAR(255),
            last_name VARCHAR(255),
            date_of_birth DATE,
            gender VARCHAR(10),
            email VARCHAR(255)
        )";
        $this->conn->exec($query);

    }

    private function createContactPersonTable()
    {
        $query = "CREATE TABLE contact_person (
            contact_id INT AUTO_INCREMENT PRIMARY KEY,
            first_name VARCHAR(255),
            last_name VARCHAR(255),
            email VARCHAR(255),
            phone_number VARCHAR(20)
        )";
        $this->conn->exec($query);
    }

    private function createPackageTable() 
    {
        $query = "CREATE TABLE package (
            package_id INT AUTO_INCREMENT PRIMARY KEY,
            package_type_id INT,
            start_date DATE,
            end_date DATE
        )";
        $this->conn->exec($query);

        $query = "ALTER TABLE package ADD FOREIGN KEY (package_type_id) REFERENCES package_type(package_type_id)";
        $this->conn->exec($query);
    }

    private function createPackageTypeTable()
    {
        $query = "CREATE TABLE package_type (
            package_type_id INT AUTO_INCREMENT PRIMARY KEY,
            package_name VARCHAR(255),
            price DECIMAL(10, 2),
            package_description TEXT,
            features TEXT
        )";

        $this->conn->exec($query);
    }

    public function clearDatabase()
    {
        $this->conn->exec('SET FOREIGN_KEY_CHECKS = 0;');

        $query = $this->conn->query("SHOW TABLES");

        $tables = $query->fetchAll(\PDO::FETCH_COLUMN);
    
        foreach ($tables as $table) {
            $this->conn->exec("TRUNCATE TABLE $table");
        }

        $this->conn->exec('SET FOREIGN_KEY_CHECKS = 1;');
    }
}