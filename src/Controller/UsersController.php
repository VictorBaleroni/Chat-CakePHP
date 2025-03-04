<?php
declare(strict_types=1);

namespace App\Controller;


class UsersController extends AppController
{

    public function initialize(): void
    {
        parent::initialize();

        $this->Authentication->allowUnauthenticated(['login']);
    }

    public function login()
    {
        $this->request->allowMethod(['get', 'post']);
        $result = $this->Authentication->getResult();
        if ($result->isValid()) {
            $this->Flash->success(__('Login successful'));
            $redirect = $this->Authentication->getLoginRedirect();
            if ($redirect) {
                return $this->redirect($redirect);
            }
        }

        // Display error if user submitted and authentication failed
        if ($this->request->is('post')) {
            $this->Flash->error(__('Invalid username or password'));
        }
    }
}
