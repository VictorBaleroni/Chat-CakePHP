<?php
namespace App\WebSocket;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Cake\ORM\TableRegistry;

class ChatServer implements MessageComponentInterface{
    protected $clients;

    public function __construct(){
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn){
        $this->clients->attach($conn);
       
        $uristring = $conn->httpRequest->getUri()->getQuery();

        parse_str($uristring, $uriarray);
        
        if(isset($uriarray['token'])){
            $tableUsers = TableRegistry::getTableLocator()->get('Users');
            
            $tableUsers->updateAll(
                [['conn_id' => $conn->resourceId], ['status' => 'Online']],
                ['token' => $uriarray['token']]
            );

            $users_id = $tableUsers->find()->select(['id'])
            ->where(['token' => $uriarray['token']])->all()->toArray();

            $send_data['id'] = $users_id[0]->id;
            $send_data['status'] = 'Online';

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

            $userData = $usersTable->find()->select(['id', 'name', 'status', 'img'])
                ->where(['id NOT IN' => $data->me_user_id])
                ->orderByAsc('name')->all()->toArray();

            $item_data = array();

            foreach($userData as $ud){
                $item_data[] = array(
                    'id' => $ud['id'],
                    'name' => $ud['name'],
                    'status' => $ud['status'],
                    'user_img' => $ud['img']
                );
        }

            $sender_user_conn = $usersTable->find()->select('conn_id')->where(['id IN' => $data->me_user_id])->all()->toArray();

            $response_data['data_user'] = $item_data;

            $response_data['response_load_users'] = true;

            foreach($this->clients as $client){
                if($client->resourceId == $sender_user_conn[0]->conn_id){
                    $client->send(json_encode($response_data));
                }
            }
        }

        if($data->type == 'request_search_user'){
            $usersTable = TableRegistry::getTableLocator()->get('Users');

            $userData = $usersTable->find()->select(['id', 'name'])
                ->where(['id NOT IN' => $data->me_user_id])
                ->where(['name LIKE' => '%'. $data->search_query .'%'])
                ->orderByAsc('name')->all()->toArray();

            $item_data = array();

            foreach($userData as $ud){
                $item_data[] = array(
                    'name' => $ud['name'],
                    'id' => $ud['id']
                );
            }

            $sender_user_conn = $usersTable->find()->select('conn_id')->where(['id IN' => $data->me_user_id])->all()->toArray();

            $response_data['data_user'] = $item_data;

            $response_data['response_search_user'] = true;

            foreach($this->clients as $client){
                if($client->resourceId == $sender_user_conn[0]->conn_id){
                    $client->send(json_encode($response_data));
                }
            }
        }

        if($data->type == 'request_all_messages'){
            $msgsTable = TableRegistry::getTableLocator()->get('Messages');

            $sender_msg = $msgsTable->find()->select(['id', 'msg', 'me_user_id', 'other_user_id'])
            ->where(['OR' => [['me_user_id' => $data->me_user_id, 'other_user_id' => $data->other_user_id],
            ['me_user_id' => $data->other_user_id, 'other_user_id' => $data->me_user_id]]])
            ->orderByAsc('id')->all()->toArray();

            $item_data_history = array();

            foreach($sender_msg as $hd){
                $item_data_history[] = array(
                    'id' => $hd['id'],
                    'message' => $hd['msg'],
                    'me_user_id' => $hd['me_user_id'],
                    'other_user_id' => $hd['other_user_id'],
                );
            }

            $usersTable = TableRegistry::getTableLocator()->get('Users');

            $send_data['chat_history'] = $item_data_history;

            $receiver_conn_id = $usersTable->find()->select('conn_id')->where(['id IN' => $data->me_user_id])->all()->toArray();

            foreach($this->clients as $client){
                if($client->resourceId == $receiver_conn_id[0]->conn_id){
                    $client->send(json_encode($send_data));
                }
            }
        }

        if($data->type == 'request_send_message'){
            $msgsTable = TableRegistry::getTableLocator()->get('Messages');

            $msg = $msgsTable->newEmptyEntity();

            $msg->me_user_id = $data->me_user_id;
            $msg->other_user_id = $data->other_user_id;
            $msg->msg = $data->message;
            $msgsTable->save($msg);

            $message_id = $msg->id;

            $usersTable = TableRegistry::getTableLocator()->get('Users');
            
            $receiver_conn_id = $usersTable->find()->select('conn_id')->where(['id IN' => $data->other_user_id])->all()->toArray();

            $sender_conn_id = $usersTable->find()->select('conn_id')->where(['id IN' => $data->me_user_id])->all()->toArray();

            foreach($this->clients as $client){
                if($client->resourceId == $receiver_conn_id[0]->conn_id || $client->resourceId == $sender_conn_id[0]->conn_id){
                    $send_data['chat_message_id'] = $message_id;
                        
                    $send_data['message'] = $data->message;

                    $send_data['me_user_id'] = $data->me_user_id;

                    $send_data['other_user_id'] = $data->other_user_id;

                    $client->send(json_encode($send_data));
                }
            }
        }

        if($data->type == 'request_chat_user'){

        }
    }
}

    public function onClose(ConnectionInterface $conn){
        $this->clients->detach($conn);

        $uristring = $conn->httpRequest->getUri()->getQuery();

        parse_str($uristring, $uriarray);
        
        if(isset($uriarray['token'])){

            $tableUsers = TableRegistry::getTableLocator()->get('Users');
            $tableUsers->updateAll(
            [['conn_id' => 0], ['status' => 'Offline']],
            ['token' => $uriarray['token']]);

            $users_id = $tableUsers->find()->select(['id'])
            ->where(['token' => $uriarray['token']])->all()->toArray();

            $send_data['id'] = $users_id[0]->id;
            $send_data['status'] = 'Offline';

            foreach($this->clients as $client){
                if($client->resourceId != $conn->resourceId){
                    $client->send(json_encode($send_data));
                }
            }

            echo "Connection {$conn->resourceId} has disconnected\n";
        }
    }

    public function onError(ConnectionInterface $conn, \Exception $e){
        echo "Erro: {$e->getMessage()}\n";
        $conn->close();
    }
}