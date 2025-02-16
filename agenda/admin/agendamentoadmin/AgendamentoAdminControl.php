<?php

include_once __DIR__ . '/../../app/agendamento/Agendamento.php'; // Model
include_once 'AgendamentoAdminView.php'; // View do admin

class AgendamentoAdminControl
{
    private $view;

    public function __construct()
    {
        $this->view = new AgendamentoAdminView();
    }

    public function handleRequest($action, $params)
    {
        switch ($action) {
            case 'listar':
                $this->listarAgendamentos();
                break;
            default:
                echo "Ação inválida.";
                break;
        }
    }

    public function listarAgendamentos()
    {
        $status = $_GET['status'] ?? '';
        $dataInicio = $_GET['data_inicio'] ?? '';
        $dataFim = $_GET['data_fim'] ?? '';

        $filtros = [
            'status' => $status,
            'data_inicio' => $dataInicio,
            'data_fim' => $dataFim
        ];

        $agendamentos = Agendamento::getAll($filtros);
        $this->view->exibirListaAgendamentos($agendamentos, $filtros);
    }
}
