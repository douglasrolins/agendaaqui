<?php


class ClienteView 
{

    function exibirFormularioCadastro()
    {
        // HTML para o formulário de cadastro do cliente
        echo "
        <h3>Cadastre-se</h3>
        <form action='?control=cliente' method='post' enctype='multipart/form-data'>
            <div>
                <label for='nome'>Nome:</label>
                <input type='text' id='nome' name='nome' required>
            </div>
            <div>
                <label for='telefone'>Telefone:</label>
                <input type='text' id='telefone' name='telefone'>
            </div>
            <div>
                <label for='email'>Endereço:</label>
                <input type='email' id='email' name='email'>
            </div>
            <div>
                <label for='senha'>Senha:</label>
                <input type='password' id='senha' name='senha'>
            </div>
            <button type='submit'>Enviar</button>
        </form>
        ";
    } 


}


?>