<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\ORM\TableRegistry;

class HomeController extends AppController{
    public function index(){
        $userId = $this->Authentication->getIdentity();

        $requestUser = $this->request->getData();
        $requestUserid = $requestUser['userid']; 

        if($requestUserid == null){
            $requestUserid = ['1'];
        }

        $tableMessages = TableRegistry::getTableLocator()->get('Messages');
        $msgs = $tableMessages->find()->contain(['Users'])->where(['OR'=>[
            ['Users.id IN'=>$requestUserid], ['Users.id IN'=>$userId->id]
            ]])->orderBy(['Messages.created_at' => 'ASC'])->toArray();

        $tableUsers = TableRegistry::getTableLocator()->get('Users');
        $users = $tableUsers->find();

        $this->set(compact('msgs', 'users'));
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
