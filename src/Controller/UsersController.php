<?php
declare(strict_types=1);

namespace App\Controller;

class UsersController extends AppController{

    public function beforeFilter(\Cake\Event\EventInterface $event){
        parent::beforeFilter($event);
        $this->Authentication->allowUnauthenticated(['login', 'logout']);
    }

    public function login(){
        $this->request->allowMethod(['get', 'post']);
        $result = $this->Authentication->getResult();
        if ($result->isValid()) {
            $this->Flash->success(__('Login successful'));
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

    public function logout(){
        $this->Authentication->logout();
        return $this->redirect(['controller' => 'Users', 'action' => 'login']);
    }
}
