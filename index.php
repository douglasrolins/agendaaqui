<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AgendaAqui - Sistema de Agendamento</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome (Ícones) -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <!-- CSS Personalizado -->
    <link rel="stylesheet" href="static/css/styles.css">
</head>

<body>
    <!-- Cabeçalho -->
    <header class="bg-white text-center py-5">
        <div class="container">
            <!-- Imagem do Logo -->
            <img src="static/img/logo_app.png" alt="Logo AgendaAqui" class="img-fluid logo-header">
        </div>
    </header>

    <!-- Menu de Navegação -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary sticky-top">
        <div class="container">
            <a class="navbar-brand" href="#">AgendaAqui</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#sobre">Sobre</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#funcionalidades">Funcionalidades</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contato">Contato</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="agenda">Acesse o sistema</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Seção Sobre -->
    <section id="sobre" class="py-5">
        <div class="container">
            <h2 class="text-center mb-4">Sobre o AgendaAqui</h2>
            <p class="text-center lead">
                O AgendaAqui é um sistema de agendamento online desenvolvido para ajudar empresas a gerenciar seus serviços de forma eficiente. Com uma interface intuitiva e funcionalidades poderosas, você pode otimizar seu tempo e melhorar a experiência dos seus clientes.
            </p>
        </div>
    </section>

    <!-- Seção Funcionalidades -->
    <section id="funcionalidades" class="bg-light py-5">
        <div class="container">
            <h2 class="text-center mb-4">Funcionalidades</h2>
            <div class="row">
                <!-- Funcionalidade 1 -->
                <div class="col-md-4 text-center mb-4">
                    <div class="funcionalidade-item p-4">
                        <i class="fas fa-calendar-alt fa-3x text-primary mb-3"></i>
                        <h3>Agendamento Online</h3>
                        <p>Permita que seus clientes agendem serviços diretamente pelo site.</p>
                    </div>
                </div>
                <!-- Funcionalidade 2 -->
                <div class="col-md-4 text-center mb-4">
                    <div class="funcionalidade-item p-4">
                        <i class="fas fa-clock fa-3x text-primary mb-3"></i>
                        <h3>Gestão de Horários</h3>
                        <p>Controle a disponibilidade de profissionais e evite conflitos de agendamento.</p>
                    </div>
                </div>
                <!-- Funcionalidade 3 -->
                <div class="col-md-4 text-center mb-4">
                    <div class="funcionalidade-item p-4">
                        <i class="fas fa-bell fa-3x text-primary mb-3"></i>
                        <h3>Notificações Automáticas</h3>
                        <p>Envie lembretes por e-mail ou SMS para clientes e profissionais.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Seção Contato -->
    <section id="contato" class="py-5">
        <div class="container">
            <h2 class="text-center mb-4">Contato</h2>
            <form class="row g-3">
                <div class="col-md-6">
                    <label for="nome" class="form-label">Nome</label>
                    <input type="text" class="form-control" id="nome" required>
                </div>
                <div class="col-md-6">
                    <label for="email" class="form-label">E-mail</label>
                    <input type="email" class="form-control" id="email" required>
                </div>
                <div class="col-12">
                    <label for="mensagem" class="form-label">Mensagem</label>
                    <textarea class="form-control" id="mensagem" rows="5" required></textarea>
                </div>
                <div class="col-12 text-center">
                    <button type="submit" class="btn btn-primary btn-lg">Enviar</button>
                </div>
            </form>
        </div>
    </section>

    <!-- Rodapé -->
    <footer class="bg-primary text-white text-center py-4">
        <div class="container">
            <p>&copy; 2025 AgendaAqui. Todos os direitos reservados.</p>
        </div>
    </footer>

    <!-- Bootstrap JS e Dependências -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <!-- JavaScript Personalizado -->
    <script src="static/js/scripts.js"></script>
</body>

</html>