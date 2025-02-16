<?php

include_once __DIR__ . '/ClienteView.php';
include_once __DIR__ . '/Cliente.php';

class ClienteControl
{

    // Método que trata a requisição do usuário

    public function handleRequest($action, $params)
    {

        // Verifica se requisição é Post
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            switch ($action) {
                case 'cadastrar':
                    $nome = $params['nome'];
                    $telefone = $params['telefone'];
                    $email = $params['email'];
                    $senha = $params['senha'];

                    $cliente = new Cliente(null, $nome, $telefone, $email, $senha);

                    $resultado = $cliente->cadastrar();

                    if ($resultado === true) {
                        $_SESSION['message'] = [
                            'text' => 'Seu cadastro foi realizado com sucesso. Efetue o login.',
                            'type' => 'success'
                        ];
                        header('Location: ?control=login');
                    } elseif ($resultado === "email_existente") {
                        $_SESSION['message'] = [
                            'text' => 'Já tem uma conta com este e-mail, faça login.',
                            'type' => 'error'
                        ];
                        header('Location: ?control=login');
                    } else {
                        $_SESSION['message'] = [
                            'text' => 'Ocorreu um erro ao realizar seu cadastro.',
                            'type' => 'error'
                        ];
                        header('Location: ?control=cliente&action=cadastrar');
                    }

                    exit(); // Garante que o redirecionamento ocorra e o script não continue
                    break;


                case 'atualizar':
            }
        } else {
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
