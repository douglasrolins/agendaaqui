<?php

include_once 'Agendamento.php';
include_once 'AgendamentoView.php';
include_once __DIR__ . '/../../admin/servico/Servico.php';

class AgendamentoControl
{
    public function __construct()
    {
        // Construtor da classe AgendamentoControl
    }

    public function handleRequest($action, $params)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($params['action'])) {
            $postAction = $params['action'];

            switch ($postAction) {

                case 'revisarAgendamento':
                    if (isset($params['servico_id']) && isset($params['data']) && isset($params['hora'])) {
                        $servico = $this->obterServicoPorId($params['servico_id']);
                        $data = $params['data'];
                        $hora = $params['hora'];
                        $view = new AgendamentoView();
                        $view->exibirConfirmacao($servico, $data, $hora);
                    } else {
                        echo "Dados do agendamento incompletos.";
                    }
                    break;

                case 'cadastrar':
                    $servicoId = $params['servico_id'];
                    $clienteId = $_SESSION['user_id'];
                    $data = $params['data'];
                    $hora = $params['hora'];

                    $servico = Servico::getById($servicoId);
                    $duracaoServico = $servico->getDuracao();

                    // Cria o objeto DateTime para o início, combinando data e hora
                    $inicio = DateTime::createFromFormat('Y-m-d H:i', "$data $hora");

                    // Formata o início para salvar no banco (formato DATETIME)
                    $data_hora_inicio = $inicio->format('Y-m-d H:i:s');

                    // Clona o objeto e soma a duração em minutos para obter o horário final
                    $final = clone $inicio;
                    $final->modify("+{$duracaoServico} minutes");

                    // Formata o horário final
                    $data_hora_final = $final->format('Y-m-d H:i:s');

                    $agendamento = new Agendamento(
                        null,                 // ID (nulo para um novo agendamento)
                        $data_hora_inicio,    // Data e hora de início combinadas
                        $data_hora_final,     // Data e hora de término
                        'online',             // Tipo do agendamento
                        $clienteId,           // ID do cliente
                        $servicoId,           // ID do serviço
                        null,                 // ID do funcionário (ajustar depois)
                        'agendado'            // Status padrão do agendamento
                    );

                    if ($agendamento->cadastrar()) {
                        $_SESSION['message'] = [
                            'text' => 'Agendamento realizado com sucesso!',
                            'type' => 'success'
                        ];
                        header('Location: index.php');
                    } else {
                        $_SESSION['message'] = [
                            'text' => 'Erro ao realizar o agendamento.',
                            'type' => 'error'
                        ];
                        header('Location: index.php');
                    }
                    exit();
                    break;

                default:
                    echo "Ação não reconhecida.";
            }
        } else {
            switch ($action) {
                case 'novo':
                    $servicos = $this->obterServicos();
                    $view = new AgendamentoView();
                    $view->exibirSelecaoServico($servicos);
                    break;

                case 'escolherData':
                    if (isset($params['servico_id'])) {
                        $servicoId = Servico::getById($params['servico_id']);
                        $horariosDisponiveis = $this->obterHorariosDisponiveis($servicoId);
                        $view = new AgendamentoView();
                        $view->exibirSelecaoDataHora($servicoId, $horariosDisponiveis);
                    } else {
                        echo "Serviço não especificado.";
                    }
                    break;

                case 'cancelar':

                    $agendamento = Agendamento::getById($params['agendamento_id']);

                    // Valida se o agendamento pertence ao cliente conectado
                    if ($_SESSION['user_id'] == $agendamento->getClienteId()) {

                        // Cancelar o agendamento
                        if ($agendamento->cancelar()) {
                            $_SESSION['message'] = [
                                'text' => 'Agendamento cancelado com sucesso!',
                                'type' => 'success'
                            ];
                            header('Location: index.php');
                        } else {
                            $_SESSION['message'] = [
                                'text' => 'Erro ao cancelar o agendamento.',
                                'type' => 'error'
                            ];
                            header('Location: index.php');
                        }
                        exit();
                        break;
                    }





                default:
                    echo "Ação não reconhecida.";
            }
        }
    }

    public function obterServicos()
    {
        return Servico::getAll();
    }

    public function obterServicoPorId($id)
    {
        return Servico::getById($id);
    }

    public function obterHorariosDisponiveis($servicoId)
    {
        //return Agendamento::getHorariosDisponiveis($servicoId);
        $horariosDisponiveis = [
            '08:00',
            '09:00',
            '10:00',
            '11:00',
            '14:00',
            '15:00',
            '16:00',
            '17:00'
        ];
        return $horariosDisponiveis;
    }
}
