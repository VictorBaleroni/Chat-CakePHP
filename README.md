<h1>Chat em Cake PHP com Websockets</h1>

### Chat para multiplos usuarios simultaneos em tempo real, utilizando ratchet para implementação de websockets.

<p align="center">
<img width="600px" src="https://github.com/user-attachments/assets/1e910666-1db7-4b74-ac26-60d0651a3694">
</p>

### Tela inicial para login e cadastro de usuários.

<p align="center">
<img width="600px" src="https://github.com/user-attachments/assets/6e3ad10a-439d-40c3-ba57-af937f9a6190">
</p>

# Ferramentas
* PHP 8.2.4
* CakePHP 5.0
* Javascript
* Twig
* MySQL
* Ratchet 0.4.4


# Como Inicializar o Projeto
* Crie banco de dados mysql ```chat_db``` foi utilizado phpMyAdmin do xampp.
* No terminal execulte o comando ```composer update```
* Va na pasta ```config/app_local.example.php``` renomeie o arquivo para ```app_local.php```.
* No arquivo va até ```'host' => 'localhost'```, e abaixo modifique para as informações do seu banco, como o root para usuario etc.
* No terminal digite o comando ```bin/cake migrations migrate``` para criar as tabelas.
* Para iniciar o servidor:
* No terminal execulte o comando ```bin/cake server``` para iniciar o site local.
* E não esqueça do servidor de websockets local: ```bin/cake socket-server```
* Crie minimo de dois usuários um no navegador anonimo para se comunicarem!
