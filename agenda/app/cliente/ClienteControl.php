<?php

include_once __DIR__ . '/ClienteView.php';

class ClienteControl
{

    // Método que trata a requisição do usuário

    public function handleRequest($action, $params)
    {

        // Verifica se requisição é Post
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            switch ($action) {
                case 'cadastrar':


                case 'atualizar':
                    
            }
        }
        else
        {
            switch ($action) {
                case 'listar':
                    $view = new ClienteView();
                    $view->listarClientes();
                    break;

                case 'novo':
                    // Exibir formulário de cadastro do cliente
                    $view = new ClienteView();
                    $view->exibirFormularioCadastro();

                    break;

                case 'atualizar':

                    break;

                case 'apagar':

                    break;


            }

        }
    }
}
