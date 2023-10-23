<?php

declare(strict_types=1);

namespace App\Controller;
use App\Request;

class PackageTypeController extends AbstractController
{
    public function listAction(): void
  {
    $packageTypes = $this->model->getItems('package_type');

    $viewParams = [
      'items' => $packageTypes,
      'before' => $this->request->getParam('before'),
      'entity' => $this->request->getParam('entity')
    ];

    $this->view->render('listPackageType', $viewParams ?? []);

  }
}