<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class Message extends BaseMigration
{
    
    public function change(): void {
        $table = $this->table('messages');
        $table->addColumn('msg', 'string', [
            'null' => false,
            'limit' => 255,
        ]);
        $table->addColumn('me_user_id', 'integer');
        $table->addColumn('other_user_id', 'integer');
        $table->addColumn('created_at', 'timestamp', [
            'default' => 'CURRENT_TIMESTAMP',
        ]);
        $table->addColumn('updated_at', 'timestamp', [
            'default' => 'CURRENT_TIMESTAMP',
            'update' => 'CURRENT_TIMESTAMP',
        ]);
        $table->create();
    }
}
