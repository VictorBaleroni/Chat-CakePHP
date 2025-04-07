<?php

namespace App\Command;

use App\WebSocket\ChatServer;
use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;
use Cake\Console\Arguments;
use Cake\Command\Command;
use Cake\Console\ConsoleIo;

class SocketServerCommand extends Command
{
    public function execute(Arguments $args, ConsoleIo $io)
    {
        $io->out('Iniciando servidor WebSocket...');

        $server = IoServer::factory(
            new HttpServer(
                new WsServer(
                    new ChatServer()
                )
            ),
            8090
        );

        $io->out('Servidor WebSocket rodando na porta 8080');
        $server->run();
    }
}