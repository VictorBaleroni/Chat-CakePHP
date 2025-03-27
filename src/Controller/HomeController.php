<?php
declare(strict_types=1);

namespace App\Controller;

class HomeController extends AppController{
    public function index(){
        $this->render('dash');
    }

    public function store(){
        $user = $this->Authentication->getIdentity();
        dd($user->id);
    }
}
