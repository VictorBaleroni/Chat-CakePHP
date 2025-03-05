<?php
declare(strict_types=1);

namespace App\View;

use Cake\View\View;
use Cake\TwigView\View\TwigView;

class AppView extends TwigView{
    
    public function initialize(): void{
        parent::initialize();

        $this->loadHelper('Authentication.Identity');
    }
}
