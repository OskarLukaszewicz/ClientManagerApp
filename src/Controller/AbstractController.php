<?php

declare(strict_types=1);

namespace App\Controller;

use App\Request;
use App\View;
use App\Exception\ConfigurationException;
use App\Model\AbstractModel;

abstract class AbstractController
{
  protected const DEFAULT_ACTION = 'read';
  protected const DEFAULT_ENTITY = 'Client';
  protected static $configuration = [];
  protected Request $request;
  protected View $view;
  protected AbstractModel $model;

  public static function initConfiguration(array $configuration): void
  {
    self::$configuration = $configuration;
  }

  public function __construct(Request $request)
  {
    if(empty(self::$configuration['db'])) {
      throw new ConfigurationException('Configuration error');
    }
    $this->request = $request;
    $this->view = new View();
    $this->setModel();
  }

  public function run(): void
  {
    try {
      $action = $this->getAction() . 'Action';
      if (!method_exists($this, $action)) {
          $action = self::DEFAULT_ACTION . 'Action';
      } 
      $this->$action();
    } catch (\Throwable $e) {
      dump($e->getMessage());die;
    }   
  }

  protected function redirect(string $location, array $params): void
  {
    if(count($params)) {
      $queryParams = [];
      foreach ($params as $key => $value) {
        $queryParams[] = urlencode($key) . '=' . urlencode($value);
      }
      $queryParams = implode('&', $queryParams);
      $location .= '?' . $queryParams;
    }

    header("Location: $location");
    exit;
  }

  private function getAction(): string
  {
    return $this->request->getParam('action', self::DEFAULT_ACTION);
  }

  private function setModel()
  {
    $entity = $this->request->getParam('entity', self::DEFAULT_ENTITY);
    $model = "App\Model\\" . $entity . "Model";

    $this->model = new $model(self::$configuration['db']);
  }

  private function readAction()
  {
    $viewParams = [
      'entity' => "Migration"
  ];

  $this->view->render('listMigration', $viewParams ?? []);
  }
}