<?php

// Inicia a sessão no início de todas as páginas
session_start();

// Inclui configurações da aplicação
include_once 'config/appconfig.php';

//Exibir o header
include_once 'static/header.php';

// Aciona controlador

// Obter o controle e ação
$control = $_GET['control'] ?? 'index';
$action = $_GET['action'] ?? 'listar';

$controlClass = ucfirst($control) . 'Control';

function loadControl($control, $controlClass)
{

    $file = __DIR__ . '/app/' . $control . '/' .  $controlClass . '.php';
    if (file_exists($file)) {
        include_once $file;
    } else {
        echo "Arquivo do controlador não encontrado.";
        exit;
    }
}

//Controladores restritos
$restrictedControllers = ['AgendamentoControl'];

// Verifica se o controlador exige autenticação
if (in_array($controlClass, $restrictedControllers)) {

    if (!isset($_SESSION['user_id'])) {

        //Redireciona para página de login
        header('Location: ?control=login');
        exit();
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
include_once 'static/footer.php';
