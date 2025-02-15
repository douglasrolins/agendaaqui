<?php

include_once __DIR__ . '/../../app/database/Database.php';

class Servico
{
    private $id;
    private $nome;
    private $descricao;
    private $preco;
    private $duracao;
    private $logo;
    private $empresa_id;

    public function __construct($id, $nome, $descricao, $preco, $duracao, $logo, $empresa_id = null)
    {
        $this->id = $id;
        $this->nome = $nome;
        $this->descricao = $descricao;
        $this->preco = $preco;
        $this->duracao = $duracao;
        $this->logo = $logo;
        $this->empresa_id = $empresa_id;
    }

    // Getters e Setters

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    public function getDescricao()
    {
        return $this->descricao;
    }

    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
    }

    public function getPreco()
    {
        return $this->preco;
    }

    public function setPreco($preco)
    {
        $this->preco = $preco;
    }

    public function getDuracao()
    {
        return $this->duracao;
    }

    public function setDuracao($duracao)
    {
        $this->duracao = $duracao;
    }

    public function getLogo()
    {
        return $this->logo;
    }

    public function setLogo($logo)
    {
        $this->logo = $logo;
    }

    public function getEmpresaId()
    {
        return $this->empresa_id;
    }

    public function setEmpresaId($empresa_id)
    {
        $this->empresa_id = $empresa_id;
    }

    // Métodos para cadastro
    public function cadastrar()
    {
        $db = new Database();
        $conn = $db->connect();

        $stmt = $conn->prepare("INSERT INTO servico (nome, descricao, preco, duracao, logo, empresa_id) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssdisi", $this->nome, $this->descricao, $this->preco, $this->duracao, $this->logo, $this->empresa_id);

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

    // Método para atualização
    public function atualizar()
    {
        $db = new Database();
        $conn = $db->connect();

        $stmt = $conn->prepare("UPDATE servico SET nome = ?, descricao = ?, preco = ?, duracao = ?, logo = ?, empresa_id = ? WHERE id = ?");
        $stmt->bind_param("ssdisii", $this->nome, $this->descricao, $this->preco, $this->duracao, $this->logo, $this->empresa_id, $this->id);

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

    // Método para apagar
    public function deletar()
    {
        $db = new Database();
        $conn = $db->connect();

        $stmt = $conn->prepare("DELETE FROM servico WHERE id = ?");
        $stmt->bind_param("i", $this->id);

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


    // Método para listar todos os serviços
    public static function getAll()
    {
        $db = new Database();
        $conn = $db->connect();

        $query = "SELECT * FROM servico";
        $result = $conn->query($query);

        $servicos = [];
        while ($row = $result->fetch_assoc()) {
            $servicos[] = new Servico(
                $row['id'],
                $row['nome'],
                $row['descricao'],
                $row['preco'],
                $row['duracao'],
                $row['logo'],
                $row['empresa_id']
            );
        }

        $conn->close();
        return $servicos;
    }

    // Método para buscar um serviço por ID
    public static function getById($id)
    {
        $db = new Database();
        $conn = $db->connect();

        $stmt = $conn->prepare("SELECT * FROM servico WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            $conn->close();
            return new Servico(
                $row['id'],
                $row['nome'],
                $row['descricao'],
                $row['preco'],
                $row['duracao'],
                $row['logo'],
                $row['empresa_id']
            );
        }

        $conn->close();
        return null;
    }

    // Método para buscar um serviço pelo nome
    public static function getByName($name)
    {
        $db = new Database();
        $conn = $db->connect();

        $stmt = $conn->prepare("SELECT * FROM servico WHERE nome LIKE ?");
        // Adiciona os caracteres de wildcard para o LIKE
        $name = '%' . $name . '%';
        $stmt->bind_param('s', $name);
        $stmt->execute();
        $result = $stmt->get_result();

        $servicos = [];
        while ($row = $result->fetch_assoc()) {
            $servicos[] = new Servico(
                $row['id'],
                $row['nome'],
                $row['descricao'],
                $row['preco'],
                $row['duracao'],
                $row['logo'],
                $row['empresa_id']
            );
        }

        $conn->close();
        return $servicos;
    }
}
