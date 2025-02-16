<?php

class IndexView
{
    // Método para exibir a página inicial
    function exibirPaginaInicial()
    {

        // HTML para a página inicial do usuário sem estar logado
        echo "
            <div class='container mt-5'>
                <div class='row justify-content-center'>
                    <div class='col-md-6 text-center'>

                    <!-- Botão para realizar auto cadastro -->
                     <a href='index.php?control=cliente&action=novo' class='btn btn-success btn-lg btn-block mb-3'>
                        Realize seu cadastro
                    </a>

                    <!-- Botão para realiar login -->
                    <a href='index.php?control=login' class='btn btn-primary btn-lg btn-block mb-3'>
                        Fazer login
                    </a>
                    </div>
                </div>
            </div>
            ";
    }


    // Método para exibir a página inicial
    function exibirPaginaInicialConectado($agendamentos, $nomesServicos)
    {

        // HTML para a página inicial do cliente logado
        echo "
            <div class='container mt-5'>
                <div class='row justify-content-center'>
                    <div class='col-md-6 text-center'>

            ";
            
        if (isset($_SESSION['message'])) {

            $message = $_SESSION['message']['text'];
            $messageType = $_SESSION['message']['type'];

            // Mapeando o tipo da mensagem para as classes do Bootstrap
            $alertClass = ($messageType == 'success') ? 'alert-success' : 'alert-danger';

            echo "<div class='container mt-3'>";
            echo "<div class='alert $alertClass text-center fw-bold fs-3' role='alert'>$message</div>";
            echo "</div>";

            // Limpa a mensagem após exibi-la
            unset($_SESSION['message']);
        }

        echo " <!-- Botão para acessar a lista de serviços -->
                        <a href='index.php?control=agendamento&action=novo' class='btn btn-primary btn-lg btn-block mb-3'>
                            Novo Agendamento
                        </a>
                        
                        <a href='index.php?control=login&action=logout' class='btn btn-secondary btn-lg btn-block mb-3'>
                            Sair
                        </a>";

        echo "<div class='mt-4'>
                        <h5>Próximos Agendamentos</h5>
                        <table class='table table-striped'>
                            <thead>
                                <tr>
                                    <th>Data</th>
                                    <th>Horário</th>
                                    <th>Serviço</th>
                                    <th>Status</th> 
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>";

        $temProximos = false;
        $temAnteriores = false;
        $agendamentosAnteriores = [];

        if (!$agendamentos) {
            echo "<tr><td colspan='7'>Você não possui agendamentos!</td></tr>";
        } else {
            foreach ($agendamentos as $index => $agendamento) {
                $data = date("d/m/Y", strtotime($agendamento->getDataHoraInicio()));
                $hora = date("H:i", strtotime($agendamento->getDataHoraInicio()));
                $status = $agendamento->getStatus();

                // Obtém a data e hora do agendamento no formato DateTime
                $dataHoraAgendamento = DateTime::createFromFormat("d/m/Y H:i", "$data $hora");

                if ($dataHoraAgendamento !== false) {
                    $timestampAgendamento = $dataHoraAgendamento->getTimestamp();
                    $timestampAtual = time();

                    // Verifica se já ocorreu
                    if ($timestampAtual > $timestampAgendamento) {
                        $status = "concluido";
                        $agendamentosAnteriores[] = [
                            'data' => $data,
                            'hora' => $hora,
                            'servicoNome' => $nomesServicos[$index] ?? "Nome do serviço não encontrado",
                            'status' => $status
                        ];
                        $temAnteriores = true;
                        continue; // Pula para o próximo loop e não exibe aqui
                    } else {
                        $temProximos = true;
                    }
                }

                $servicoNome = $nomesServicos[$index] ?? "Nome do serviço não encontrado";
                $badgeClass = $status == 'cancelado' ? 'badge bg-danger' : ($status == 'agendado' ? 'badge bg-primary' : 'badge bg-success');

                echo "<tr>
                                <td>{$data}</td>
                                <td>{$hora}</td>
                                <td>{$servicoNome}</td>
                                <td><span class='$badgeClass'>" . ucfirst($status) . "</span></td>";

                echo $status == 'agendado'
                    ? "<td><a href='?control=agendamento&action=cancelar&agendamento_id={$agendamento->getId()}' class='btn btn-warning btn-sm' onclick='return cancelarAgendamento()'>Cancelar</a></td>"
                    : "<td></td>";

                echo "</tr>";
            }
        }

        if (!$temProximos) {
            echo "<tr><td colspan='7'>Você não possui agendamentos futuros!</td></tr>";
        }

        echo "  </tbody>
                        </table>
                    </div>";

        if ($temAnteriores) {
            echo "<div class='mt-4'>
                            <h5>Agendamentos Anteriores</h5>
                            <table class='table table-striped'>
                                <thead>
                                    <tr>
                                        <th>Data</th>
                                        <th>Horário</th>
                                        <th>Serviço</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>";

            foreach ($agendamentosAnteriores as $agendamento) {
                echo "<tr>
                                <td>{$agendamento['data']}</td>
                                <td>{$agendamento['hora']}</td>
                                <td>{$agendamento['servicoNome']}</td>
                                <td><span class='badge bg-success'>" . ucfirst($agendamento['status']) . "</span></td>
                              </tr>";
            }

            echo "  </tbody>
                            </table>
                        </div>";
        }
    }
}
