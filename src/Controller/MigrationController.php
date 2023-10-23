<?php

namespace App\Controller;

use App\db\DataFixtures;

class MigrationController extends AbstractController
{
    public function listAction()
    {
        $viewParams = [
            'entity' => $this->request->getParam('entity')
        ];

        $this->view->render('listMigration', $viewParams ?? []);
    }

    public function migrateAction() 
    {
        try {
            $this->model->migrate();
        } catch (\Exception $e) {
            dump($e->getMessage());
            die;
        }

        $this->redirect('./', ['entity'=>'Migration', 'action'=>'list']);
    }

    public function populateAction()
    {
        DataFixtures::populate($this->model);

        $this->redirect('./', ['entity'=>'Migration', 'action'=>'list']);
    }

    public function clearAction()
    {
        try {
            $this->model->clearDatabase();
        } catch (\Exception $e) {
            dump($e->getMessage());
            die;
        }

        $this->redirect('./', ['entity'=>'Migration', 'action'=>'list']);
    }
}