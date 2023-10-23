<?php

declare(strict_types=1);

namespace App\Controller;

class ClientController extends AbstractController
{
  public function listAction(): void
  {
    $clients = $this->model->getClientsWithRelations();

    $viewParams = [
      'items' => $clients,
      'entity' => $this->request->getParam('entity')
    ];

    $this->view->render('listClient', $viewParams ?? []);
  }
  public function viewAction(): void
  {
    $clientId = (int) $this->request->getParam('id');

    $allEmployees = $this->model->getItems('employee');
    $client = $this->model->getClientWithRelations($clientId);
    $relatedEmployees = $this->model->getRelatedEmployees($clientId);
    
    foreach ($allEmployees as $employee) {
      $found = false;
      foreach ($relatedEmployees as $relatedEmployee) {
          if ($employee['employee_id'] == $relatedEmployee['employee_id']) {
              $found = true;
              break;
          }
      }
      if (!$found) {
          $filteredEmployees[] = $employee;
      }
    }

  $viewParams = [
    "client" => $client,
    "employees" => $filteredEmployees,
    "relatedEmployees" => $relatedEmployees,
    'entity' => $this->request->getParam('entity')
  ];

  $this->view->render('viewClient', $viewParams ?? []);
}
  
  public function createAction(): void
  {
    if ($this->request->hasPost()) {

      $contactPersonData = [
        'first_name' => $this->request->postParam('first_name'),
        'last_name'=> $this->request->postParam('last_name'),
        'email' => $this->request->postParam('email'),
        'phone_number' => $this->request->postParam('phone_number'),
      ];

      $contactId = $this->model->createContactPerson($contactPersonData);
  
      $packageData = [
        'package_type_id' => $this->request->postParam('package_type_id'),
        'start_date' => date('Y-m-d', time()),
        'end_date' => date('Y-m-d', (time() + (60*60*24*365))),
      ];
      $packageId = $this->model->createPackage($packageData);

      $clientData = [
        'client_name' => $this->request->postParam('client_name'),
        'NIP' => $this->request->postParam('NIP'),
        'address' => $this->request->postParam('address'),
        'country' => $this->request->postParam('country'),
        'city' => $this->request->postParam('city'),
        'package_id' => $packageId,
        'contact_person_id' => $contactId,
      ];

      $this->model->createClient($clientData);
      $this->redirect('./', ['entity'=>'Client', 'action'=>'list']);
    }

    $viewParams = [
      'entity' => $this->request->getParam('entity'),
    ];
    
    $this->view->render('createClient', $viewParams ?? []);
  }

  public function deleteAction(): void 
  {
    $clientId = $this->request->getParam('id');
    $contactId = $this->model->getClientsContactPersonId($clientId);

    $this->model->deleteItem($clientId, 'client');
    $this->model->deleteContactPerson($contactId);

    $this->redirect('./', ['entity' => 'Client', 'action' => 'list']);
  }

  public function addRelationAction(): void
  {
    if ($this->request->hasPost()) {
      $data = [
        'client_id' => $this->request->postParam('client_id'),
        'employee_id' => $this->request->postParam('employee_id'),
      ];

      $this->model->setRelatedClient($data);
      
      $this->redirect('./', ['entity' => 'Client', 'action' => 'view', 'id' => $this->request->postParam('client_id')]);

    }
  }

  public function removeRelationAction(): void
  {
    $data = [
      'client_id' => $this->request->getParam('cId'),
      'employee_id' => $this->request->getParam('eId'),
    ];

    $this->model->removeRelation($data);

    $this->redirect('./', ['entity' => 'Client', 'action' => 'view', 'id' => $this->request->getParam('cId')]);
  }
}