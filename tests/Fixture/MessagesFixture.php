<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * MessagesFixture
 */
class MessagesFixture extends TestFixture
{
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'msg' => 'Lorem ipsum dolor sit amet',
                'me_user_id' => 1,
                'other_user_id' => 1,
                'created_at' => 1744384257,
                'updated_at' => 1744384257,
            ],
        ];
        parent::init();
    }
}
