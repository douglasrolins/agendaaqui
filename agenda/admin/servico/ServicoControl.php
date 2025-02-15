<?php

include_once 'Servico.php';
include_once 'ServicoView.php';

class ServicoControl
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
                case 'novo':
                    $nome = $params['nome'];
                    $descricao = $params['descricao'];
                    //$logo = $_FILES['logo'] ?? null;
                    $preco = $params['preco'];
                    $duracao = $params['duracao'];
                    //$empresaId = $params['empresa_id'];
                    $empresaId = $params['empresa_id'] ?? null;

                    // Diretório de upload da logo
                    // (__DIR__ pega url absoluta do local do arquivo e 2 para subir 2 níveis e chegar em /agenda )
                    $uploadDir = dirname(__DIR__, 2) . '/static/img/servicos/';

                    // Verifica se a pasta existe, se não, cria
                    if (!is_dir($uploadDir)) {
                        mkdir($uploadDir, 0777, true);
                    }

                    // Processa a imagem
                    if (!empty($_FILES['logo']['name'])) {
                        $extensao = pathinfo($_FILES['logo']['name'], PATHINFO_EXTENSION);
                        $novoNome = str_replace(' ', '_', $nome) . "_" . uniqid() . "." . $extensao; // Nome único para evitar conflitos
                        $caminhoCompleto = $uploadDir . $novoNome;

                        // Move o arquivo para a pasta correta
                        if (move_uploaded_file($_FILES['logo']['tmp_name'], $caminhoCompleto)) {
                            $logo = $novoNome; // Apenas o nome do arquivo será salvo no banco
                        } else {
                            die("Erro ao salvar a imagem.");
                        }
                    } else {
                        $logo = null;
                    }

                    $servico = new Servico(null, $nome, $descricao, $preco, $duracao, $logo, $empresaId);

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

                    header('Location: ?control=servico&action=listar');
                    exit();
                    break;

                case 'editar':
                    $id = $params['id'];
                    $nome = $params['nome'];
                    $descricao = $params['descricao'];
                    $logo = $_FILES['logo'] ?? null;
                    $logoAtual = $params['logo_atual'];
                    $preco = $params['preco'];
                    $duracao = $params['duracao'];
                    $empresaId = $params['empresa_id'];

                    // Diretório de upload da logo
                    // (__DIR__ pega url absoluta do local do arquivo e 2 para subir 2 níveis e chegar em /agenda )
                    $uploadDir = dirname(__DIR__, 2) . '/static/img/servicos/';

                    // Processa a imagem
                    if (!empty($_FILES['logo']['name'])) {
                        // Verifica se existe logo atual e se o arquivo antigo está no servidor
                        if (isset($logoAtual) && !empty($logoAtual)) {
                            // Caminho do arquivo antigo
                            $caminhoAntigo = $uploadDir . $logoAtual;

                            // Verifica se o arquivo antigo existe no servidor e o exclui
                            if (file_exists($caminhoAntigo)) {
                                unlink($caminhoAntigo); // Exclui o arquivo antigo
                            }
                        }
                        // Gera o novo nome para a imagem
                        $extensao = pathinfo($_FILES['logo']['name'], PATHINFO_EXTENSION);
                        $novoNome = str_replace(' ', '_', $nome) . "_" . uniqid() . "." . $extensao; // Nome único para evitar conflitos
                        $caminhoCompleto = $uploadDir . $novoNome;

                        // Move o arquivo para a pasta correta
                        if (move_uploaded_file($_FILES['logo']['tmp_name'], $caminhoCompleto)) {
                            $logo = $novoNome; // Apenas o nome do arquivo será salvo no banco
                        } else {
                            die("Erro ao salvar a imagem.");
                        }
                    } else {
                        // Mantém logo atual se não for escolhida nova imagem
                        $logo = $logoAtual;
                    }

                    $servico = new Servico($id, $nome, $descricao, $preco, $duracao, $logo, $empresaId);
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
                    header('Location: ?control=servico&action=listar');
                    exit();
                    break;

                default:
                    echo "Ação não reconhecida.";
            }
        } else {
            // Trata a solicitação GET
            switch ($action) {
                case 'listar':
                    $servicos = $this->obterTodos();
                    $view = new ServicoView();
                    $view->exibirListaServicos($servicos);
                    break;

                case 'novo':
                    $empresas = $this->obterEmpresas();
                    $view = new ServicoView();
                    $view->exibirFormularioCadastro($empresas);
                    break;

                case 'editar':
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

                case 'deletar':
                    if (isset($params['id'])) {
                        $id = $params['id'];
                        $servico = $this->obterPorId($id);

                        if ($servico) {
                            if ($servico->deletar()) {
                                //apagar arquivo da logo
                                $logoCaminho = dirname(__DIR__, 2) . '/static/img/servicos/' . $servico->getLogo();
                                // Verifica se o arquivo de imagem existe e exclui
                                if (file_exists($logoCaminho)) {
                                    unlink($logoCaminho);  // Remove o arquivo
                                }

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
                    header('Location: ?control=servico&action=listar');
                    exit();
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
