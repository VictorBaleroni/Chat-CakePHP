<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\ORM\TableRegistry;

class PagesController extends AppController {
    public function index() {
        //   $tableUsers = TableRegistry::getTableLocator()->get('Users');
        //   $users = $tableUsers->find()->all();

        //   $this->set(compact('users'));
        $this->render('home');
    }
}
