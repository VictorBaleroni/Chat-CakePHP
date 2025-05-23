<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;
use Authentication\PasswordHasher\DefaultPasswordHasher;

class User extends Entity{
    protected array $_accessible = [
        'name' => true,
        'email' => true,
        'password' => true,
        'img' => true,
        'token' => true,
        'conn_id' => true,
        'created_at' => true,
        'updated_at' => true,
    ];

    protected array $_hidden = [
        'password',
        'token',
    ];

    protected function _setPassword(string $password){
        $hasher = new DefaultPasswordHasher();
        return $hasher->hash($password);
    }
}
