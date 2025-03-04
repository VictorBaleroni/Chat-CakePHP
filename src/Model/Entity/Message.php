<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

class Message extends Entity
{
    protected array $_accessible = [
        'msg' => true,
        'user_id' => true,
        'created_at' => true,
        'updated_at' => true,
        'user' => true,
    ];
}
