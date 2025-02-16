<?php

include_once __DIR__ . '../../database/Database.php';

class Agendamento
{
    private $id;
    private $data_hora_inicio;
    private $data_hora_final;
    private $status;
    private $data_hora_cadastro;
    private $tipo;
    private $cliente_id;
    private $servico_id;
    private $funcionario_id;

    public function __construct($id = null, $data_hora_inicio, $data_hora_final, $tipo, $cliente_id, $servico_id, $funcionario_id, $status = 'agendado')
    {
        $this->id = $id;
        $this->data_hora_inicio = $data_hora_inicio;
        $this->data_hora_final = $data_hora_final;
        $this->tipo = $tipo;
        $this->cliente_id = $cliente_id;
        $this->servico_id = $servico_id;
        $this->funcionario_id = $funcionario_id;
        $this->status = $status;
    }

    // Métodos GET
    public function getId()
    {
        return $this->id;
    }

    public function getDataHoraInicio()
    {
        return $this->data_hora_inicio;
    }

    public function getDataHoraFinal()
    {
        return $this->data_hora_final;
    }

    public function getTipo()
    {
        return $this->tipo;
    }

    public function getClienteId()
    {
        return $this->cliente_id;
    }

    public function getServicoId()
    {
        return $this->servico_id;
    }

    public function getFuncionarioId()
    {
        return $this->funcionario_id;
    }

    public function getStatus()
    {
        return $this->status;
    }

    // Métodos SET
    public function setId($id)
    {
        $this->id = $id;
    }

    public function setDataHoraInicio($data_hora_inicio)
    {
        $this->data_hora_inicio = $data_hora_inicio;
    }

    public function setDataHoraFinal($data_hora_final)
    {
        $this->data_hora_final = $data_hora_final;
    }

    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
    }

    public function setClienteId($cliente_id)
    {
        $this->cliente_id = $cliente_id;
    }

    public function setServicoId($servico_id)
    {
        $this->servico_id = $servico_id;
    }

    public function setFuncionarioId($funcionario_id)
    {
        $this->funcionario_id = $funcionario_id;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    // Cadastrar um novo agendamento
    public function cadastrar()
    {
        $db = new Database();
        $conn = $db->connect();

        $stmt = $conn->prepare("INSERT INTO agendamento (data_hora_inicio, data_hora_final, tipo, cliente_id, servico_id, funcionario_id, status) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $this->data_hora_inicio, $this->data_hora_final, $this->tipo, $this->cliente_id, $this->servico_id, $this->funcionario_id, $this->status);

        if ($stmt->execute()) {
            $this->id = $stmt->insert_id;
            $stmt->close();
            $db->closeConnection();
            return true;
        } else {
            $stmt->close();
            $db->closeConnection();
            return false;
        }
    }

    // Atualizar um agendamento existente
    public function atualizar()
    {
        $db = new Database();
        $conn = $db->connect();

        $stmt = $conn->prepare("UPDATE agendamento SET data_hora_inicio = ?, data_hora_final = ?, tipo = ?, cliente_id = ?, servico_id = ?, funcionario_id = ?, status = ? WHERE id = ?");
        $stmt->bind_param("sssssssi", $this->data_hora_inicio, $this->data_hora_final, $this->tipo, $this->cliente_id, $this->servico_id, $this->funcionario_id, $this->status, $this->id);

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

    // Cancelar um agendamento 'mudar status para cancelado'
    public function cancelar()
    {
        $db = new Database();
        $conn = $db->connect();

        $stmt = $conn->prepare("UPDATE agendamento SET status = 'cancelado' WHERE id = ?");
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

    // Apagar um agendamento
    public function apagar()
    {
        $db = new Database();
        $conn = $db->connect();

        $stmt = $conn->prepare("DELETE FROM agendamento WHERE id = ?");
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

    // Obter todos os agendamentos de um cliente específico
    public static function agendamentosPorCliente($cliente_id)
    {
        $db = new Database();
        $conn = $db->connect();

        $stmt = $conn->prepare("SELECT * FROM agendamento WHERE cliente_id = ? 
                            ORDER BY data_hora_inicio DESC ");
        $stmt->bind_param("i", $cliente_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $agendamentosData = $result->fetch_all(MYSQLI_ASSOC);

        $stmt->close();
        $db->closeConnection();

        $agendamentos = [];
        foreach ($agendamentosData as $row) {
            $agendamento = new Agendamento(
                $row['id'],
                $row['data_hora_inicio'],
                $row['data_hora_final'],
                $row['tipo'],
                $row['cliente_id'],
                $row['servico_id'],
                $row['funcionario_id'],
                $row['status']
            );
            $agendamentos[] = $agendamento;
        }

        return $agendamentos;
    }

    // Obter todos os agendamentos como objetos Agendamento (com filtros se aplicado)
    public static function getAll($filtros = [])
    {
        $db = new Database();
        $conn = $db->connect();

        $query = "SELECT * FROM agendamento WHERE 1=1";
        $params = [];

        if (!empty($filtros['status'])) {
            $query .= " AND status = ?";
            $params[] = $filtros['status'];
        }

        if (!empty($filtros['data_inicio']) && !empty($filtros['data_fim'])) {
            $query .= " AND DATE(data_hora_inicio) BETWEEN ? AND ?";
            $params[] = $filtros['data_inicio'];
            $params[] = $filtros['data_fim'];
        } elseif (!empty($filtros['data_inicio'])) {
            $query .= " AND DATE(data_hora_inicio) >= ?";
            $params[] = $filtros['data_inicio'];
        } elseif (!empty($filtros['data_fim'])) {
            $query .= " AND DATE(data_hora_inicio) <= ?";
            $params[] = $filtros['data_fim'];
        }

        $query .= " ORDER BY data_hora_inicio ASC";

        $stmt = $conn->prepare($query);

        if (!empty($params)) {
            $stmt->bind_param(str_repeat('s', count($params)), ...$params);
        }

        $stmt->execute();
        $result = $stmt->get_result();
        $agendamentos = [];

        while ($row = $result->fetch_assoc()) {
            $agendamentos[] = new Agendamento(
                $row['id'],
                $row['data_hora_inicio'],
                $row['data_hora_final'],
                $row['tipo'],
                $row['cliente_id'],
                $row['servico_id'],
                $row['funcionario_id'],
                $row['status']
            );
        }

        $stmt->close();
        $db->closeConnection();

        return $agendamentos;
    }

    // Obter um agendamento pelo ID
    public static function getById($id)
    {
        $db = new Database();
        $conn = $db->connect();

        $stmt = $conn->prepare("SELECT * FROM agendamento WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $agendamento = $result->fetch_assoc();

        $stmt->close();
        $db->closeConnection();

        if ($agendamento) {
            return new Agendamento(
                $agendamento['id'],
                $agendamento['data_hora_inicio'],
                $agendamento['data_hora_final'],
                $agendamento['tipo'],
                $agendamento['cliente_id'],
                $agendamento['servico_id'],
                $agendamento['funcionario_id'],
                $agendamento['status']
            );
        }

        return null; // Retorna null caso o agendamento não seja encontrado
    }
    public function getClienteNome()
    {
        $db = new Database();
        $conn = $db->connect();

        $query = "SELECT nome FROM cliente WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $this->cliente_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        $db->closeConnection();

        return $row ? $row['nome'] : 'Desconhecido';
    }

    public function getServicoNome()
    {
        $db = new Database();
        $conn = $db->connect();

        $query = "SELECT nome FROM servico WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $this->servico_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        $db->closeConnection();

        return $row ? $row['nome'] : 'Serviço desconhecido';
    }
}
