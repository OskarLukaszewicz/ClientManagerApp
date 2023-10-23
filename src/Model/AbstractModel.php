<?php

declare(strict_types=1);

namespace App\Model;

use App\Exception\ConfigurationException;
use App\Exception\StorageException;
use App\Exception\NotFoundException;
use PDO;
use PDOException;

abstract class AbstractModel
{
    protected $conn;  

    public function __construct(array $config)
    {
        try {
            $this->validateConfig($config);
            $this->createConnection($config);
        } catch (PDOException $e) {     
            throw new StorageException('Connection error');
        }
    }

    private function createConnection(array $config): void
    {
        $dsn = "mysql:dbname={$config['database']};host={$config['host']}";
        $this->conn = new PDO(
            $dsn,
            $config['user'],
            $config['password'],
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]
        );
    }

    private function validateConfig(array $config): void
    {
        if (empty($config['database'])
            || empty($config['host']) 
            || empty($config['user'])
            || empty($config['password'])
        ) {
            throw new ConfigurationException('Storage configuration error');
        }
    }

    public function getItem(int $id, string $entity): array
    {
        $entityId = $entity . "_id";

        try {
            $query = "SELECT * FROM $entity WHERE $entityId = $id";
            $result = $this->conn->query($query);
            $item = $result->fetch(PDO::FETCH_ASSOC);
        } catch (\Throwable $e) {
            dump($e->getMessage());die;
        }
        if (!$item) {
            throw new NotFoundException("$entity o id: $id nie istnieje");
        }

        return $item;
    }

    public function deleteItem($id, string $entity)
    {
        $entityId = $entity . "_id";

        try {
            $query = "DELETE FROM $entity WHERE $entityId = $id LIMIT 1";
            $this->conn->exec($query);

        } catch (\Throwable $e) {
            dump($e->getMessage());die;
        }
    }

    public function getItems(string $entity, int $limit = 100, int $offset = 0): array
    {
        try {
            $query = "SELECT * FROM $entity"; 
            $result = $this->conn->query($query, PDO::FETCH_ASSOC);
            return $result->fetchAll();
        } catch (\Throwable $e) {
            dump($e->getMessage());die;
        }
    }
    
    public function createClient(array $data): void
    {

        try {
            $client = $this->conn->quote($data['client_name']);
            $NIP = $this->conn->quote($data['NIP']);
            $address = $this->conn->quote($data['address']);
            $country = $this->conn->quote($data['country']);
            $city = $this->conn->quote($data['city']);
            $packageId = $data['package_id'] ?? 'null';
            $contactPersonId = $data['contact_person_id'] ?? 'null';

            $query = "
                INSERT INTO client(client_name, NIP, address, country, city, package_id, contact_person_id) 
                VALUES($client, $NIP, $address, $country, $city, $packageId, $contactPersonId)       
            ";

            $this->conn->exec($query);

        } catch (\Throwable $e) {
            dump($e->getMessage());
            exit;
        }
    }

    public function createEmployee(array $data): void
    {
        try {
            $firstName = $this->conn->quote($data['first_name']);
            $lastName = $this->conn->quote($data['last_name']);
            $birthDate = $this->conn->quote($data['date_of_birth']);
            $gender = $this->conn->quote($data['gender']);
            $email = $this->conn->quote($data['email']);

            $query = "
                INSERT INTO employee(first_name, last_name, date_of_birth, gender, email) 
                VALUES($firstName, $lastName, $birthDate, $gender, $email)       
            ";

            $this->conn->exec($query);

        } catch (\Throwable $e) {
            dump($e->getMessage());
            exit;
        }
    }

    public function createContactPerson(array $data): string
    {
        try {
            $firstName = $this->conn->quote($data['first_name']);
            $lastName = $this->conn->quote($data['last_name']);
            $email = $this->conn->quote($data['email']);
            $phoneNumber = $this->conn->quote($data['phone_number']);

            $query = "
                INSERT INTO contact_person(first_name, last_name, email, phone_number)
                VALUES($firstName, $lastName, $email, $phoneNumber)
            ";

            $this->conn->exec($query);

            return $this->conn->lastInsertId();

        } catch (\Throwable $e) {
            dump($e->getMessage());
            exit;
        }
    }

    public function createPackage(array $data): string
    {
        try {
            $packageTypeId = $data['package_type_id'];
            $startDate = $this->conn->quote($data['start_date']);
            $endDate = $this->conn->quote($data['end_date']);

            $query = "
                INSERT INTO package(package_type_id, start_date, end_date) 
                VALUES($packageTypeId, $startDate, $endDate)       
            ";

            $this->conn->exec($query);
            return $this->conn->lastInsertId();

        } catch (\Throwable $e) {
            dump($e->getMessage());
            exit;
        }
    }

    public function createPackageType(array $data): void
    {
        try {
            $packageName = $this->conn->quote($data["package_name"]);
            $price = $this->conn->quote($data['price']);
            $packageDescription = $this->conn->quote($data['package_description']);
            $features = $this->conn->quote($data['features']);

            $query = "
                INSERT INTO package_type(package_name, price, package_description, features) 
                VALUES($packageName, $price, $packageDescription, $features)       
            ";

            $this->conn->exec($query);
            
        } catch (\Throwable $e) {
            dump($e->getMessage());
            exit;
        }
    }

    public function getClientsNames(): array
    {
        try {
            $query = "SELECT client_id, client_name FROM client";

            $result = $this->conn->query($query, PDO::FETCH_ASSOC);
            return $result->fetchAll();

        } catch (\Throwable $e) {
            dump($e->getMessage());
            exit;
        }
    }
}