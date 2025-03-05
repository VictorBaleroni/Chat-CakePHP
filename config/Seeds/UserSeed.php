<?php
declare(strict_types=1);

use Migrations\BaseSeed;

/**
 * User seed.
 */
class UserSeed extends BaseSeed
{
 
    public function run(): void
    {
        $data = [];

        $data['name'] = 'victor';
        $data['email'] = 'victor@victor.com';
        $data['password'] = password_hash('123456', PASSWORD_DEFAULT);

        $table = $this->table('users');
        $table->insert($data)->save();
    }
}
