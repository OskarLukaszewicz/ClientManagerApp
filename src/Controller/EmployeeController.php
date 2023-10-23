<?php

declare(strict_types=1);

namespace App\Controller;
use App\Request;

class EmployeeController extends AbstractController
{
  public function listAction(): void
  {
    $employees = $this->model->getItems('employee');

    $viewParams = [
      'items' => $employees,
      'before' => $this->request->getParam('before'),
      'entity' => $this->request->getParam('entity')
    ];

    $this->view->render('listEmployee', $viewParams ?? []);
  }

  public function viewAction(): void
  {
    $employeeId = (int) $this->request->getParam('id');

    $clients = $this->model->getClientsNames();
    $relatedClients = $this->model->getRelatedClients($employeeId);
    $employee = $this->model->getItem($employeeId, 'employee');

    foreach ($clients as $client) {
      $found = false;
      foreach ($relatedClients as $relatedClient) {
          if ($client['client_id'] == $relatedClient['client_id']) {
              $found = true;
              break;
          }
      }
      if (!$found) {
          $filteredClients[] = $client;
      }
    }
    
    $viewParams = [
      'clients' => $filteredClients,
      'related_clients' => $relatedClients,
      'employee' => $employee,
      'entity' => $this->request->getParam('entity')
    ];
    
    $this->view->render('viewEmployee', $viewParams ?? []);
  }

  public function addRelationAction(): void
  {
    if ($this->request->hasPost()) {
      $data = [
        'client_id' => $this->request->postParam('client_id'),
        'employee_id' => $this->request->postParam('employee_id'),
      ];

      $this->model->setRelatedClient($data);
      $this->redirect('./', ['entity' => 'Employee', 'action' => 'view', 'id' => $this->request->postParam('employee_id')]);
    }
  }

  public function removeRelationAction(): void
  {
    $data = [
      'client_id' => $this->request->getParam('cId'),
      'employee_id' => $this->request->getParam('eId'),
    ];
    $this->model->removeRelation($data);

    $this->redirect('./', ['entity' => 'Employee', 'action' => 'view', 'id' => $this->request->getParam('eId')]);
  }
}