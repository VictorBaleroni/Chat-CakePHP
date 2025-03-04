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

        $data['name'] = 'user';
        $data['email'] = 'user@user.com';
        $data['password'] = password_hash('12345678', PASSWORD_DEFAULT);

        $table = $this->table('users');
        $table->insert($data)->save();
    }
}
