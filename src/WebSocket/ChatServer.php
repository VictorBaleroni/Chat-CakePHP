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

            $users_id = $tableUsers->find()->select(['id'])
            ->where(['token' => $uriarray['token']])->all();

            $send_data['id'] = $users_id;

            foreach($this->clients as $client){
                    if($client->resourceId != $conn->resourceId){
                        $client->send(json_encode($send_data));
                    }
                }

            echo "New connection! ({$conn->resourceId}), ({$uriarray['token']})\n";    
        }
    }

    public function onMessage(ConnectionInterface $conn, $msg){
        $data = json_decode($msg);
        
    if(isset($data->type)){
        if($data->type == 'request_users_list'){
            $usersTable = TableRegistry::getTableLocator()->get('Users');

            $userData = $usersTable->find()
                ->select(['id', 'name'])
                ->where(['id !=' => $data->me_user_id])
                ->orderByAsc('name')
                ->all();

            $item_data = array();

            foreach($userData as $ud){
                $item_data[] = array(
                    'name' => $ud['name'],
                    'id' => $ud['id']
                );
            }

            $sender_user_conn = $usersTable->find()->select('conn_id')->where(['id IN' => $data->me_user_id])->all();

            $response_data['data_user'] = $item_data;

            $response_data['response_load_users'] = true;

            foreach($this->clients as $client)
                {
                    if($client->resourceId == $sender_user_conn[0]->conn_id)
                    {
                        $client->send(json_encode($response_data));
                    }
                }
        }

        if($data->type == 'request_search_user'){
            
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
            $tableUsers->updateAll(
            ['conn_id' => 0],
            ['token' => $uriarray['token']]);

            echo "Connection {$conn->resourceId} has disconnected\n";
        }
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo "Erro: {$e->getMessage()}\n";
        $conn->close();
    }
}