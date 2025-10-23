<?php

// Inicia a sessão no início de todas as páginas
session_start();

// Inclui configurações da aplicação
include_once '../config/appconfig.php';

// Detecta se é uma requisição AJAX
//$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
function isAjax()
{
    $header = isset($_SERVER['HTTP_X_REQUESTED_WITH']) ? $_SERVER['HTTP_X_REQUESTED_WITH'] : null;
    return ($header === 'XMLHttpRequest');
}

//Exibir o header
//include_once  '../static/header.php';
if (!isAjax()) {
    include_once '../static/header.php';
}

// Aciona controlador

// Obter o controle e ação
$control = $_GET['control'] ?? 'index';
$action = $_GET['action'] ?? 'listar';

$controlClass = ucfirst($control) . 'Control';

function loadControl($control, $controlClass)
{
    
    $file = __DIR__ ."/" . strtolower($control) . '/' .  $controlClass . '.php';

    if (file_exists($file)) {
        include_once $file;
    } else {
        echo "Arquivo do controlador não encontrado.";
        exit;
    }
}

loadControl($control, $controlClass);

if (class_exists($controlClass)) {

    $controller = new $controlClass();

    // Passa os parâmetros (POST e GET)
    $params = array_merge($_POST, $_GET);

    // Executa a ação
    $controller->handleRequest($action, $params);
}


//Exibir o footer
//include_once '../static/footer.php';
if (!isAjax()) {
    include_once '../static/footer.php';
}
