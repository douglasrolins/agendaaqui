<?php

class LoginView
{
    public function render($errorMessage = null)
    {
        echo '<div class="container d-flex justify-content-center align-items-center" style="min-height: 60vh;">';
        echo '<div class="card p-4 shadow-lg" style="max-width: 400px; width: 100%;">';
        echo '<h2 class="text-center">Login</h2>';

        if (isset($_SESSION['message'])) {
            $message = $_SESSION['message']['text'];
            $messageType = $_SESSION['message']['type'];

            // Mapeando o tipo da mensagem para as classes do Bootstrap
            $alertClass = ($messageType == 'success') ? 'alert-success' : 'alert-danger';

            echo "<div class='container mt-3'>";
            echo "<div class='alert $alertClass text-center' role='alert'>$message</div>";
            echo "</div>";

            // Limpa a mensagem após exibi-la
            unset($_SESSION['message']);
        }

        // Exibe mensagem de erro se houver
        if ($errorMessage) {
            echo '<div class="alert alert-danger text-center">' . htmlspecialchars($errorMessage) . '</div>';
        }

        // Formulário de login
        echo '<form action="?control=login&action=login" method="POST">';
        echo '<div class="mb-3">';
        echo '<label for="email" class="form-label">Email:</label>';
        echo '<input type="email" name="email" id="email" class="form-control" required>';
        echo '</div>';

        echo '<div class="mb-3">';
        echo '<label for="senha" class="form-label">Senha:</label>';
        echo '<input type="password" name="senha" id="senha" class="form-control" required>';
        echo '</div>';

        echo '<button type="submit" class="btn btn-primary w-100">Entrar</button>';

        echo '<div class="mt-3 text-center">';
        echo '<p>Ainda não tem conta? <a href="?control=cliente&action=novo">Cadastre-se</a></p>';
        echo '<p><a href="#">Esqueci minha senha!</a></p>';
        echo '</div>';

        echo '</form>';
        echo '</div>';
        echo '</div>';
    }
}
