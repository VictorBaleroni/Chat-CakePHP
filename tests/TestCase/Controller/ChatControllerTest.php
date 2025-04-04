<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\ChatController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\ChatController Test Case
 *
 * @uses \App\Controller\ChatController
 */
class ChatControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.Chat',
    ];
}
