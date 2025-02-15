<?php

class IndexView
{
    // Método para exibir a página inicial
    function exibirPaginaInicial()
    {

        if (isset($_SESSION['message'])) {
            $message = $_SESSION['message']['text'];
            $messageType = $_SESSION['message']['type'];

            // Mapeando o tipo da mensagem para as classes do Bootstrap
            $alertClass = ($messageType == 'success') ? 'alert-success' : 'alert-danger';

            echo "<div class='container mt-3'>";
            echo "<div class='alert $alertClass text-center' role='alert'>$message</div>";
            echo "</div>";

            // Limpa a mensagem após exibi-la
            unset($_SESSION['message']);
        }

        // HTML para a página inicial
        echo "
            <div class='container mt-5'>
                <div class='row justify-content-center'>
                    <div class='col-md-6 text-center'>
            ";


        if (isset($_SESSION['user_id'])) {
            echo "<h5 class='mb-4'>Seja bem vindo " . explode(' ', $_SESSION['user_name'])[0] ."</h5>";
           
            echo " <!-- Botão para acessar a lista de serviços -->
                        <a href='index.php?control=agendamento&action=listarServicos' class='btn btn-primary btn-lg btn-block mb-3'>
                            Realizar novo Agendamento
                        </a>
                        
                        <a href='index.php?control=login&action=logout' class='btn btn-secondary btn-lg btn-block mb-3'>
                            Sair
                        </a>";

            echo '
                        <!-- Próximos Agendamentos -->
                        <div class="mt-4">
                            <h5>Próximos Agendamentos (exemplos)</h5>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Data</th>
                                        <th>Serviço</th>
                                        <th>Horário</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Exemplo de agendamento (esses dados seriam dinâmicos no futuro) -->
                                    <tr>
                                        <td>25/02/2025</td>
                                        <td>Manutenção de Equipamento</td>
                                        <td>10:00</td>
                                    </tr>
                                    <tr>
                                        <td>27/02/2025</td>
                                        <td>Consulta de Diagnóstico</td>
                                        <td>14:00</td>
                                    </tr>
                                    <tr>
                                        <td>28/02/2025</td>
                                        <td>Limpeza de Equipamento</td>
                                        <td>16:00</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>';
        } else {
            echo " <!-- Botão para realizar auto cadastro -->
                        <a href='index.php?control=cliente&action=novo' class='btn btn-success btn-lg btn-block mb-3'>
                            Realize seu cadastro
                        </a>

                         <!-- Botão para realiar login -->
                        <a href='index.php?control=login' class='btn btn-primary btn-lg btn-block mb-3'>
                            Fazer login
                        </a>";
        }
    }
}
