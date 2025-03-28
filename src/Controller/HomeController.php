<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\ORM\TableRegistry;

class HomeController extends AppController{
    public function index(){
        $tableMessages = TableRegistry::getTableLocator()->get('Messages');
        $messages = $tableMessages->find();
        $this->set(compact('messages'));
        $this->render('dash');
    }

    public function store(){
        $tableMessages = TableRegistry::getTableLocator()->get('Messages');
        $messages = $tableMessages->newEmptyEntity();
        $user = $this->Authentication->getIdentity();

        //$page = $this->request->getQuery();
        $page = $this->request->getData();
        $messages->msg = $page['message'];
        $messages->user_id = $user->id;
        $tableMessages->save($messages);

        $this->redirect(['controller' => 'Home', 'action' => 'index']);
    }
}
