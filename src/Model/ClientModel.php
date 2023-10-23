<?php 

declare(strict_types=1);

namespace App\Model;

class ClientModel extends AbstractModel
{
    public function getClientsWithRelations(): array
    {
        try {
            $query = 'SELECT client.client_id, client.client_name, CONCAT(contact_person.first_name, " ", contact_person.last_name), contact_person.phone_number, package_type.package_name, package.end_date
                FROM client
                INNER JOIN contact_person ON contact_person.contact_id = client.contact_person_id
                INNER JOIN package ON package.package_id = client.package_id
                INNER JOIN package_type ON package_type.package_type_id = package.package_type_id;';
                
            $result = $this->conn->query($query);
            $items = $result->fetchAll(\PDO::FETCH_ASSOC);
            return $items;
        
        } catch (\Throwable $e) {
            dump($e->getMessage());
            exit;
        }
    }

    public function getClientWithRelations($id): array
    {
        try {
            $query = 'SELECT client.*, contact_person.*, package_type.package_name, package.*
                FROM client
                INNER JOIN contact_person ON contact_person.contact_id = client.contact_person_id
                INNER JOIN package ON package.package_id = client.package_id
                INNER JOIN package_type ON package_type.package_type_id = package.package_type_id
                WHERE client.client_id =' . " $id";
                
            $result = $this->conn->query($query);
            $items = $result->fetch(\PDO::FETCH_ASSOC);
            return $items;
        
        } catch (\Throwable $e) {
            dump($e->getMessage());
            exit;
        }
    }

    public function getClientsContactPersonId($id)
    {
        try {
            $query = "SELECT contact_person_id FROM client WHERE client.client_id = $id";

            $result = $this->conn->query($query);
            $id = $result->fetch(\PDO::FETCH_NUM);

            return $id[0];
        } catch (\Throwable $e) {
            
        }
    }

    public function deleteContactPerson($id)
    {
        try {
            $query = "DELETE FROM contact_person WHERE contact_id = $id LIMIT 1";
            $this->conn->exec($query);

        } catch (\Throwable $e) {
            dump($e->getMessage());die;
        }
    }

    public function getRelatedEmployees(int $clientId): array
    {
        try {
            $query = 'SELECT employee.*
                FROM client
                INNER JOIN client_employee ON client.client_id = client_employee.client_id
                INNER JOIN employee ON client_employee.employee_id = employee.employee_id
                WHERE client.client_id =' . "$clientId";
            $result = $this->conn->query($query);
            $items = $result->fetchAll(\PDO::FETCH_ASSOC);
            
            return $items;
        
        } catch (\Throwable $e) {
            dump($e->getMessage());
            exit;
        }
    }

    public function setRelatedClient(array $data): void
    {
        try {
            $clientId = $this->conn->quote($data['client_id']);
            $employeeId = $this->conn->quote($data["employee_id"]);

            $query = "
                INSERT INTO client_employee(client_id, employee_id) 
                VALUES($clientId, $employeeId)       
            ";

            $this->conn->exec($query);

        } catch (\Throwable $e) {
            dump($e->getMessage());
            exit;
        }
    }

    public function removeRelation(array $data): void
    {
        try {
            $clientId = $this->conn->quote($data['client_id']);
            $employeeId = $this->conn->quote($data["employee_id"]);

            $query = " DELETE FROM client_employee WHERE client_id = $clientId AND employee_id = $employeeId LIMIT 1";
            $this->conn->exec($query);    

        } catch (\Throwable $e) {
            dump($e->getMessage());
            exit;
        }
    }
}