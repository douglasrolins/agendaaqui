<?php
include_once __DIR__ . '/IndexView.php';

class IndexControl
{
    // Método que trata a requisição do usuário
    public function handleRequest($action, $params)
    {
        // Verifica se a requisição é POST (não será usado aqui, mas mantido para consistência)
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Lógica para ações POST (se necessário no futuro)
        } else {
            // Lógica para ações GET
            switch ($action) {
                default:
                    // Exibe a página inicial
                    $view = new IndexView();
                    $view->exibirPaginaInicial();
                    break;
            }
        }
    }
}
