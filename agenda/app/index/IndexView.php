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
        echo "<h5 class='mb-4'>Olá, " . explode(' ', $_SESSION['user_name'])[0] . "</h5>";
        if (isset($_SESSION['message'])) {

            $message = $_SESSION['message']['text'];
            $messageType = $_SESSION['message']['type'];

            // Mapeando o tipo da mensagem para as classes do Bootstrap
            $alertClass = ($messageType == 'success') ? 'alert-success' : 'alert-danger';

            echo "<div class='container mt-3'>";
            echo "<div class='alert $alertClass text-center fw-bold fs-4' role='alert'>$message</div>";
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
                        <h5>Seus Agendamentos</h5>
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
        if (!$agendamentos) echo "<tr><td colspan='7'>Você não possui agendamentos!</td></tr>";
        else {
            foreach ($agendamentos as $index => $agendamento) {
                // Obter a data e hora a partir do campo data_hora_inicio
                $data = date("d/m/Y", strtotime($agendamento->getDataHoraInicio()));
                $hora = date("H:i", strtotime($agendamento->getDataHoraInicio()));
                $status = $agendamento->getStatus();

                // Pegar o nome do serviço correspondente ao agendamento atual
                $servicoNome = $nomesServicos[$index] ?? "Nome do serviço não encontrado";

                echo "<tr>
                        <td>{$data}</td>
                        <td>{$hora}</td>
                        <td>{$servicoNome}</td>
                        <td>{$status}</td>
                      </tr>";
            }
        }

        echo "  </tbody>
                        </table>
                      </div>";
    }
}
