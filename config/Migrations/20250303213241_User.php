<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class User extends BaseMigration
{
    public function change(): void {
        $table = $this->table('users');
        $table->addColumn('name', 'string', [
            'limit' => 100,
            'null' => false,
        ]);
        $table->addColumn('email', 'string', [
            'limit' => 200,
            'null' => false,
        ]);
        $table->addColumn('password', 'string', [
            'limit' => 255,
            'null' => false,
        ]);
        $table->addColumn('token', 'string');
        $table->addColumn('conn_id', 'integer');
        $table->addColumn('status', 'string', ['limit' => 10, 'default' => 'Offline']);
        $table->addColumn('created_at', 'timestamp', [
            'default' => 'CURRENT_TIMESTAMP',
        ]);
        $table->addColumn('updated_at', 'timestamp', [
            'default' => 'CURRENT_TIMESTAMP',
            'update' => 'CURRENT_TIMESTAMP',
        ]);

        $table->addIndex('email', ['unique' => true]);
        $table->create();
    }
}
