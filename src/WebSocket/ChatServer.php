<?php
namespace App\WebSocket;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Cake\ORM\TableRegistry;

class ChatServer implements MessageComponentInterface{
    protected $clients;

    public function __construct()
    {
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn)
    {
        $this->clients->attach($conn);
       

        $uristring = $conn->httpRequest->getUri()->getQuery();

        parse_str($uristring, $uriarray);
        
        if(isset($uriarray['token'])){
            $tableUsers = TableRegistry::getTableLocator()->get('Users');
            $tableUsers->updateAll(
            ['conn_id' => $conn->resourceId],
            ['token' => $uriarray['token']]);
            
            // $userToken->conn_id = $conn->resourceId;
            // $tableUsers->save($userToken);

            echo "New connection! ({$conn->resourceId}), ({$uriarray['token']})\n";           
        }
    }

    public function onMessage(ConnectionInterface $conn, $msg)
    {
        foreach ($this->clients as $client) {
            if ($conn !== $client) {
                $client->send($msg);
            }
        }
    }

    public function onClose(ConnectionInterface $conn)
    {
        $this->clients->detach($conn);
        $uristring = $conn->httpRequest->getUri()->getQuery();

        parse_str($uristring, $uriarray);
        
        if(isset($uriarray['token'])){

            $tableUsers = TableRegistry::getTableLocator()->get('Users');
            $user = $tableUsers->get(5);
            
            $user->conn_id = 0;
            $tableUsers->save($user);

            echo "Connection {$conn->resourceId} has disconnected\n";
        }
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo "Erro: {$e->getMessage()}\n";
        $conn->close();
    }
}