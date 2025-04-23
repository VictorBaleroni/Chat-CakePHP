<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\ORM\TableRegistry;

class UsersController extends AppController{
    public function beforeFilter(\Cake\Event\EventInterface $event){
        parent::beforeFilter($event);
        $this->Authentication->allowUnauthenticated(['login', 'logout', 'create', 'store']);
    }

    public function login(){
        $this->request->allowMethod(['get', 'post']);
        $result = $this->Authentication->getResult();
        
        if ($result->isValid()) {
            $redirect = $this->Authentication->getLoginRedirect() ?? '/chat';
            if ($redirect) {
                return $this->redirect($redirect);
            }
        }
        if ($this->request->is('post') && !$result->isValid()) {
            $this->Flash->error(__('Nome ou senha incorreta!'));
        }
    }

    public function dash(){
        $tableUsers = TableRegistry::getTableLocator()->get('Users');
            $userToken = md5(uniqid());
            $userid = $this->Authentication->getIdentity()->id;
            $user = $tableUsers->get($userid);
            $user->token = $userToken;
            $tableUsers->save($user);

        $this->set('token', $user->token);

        $this->render('/chat/dash');
    }

    public function create(){
        $this->render('create_user');
    }

    public function store(){
        $tableUsers = TableRegistry::getTableLocator()->get('Users');
        $user = $tableUsers->newEmptyEntity();

        $imgPath = 'user'.rand(1, 8).'.png';
        
        $requestUser = $this->request->getData();

        if($requestUser['name'] != '' && $requestUser['email'] != '' && $requestUser['password'] != ''){
            $user->name = $requestUser['name'];
            $user->email = $requestUser['email'];
            $user->password = $requestUser['password'];
            $user->img = $imgPath;
            $tableUsers->save($user);
        }else{
            $this->Flash->error(__('Complete os campos abaixo!'));
            return $this->redirect(['controller' => 'Users', 'action' => 'create']);
        }
        return $this->redirect(['controller' => 'Users', 'action' => 'login']);
    }

    public function edit(){
        $this->render('profile_user');
    }

    public function update(){
        $tableUsers = TableRegistry::getTableLocator()->get('Users');
        $userid = $this->Authentication->getIdentity()->id;
        $user = $tableUsers->get($userid);

        $requestUser = $this->request->getData();
        $user->name = $requestUser['name'];
        $user->email = $requestUser['email'];
        $user->password = $requestUser['password'];
        $tableUsers->save($user);
        return $this->render('profile_user');
    }

    public function logout(){
        $this->Authentication->logout();
        return $this->redirect(['controller' => 'Users', 'action' => 'login']);
    }
}
