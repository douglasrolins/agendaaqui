<?php

class LoginView
{
    public function render($errorMessage = null)
    {
        echo '<div class="container d-flex justify-content-center align-items-center" style="min-height: 60vh;">';
        echo '<div class="card p-4 shadow-lg" style="max-width: 400px; width: 100%;">';
        echo '<h2 class="text-center">Login</h2>';

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
        echo '</form>';
        echo '</div>';
        echo '</div>';
    }
}
