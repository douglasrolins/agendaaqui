<?php

include_once 'Servico.php';
include_once 'ServicoView.php';

class ServicoController
{
    public function __construct()
    {
        // Construtor da classe ServicoController
    }

    // Método para tratar as requisições
    public function handleRequest($action, $params)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($params['action'])) {
            $postAction = $params['action'];

            switch ($postAction) {
                case 'new':
                    $nome = $params['nome'];
                    $descricao = $params['descricao'];
                    $logo = $_FILES['logo'] ?? null;
                    $preco = $params['preco'];
                    $duracao = $params['duracao'];
                    $empresaId = $params['empresa_id'];

                    $servico = new Servico(null, $nome, $descricao, $logo, $preco, $duracao, $empresaId);

                    if ($servico->cadastrar()) {
                        $_SESSION['message'] = [
                            'text' => 'Serviço cadastrado com sucesso.',
                            'type' => 'success'
                        ];
                    } else {
                        $_SESSION['message'] = [
                            'text' => 'Ocorreu um erro ao cadastrar o serviço.',
                            'type' => 'error'
                        ];
                    }

                    header('Location: ?route=servico&action=list');
                    exit();
                    break;

                case 'edit':
                    $id = $params['id'];
                    $nome = $params['nome'];
                    $descricao = $params['descricao'];
                    $logo = $_FILES['logo'] ?? null;
                    $logoAtual = $params['logo_atual'];
                    $preco = $params['preco'];
                    $duracao = $params['duracao'];
                    $empresaId = $params['empresa_id'];

                    $servico = new Servico($id, $nome, $descricao, $logo ?? $logoAtual, $preco, $duracao, $empresaId);
                    if ($servico->atualizar()) {
                        $_SESSION['message'] = [
                            'text' => 'Serviço atualizado com sucesso.',
                            'type' => 'success'
                        ];
                    } else {
                        $_SESSION['message'] = [
                            'text' => 'Ocorreu um erro ao atualizar o serviço.',
                            'type' => 'error'
                        ];
                    }
                    header('Location: ?route=servico&action=list');
                    exit();
                    break;

                case 'delete':
                    if (isset($params['id'])) {
                        $id = $params['id'];
                        $servico = $this->obterPorId($id);

                        if ($servico) {
                            if ($servico->deletar()) {
                                $_SESSION['message'] = [
                                    'text' => 'Serviço excluído com sucesso!',
                                    'type' => 'success'
                                ];
                            } else {
                                $_SESSION['message'] = [
                                    'text' => 'Ocorreu um erro ao tentar excluir o serviço.',
                                    'type' => 'error'
                                ];
                            }
                        } else {
                            $_SESSION['message'] = [
                                'text' => 'Serviço não encontrado.',
                                'type' => 'error'
                            ];
                        }
                    } else {
                        $_SESSION['message'] = [
                            'text' => 'ID do serviço não especificado.',
                            'type' => 'error'
                        ];
                    }
                    header('Location: ?route=servico&action=list');
                    exit();
                    break;

                default:
                    echo "Ação não reconhecida.";
            }
        } else {
            // Trata a solicitação GET
            switch ($action) {
                case 'list':
                    $servicos = $this->obterTodos();
                    $view = new ServicoView();
                    $view->exibirListaServicos($servicos);
                    break;

                case 'new':
                    $empresas = $this->obterEmpresas();
                    $view = new ServicoView();
                    $view->exibirFormularioCadastro($empresas);
                    break;

                case 'edit':
                    if (isset($params['id'])) {
                        $servico = $this->obterPorId($params['id']);
                        if ($servico) {
                            $empresas = $this->obterEmpresas();
                            $view = new ServicoView();
                            $view->exibirFormularioEdicao($servico, $empresas);
                        } else {
                            echo "Serviço não encontrado.";
                        }
                    } else {
                        echo "ID do serviço não especificado.";
                    }
                    break;

                default:
                    echo "Ação não reconhecida.";
            }
        }
    }

    // Método para obter todos os serviços
    public function obterTodos()
    {
        return Servico::getAll();
    }

    // Método para obter um serviço por ID
    public function obterPorId($id)
    {
        return Servico::getById($id);
    }

    // Método para obter empresas
    public function obterEmpresas()
    {
        // código para pegar todas as empresas
        //return Empresa::getAll();
    }
}
