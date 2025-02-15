<?php

class ClienteView
{
    function exibirFormularioCadastro()
    {
        // HTML para o formulário de cadastro do cliente
        echo "
        <div class='container d-flex justify-content-center align-items-center' style='min-height: 80vh;'>
            <div class='card p-4 shadow-lg' style='max-width: 400px; width: 100%;'>
                <h3 class='text-center'>Cadastre-se</h3>
                <form action='?control=cliente&action=cadastrar' method='post' enctype='multipart/form-data' class='row g-3'>
                    <div class='col-12'>
                        <label for='nome' class='form-label'>Nome:</label>
                        <input type='text' id='nome' name='nome' class='form-control' required>
                    </div>
                    <div class='col-12'>
                        <label for='telefone' class='form-label'>Telefone:</label>
                        <input type='text' id='telefone' name='telefone' class='form-control'>
                    </div>
                    <div class='col-12'>
                        <label for='email' class='form-label'>Endereço de Email:</label>
                        <input type='email' id='email' name='email' class='form-control'>
                    </div>
                    <div class='col-12'>
                        <label for='senha' class='form-label'>Senha:</label>
                        <input type='password' id='senha' name='senha' class='form-control'>
                    </div>
                    <div class='col-12'>
                        <button type='submit' class='btn btn-primary w-100'>Enviar</button>
                    </div>

                    <div class='mt-3 text-center'>
                        <p>Já possui conta? <a href='?control=login'>Faça login</a></p>
                    </div>
                </form>
            </div>
        </div>
        ";
    }

    function listarClientes()
    {
        echo "<div class='container py-5'>";
        echo "<h3>Lista de Clientes</h3>";
        echo "<p>Aqui será exibida a lista de clientes cadastrados.</p>";
        echo "</div>";
    }
}
