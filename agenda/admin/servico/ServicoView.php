<?php

class ServicoView
{

    // Método para exibir o formulário de cadastro do serviço
    public function exibirFormularioCadastro($empresas)
    {
        echo "
        <div class='container mt-5'>
            <div class='card p-4 shadow-lg'>
                <h3 class='text-center'>Novo Serviço</h3>
                <form action='?control=servico&action=novo' method='post' enctype='multipart/form-data'>
                    <input type='hidden' name='action' value='novo'>

                    <div class='mb-3'>
                        <label for='nome' class='form-label'>Nome:</label>
                        <input type='text' id='nome' name='nome' class='form-control' required>
                    </div>

                    <div class='mb-3'>
                        <label for='descricao' class='form-label'>Descrição:</label>
                        <textarea id='descricao' name='descricao' class='form-control' required></textarea>
                    </div>

                    <div class='mb-3'>
                        <label for='logo' class='form-label'>Logo:</label>
                        <input type='file' id='logo' name='logo' class='form-control' accept='image/*'>
                    </div>

                    <div class='mb-3'>
                        <label for='preco' class='form-label'>Preço:</label>
                        <input type='number' step='0.01' id='preco' name='preco' class='form-control' required>
                    </div>

                    <div class='mb-3'>
                        <label for='duracao' class='form-label'>Duração (minutos):</label>
                        <input type='number' id='duracao' name='duracao' class='form-control' required>
                    </div>
";
        //             <div class='mb-3'>
        //                 <label for='empresa_id' class='form-label'>Empresa:</label>
        //                 <select id='empresa_id' name='empresa_id' class='form-select' required>
        //                     <option value=''>Selecione a empresa</option>";
        // foreach ($empresas as $empresa) {
        //     echo "<option value='{$empresa->getId()}'>{$empresa->getNome()}</option>";
        // }
        // echo "
        //                 </select>
        //             </div>
        echo "
                    <button type='submit' class='btn btn-primary w-100'>Cadastrar</button>
                </form>
            </div>
        </div>";
    }

    // Método para exibir a lista de serviços em uma tabela
    public function exibirListaServicos($servicos)
    {
        echo "<div class='container mt-5'>";
        echo "<button class='btn btn-success mb-3' onclick=\"window.location.href='?control=servico&action=novo'\">Inserir Serviço</button>";
        echo "<h3 class='text-center'>Lista de Serviços</h3>";

        if (isset($_SESSION['message'])) {
            $message = $_SESSION['message']['text'];
            $messageType = $_SESSION['message']['type'];

            // Definindo a classe do Bootstrap com base no tipo da mensagem
            $alertClass = ($messageType == 'success') ? 'alert-success' : 'alert-danger';

            echo "<div class='container mt-3'>";
            echo "<div class='alert $alertClass text-center' role='alert'>$message</div>";
            echo "</div>";

            // Limpa a mensagem após exibi-la
            unset($_SESSION['message']);
        }

        echo "<table class='table table-striped table-bordered'>";
        //echo "<thead class='table-dark'><tr><th>Nome</th><th>Descrição</th><th>Logo</th><th>Preço</th><th>Duração</th><th>Empresa</th><th>Ações</th></tr></thead><tbody>";
        echo "<thead class='table-dark'><tr><th>Nome</th><th>Descrição</th><th>Logo</th><th>Preço</th><th>Duração</th><th>Ações</th></tr></thead><tbody>";
        if (!$servicos) echo "<tr><td colspan='7'>Nenhum serviço cadastrado!</td></tr>";
        else {
            foreach ($servicos as $servico) {
                echo "<tr>";
                echo "<td>{$servico->getNome()}</td>";
                echo "<td>{$servico->getDescricao()}</td>";
                echo "<td><img src='" . BASE_URL . "/agenda/static/img/servicos/{$servico->getLogo()}' width='30px'></td>";
                echo "<td>R$ " . number_format($servico->getPreco(), 2, ',', '.') . "</td>";
                echo "<td>{$servico->getDuracao()} min</td>";
                // echo "<td>{$servico->getEmpresaId()}</td>";
                echo "<td>
                    <a href='?control=servico&action=editar&id={$servico->getId()}' class='btn btn-warning btn-sm'>Editar</a>
                    <a href='?control=servico&action=deletar&id={$servico->getId()}' class='btn btn-danger btn-sm' onclick='return confirmarExclusao()'>Apagar</a>
                  </td>";
                echo "</tr>";
            }
        }

        echo "</tbody></table></div>";
    }

    public function exibirFormularioEdicao($servico, $empresas)
    {
        echo "
        <div class='container mt-5'>
            <div class='card p-4 shadow-lg'>
                <h3 class='text-center'>Editar Serviço</h3>
                <form action='?control=servico&action=editar' method='post' enctype='multipart/form-data'>
                    <input type='hidden' name='action' value='editar'>
                    <input type='hidden' name='id' value='{$servico->getId()}'>

                    <div class='mb-3'>
                        <label for='nome' class='form-label'>Nome:</label>
                        <input type='text' id='nome' name='nome' class='form-control' required value='{$servico->getNome()}'>
                    </div>

                    <div class='mb-3'>
                        <label for='descricao' class='form-label'>Descrição:</label>
                        <textarea id='descricao' name='descricao' class='form-control' required>{$servico->getDescricao()}</textarea>
                    </div>

                    <div class='mb-3'>
                        <label for='logo_atual' class='form-label'>Logo Atual:</label><br>
                        <img src='" . BASE_URL . "/agenda/static/img/servicos/{$servico->getLogo()}' width='50px'>
                        <input type='hidden' id='logo_atual' name='logo_atual' value='{$servico->getLogo()}'>
                    </div>

                    <div class='mb-3'>
                        <label for='logo' class='form-label'>Escolher Nova Logo:</label>
                        <input type='file' id='logo' name='logo' class='form-control' accept='image/*'>
                    </div>

                    <div class='mb-3'>
                        <label for='preco' class='form-label'>Preço:</label>
                        <input type='number' step='0.01' id='preco' name='preco' class='form-control' required value='{$servico->getPreco()}'>
                    </div>

                    <div class='mb-3'>
                        <label for='duracao' class='form-label'>Duração (minutos):</label>
                        <input type='number' id='duracao' name='duracao' class='form-control' required value='{$servico->getDuracao()}'>
                    </div>
";
        //             <div class='mb-3'>
        //                 <label for='empresa_id' class='form-label'>Empresa:</label>
        //                 <select id='empresa_id' name='empresa_id' class='form-select' required>
        //                     <option value=''>Selecione a empresa</option>";
        // foreach ($empresas as $empresa) {
        //     $selected = ($empresa->getId() == $servico->getEmpresaId()) ? 'selected' : '';
        //     echo "<option value='{$empresa->getId()}' $selected>{$empresa->getNome()}</option>";
        // }
        // echo "
        //                 </select>
        //             </div>
        echo "
                    <button type='submit' class='btn btn-primary w-100'>Atualizar</button>
                </form>
            </div>
        </div>";
    }
}
