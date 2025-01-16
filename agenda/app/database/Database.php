<?php

include_once __DIR__ . '/../../config/config.php';

class Database
{

    private $servername;
    private $user;
    private $password;
    private $dbname;
    private $connection;

    // Método construtor

    public function __construct()
    {
        $this->servername = DB_HOST;
        $this->user = DB_USER;
        $this->password = DB_PASSWORD;
        $this->dbname = DB_NAME;  
    }


    // Método para criar uma conexão com o banco de dados
    public function connect()
    {
        $this->connection = new mysqli($this->servername,$this->user,$this->password,$this->dbname);

        return $this->connection;
    }

    // Método para fechar uma conexão do banco de dados
    public function closeConnection()
    {
        if ($this->connection){
            $this->connection->close();
        }

    }



}

?>