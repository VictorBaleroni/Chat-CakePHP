<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

class User extends Entity
{
    protected array $_accessible = [
        'name' => true,
        'email' => true,
        'password' => true,
        'created_at' => true,
        'updated_at' => true,
        'messages' => true,
    ];

    protected array $_hidden = [
        'password',
    ];
}
