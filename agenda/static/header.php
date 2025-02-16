<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap CSS -->
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'>

     <!-- Bootstrap JS (incluindo popper e bundle) -->
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

     <!-- ìcones bootstrap -->
     <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    
     <!-- CSS Personalizado -->
    <link rel='stylesheet' href='<?= BASE_URL ?>/agenda/static/css/styles.css'>

    <!-- Javascript -->
    <script src="<?= BASE_URL ?>/agenda/static/js/scripts.js"></script>

    <title>AgendaAqui - Agendamento de Serviços</title>
</head>

<body class="d-flex flex-column min-vh-100">

    <header>
        <!-- Navbar com fundo azul e texto branco -->
        <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
            <div class="container-fluid">
                <a class="navbar-brand" href="<?= BASE_URL ?>/agenda/">
                    <img src="<?= BASE_URL ?>/agenda/static/img/logo_app.png" alt="Logo App" width="400px"> <!-- Logo -->
                </a>
                <!-- Menu de Navegação -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="<?= BASE_URL ?>/agenda">Início</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= BASE_URL ?>/agenda/admin">Administração</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Breadcrumbs -->
        <!-- <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= BASE_URL ?>/agenda">Início</a></li>
                <li class="breadcrumb-item active" aria-current="page">Página Atual</li>
            </ol>
        </nav> -->
    </header>

    <main class="flex-grow-1">
 
