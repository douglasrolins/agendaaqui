<?php

include_once __DIR__ . '../../database/Database.php';

class Cliente {

    // Atributos
    private $id;
    private $nome;
    private $telefone;
    private $email;
    private $senha;

    // Método construtor

    public function __construct($id, $nome, $telefone, $email, $senha)
    {
        $this->id = $id;
        $this->nome = $nome;
        $this->telefone = $telefone;
        $this->email = $email;
        $this->senha = $senha;
    }


    // Método Get

    public function getId(){
        return $this->id;
    }

    public function getNome(){
        return $this->nome;
    }

    public function getTelefone(){
        return $this->telefone;
    }

    public function getEmail(){
        return $this->email;
    }

    // Métodos Set

    public function setId($id){
        $this->id = $id;
    }

    public function setNome($nome){
        $this->nome = $nome;
    }

    public function setTelefone($telefone){
        $this->telefone = $telefone;
    }

    public function setEmail($email){
        $this->email = $email;
    }

    public function setSenha($senha){
        $this->id = $senha;
    }


    // Demais Métodos

    public function cadastrar(){

        // Conectar com o banco de dados
        $db = new Database();
        $conn = $db->connect();

        // Salvar o cliente no banco de dados
        $stmt = $conn->prepare("INSERT INTO cliente (nome,telefone,email,senha) VALUES (?,?,?,?)");
        $stmt->bind_param("ssss",$this->nome,$this->telefone,$this->email,$this->senha);

        if ($stmt->execute()) {
            $stmt->close();
            $db->closeConnection();
            return true;
        }
        else {
            $stmt->close();
            $db->closeConnection();
            return false;
        }


    } 

    public function atualizar(){

    }

    public function apagar(){

    }

    public function realizaLogin(){

    }

    public function buscarClientes(){

    }


}



?>