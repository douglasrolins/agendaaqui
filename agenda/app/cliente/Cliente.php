<?php

include_once __DIR__ . '../../database/Database.php';

class Cliente
{

    // Atributos
    private $id;
    private $nome;
    private $telefone;
    private $email;
    private $senha;

    // Método construtor

    public function __construct($id, $nome, $telefone, $email, $senha = null)
    {
        $this->id = $id;
        $this->nome = $nome;
        $this->telefone = $telefone;
        $this->email = $email;
        $this->senha = $senha;
    }


    // Método Get

    public function getId()
    {
        return $this->id;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function getTelefone()
    {
        return $this->telefone;
    }

    public function getEmail()
    {
        return $this->email;
    }

    // Métodos Set

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    public function setTelefone($telefone)
    {
        $this->telefone = $telefone;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function setSenha($senha)
    {
        $this->id = $senha;
    }


    // Demais Métodos

    public function cadastrar()
    {

        // Conectar com o banco de dados
        $db = new Database();
        $conn = $db->connect();

        // Verificar se o e-mail já está cadastrado
        $stmt = $conn->prepare("SELECT id FROM cliente WHERE email = ?");
        $stmt->bind_param("s", $this->email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            // E-mail já cadastrado
            $stmt->close();
            $db->closeConnection();
            return "email_existente";
        }

        $stmt->close();

        // Gerar hash para a senha
        $hashedSenha = password_hash($this->senha, PASSWORD_DEFAULT);

        // Salvar o cliente no banco de dados
        $stmt = $conn->prepare("INSERT INTO cliente (nome,telefone,email,senha) VALUES (?,?,?,?)");
        $stmt->bind_param("ssss", $this->nome, $this->telefone, $this->email, $hashedSenha);

        if ($stmt->execute()) {
            $stmt->close();
            $db->closeConnection();
            return true;
        } else {
            $stmt->close();
            $db->closeConnection();
            return false;
        }
    }

    public function atualizar() {}

    public function apagar() {}

    // Método para autenticar usuário
    public static function realizaLogin($email, $senha)
    {
        // Conectar com o banco de dados
        $db = new Database();
        $conn = $db->connect();

        $stmt = $conn->prepare("SELECT * FROM cliente WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($user = $result->fetch_assoc()) {
            //if ($senha == $user['senha']) {
            // Verifica a senha criptografada
            if (password_verify($senha, $user['senha'])) {
                // Autenticação bem-sucedida
                $conn->close();
                return new Cliente($user['id'], $user['nome'], $user['telefone'], $user['email']);
            }
        }

        $conn->close();
        return false; // Falha na autenticação
    }

    public function buscarClientes() {}
}
