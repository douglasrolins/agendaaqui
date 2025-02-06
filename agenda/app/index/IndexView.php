<?php

class IndexView
{
    // Método para exibir a página inicial
    function exibirPaginaInicial()
    {

        if (isset($_SESSION['message'])) {
            $message = $_SESSION['message']['text'];
            $messageType = $_SESSION['message']['type'];

            // Definindo o estilo com base no tipo da mensagem
            if ($messageType == 'success') {
                $style = 'color: green;';
            } else {
                $style = 'color: red;';
            }

            echo "<div style='text-align: center; $style'>$message</div><br>";

            // Limpa a mensagem após exibi-la
            unset($_SESSION['message']);
        }

        // HTML para a página inicial
        echo "
            <div class='container mt-5'>
                <div class='row justify-content-center'>
                    <div class='col-md-6 text-center'>
                        <h1 class='mb-4'>Bem-vindo ao AgendaAqui</h1>
                        <p class='lead mb-4'>Escolha uma opção para continuar:</p>

                         <!-- Botão para realizar auto cadastro -->
                        <a href='index.php?control=cliente&action=novo' class='btn btn-success btn-lg btn-block mb-3'>
                            Realize seu cadastro
                        </a>

                        <!-- Botão para acessar a lista de serviços -->
                        <a href='index.php?control=servicos&action=listar' class='btn btn-primary btn-lg btn-block mb-3'>
                            Acessar Lista de Serviços
                        </a>

                        <!-- Botão para acessar a página de administração -->
                        <a href='/admin/index.php' class='btn btn-secondary btn-lg btn-block'>
                            Acessar Página de Administração
                        </a>
                    </div>
                </div>
            </div>

        ";
    }
}
