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
            $redirect = $this->Authentication->getLoginRedirect() ?? '/pages';
            if ($redirect) {
                return $this->redirect($redirect);
            }
        }
        // Display error if user submitted and authentication failed
        if ($this->request->is('post') && !$result->isValid()) {
            $this->Flash->error(__('Invalid username or password'));
        }
    }

    public function create(){
        $this->render('create_user');
    }

    public function store(){
        $tableUsers = TableRegistry::getTableLocator()->get('Users');
        $user = $tableUsers->newEmptyEntity();
        $requestUser = $this->request->getData();
        $user->name = $requestUser['name'];
        $user->email = $requestUser['email'];
        $user->password = $requestUser['password'];
        $tableUsers->save($user);

        $this->render('login');
    }

    public function logout(){
        $this->Authentication->logout();
        return $this->redirect(['controller' => 'Users', 'action' => 'login']);
    }
}
