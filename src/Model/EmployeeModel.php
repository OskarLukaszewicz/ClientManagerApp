<?php 

declare(strict_types=1);

namespace App\Model;

class EmployeeModel extends AbstractModel
{
    public function getRelatedClients(int $employeeId): array
    {
        try {
            $query = 'SELECT client.client_id, client.client_name, client.country, client.city, CONCAT(contact_person.first_name, " ", contact_person.last_name), contact_person.phone_number
                FROM client
                INNER JOIN client_employee ON client.client_id = client_employee.client_id
                INNER JOIN employee ON client_employee.employee_id = employee.employee_id
                INNER JOIN contact_person ON client.contact_person_id = contact_person.contact_id
                WHERE employee.employee_id =' . "$employeeId";
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