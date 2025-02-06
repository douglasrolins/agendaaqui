<?php


class ClienteView
{

    function exibirFormularioCadastro()
    {
        // HTML para o formulário de cadastro do cliente
        echo "
         <h3>Cadastre-se</h3>
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
                <button type='submit' class='btn btn-primary'>Enviar</button>
            </div>
        </form>
        ";
    }

    function listarClientes()
    {


        echo "<br>Lista de Clientes<br>";
    }
}
