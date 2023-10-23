<?php

declare(strict_types=1);

namespace App\Controller;
use App\Request;

class ContactPersonController extends AbstractController
{
    public function listAction(): void
  {
    $contacts = $this->model->getItems('contact_person');
    $companies = $this->model->getItems('client');

    foreach ($contacts as &$contact) {
      foreach ($companies as $company) {
          if ($contact['contact_id'] == $company['contact_person_id']) {
              $contact['client_name'] = $company['client_name'];
              break;
          }
      }
    }

    $viewParams = [
      'items' => $contacts,
      'before' => $this->request->getParam('before'),
      'entity' => $this->request->getParam('entity')
    ];

    $this->view->render('listContactPerson', $viewParams ?? []);

  }
}