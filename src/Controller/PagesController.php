<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Http\Exception\ForbiddenException;
use Cake\Http\Exception\NotFoundException;
use Cake\Http\Response;
use Cake\ORM\TableRegistry;
use Cake\View\Exception\MissingTemplateException;

class PagesController extends AppController {
    // public function beforeFilter(\Cake\Event\EventInterface $event)
    // {
    //     parent::beforeFilter($event);

    //     $this->Authentication->allowUnauthenticated(['pages', 'index']);
    // }

    public function index() {
        //  $tableUsers = TableRegistry::getTableLocator()->get('Users');
        //  $users = $tableUsers->find()->all();

        //  $this->set(compact('users'));
        $this->render('home');
    }
}
