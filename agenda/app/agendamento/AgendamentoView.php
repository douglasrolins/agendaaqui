<?php

class AgendamentoView
{
    // Exibir a tela de seleção de serviço
    function exibirSelecaoServico($servicos)
    {
        echo "
    <div class='container mt-4'>
        <h3 class='text-center'>Novo Agendamento</h3>
        <div class='progress mb-3' style='height: 60px;'>
            <div class='progress-bar' style='width: 33%; font-size: 18px; display: flex; flex-direction: row; justify-content: center; align-items: center; white-space: nowrap;' role='progressbar'>
                <strong>1. Escolha o Serviço</strong>
            </div>
        </div>
        <div class='row'>";

        foreach ($servicos as $servico) {
            echo "
            <div class='col-md-2 mb-4'>
                <div class='card h-100 shadow-sm'>
                    <img src='" . BASE_URL . "/agenda/static/img/servicos/{$servico->getLogo()}' class='card-img-top' alt='{$servico->getNome()}' style='height: 120px; object-fit: cover;'>
                    <div class='card-body'>
                        <h5 class='card-title' style='font-size: 1rem;'>{$servico->getNome()}</h5>
                        <p class='card-text text-muted' style='font-size: 0.85rem;'>{$servico->getDescricao()}</p>
                        <p><strong>Valor:</strong> R$ " . number_format($servico->getPreco(), 2, ',', '.') . "</p>
                        <p><strong>Duração:</strong> {$servico->getDuracao()} min</p>
                        <a href='?control=agendamento&action=escolherData&servico_id={$servico->getId()}' class='btn btn-primary w-100'>Selecionar</a>
                    </div>
                </div>
            </div>";
        }

        echo "</div></div>";
    }



    // Exibir a tela de seleção de data e horário
    function exibirSelecaoDataHora($servico, $horariosDisponiveis)
    {
        echo "
        <div class='container mt-4'>
        <h3 class='text-center'>Novo Agendamento</h3>
        <div class='progress mb-3' style='height: 60px;'>
            <div class='progress-bar' style='width: 66%; font-size: 18px; display: flex; flex-direction: row; justify-content: center; align-items: center; white-space: nowrap;' role='progressbar'>
                <span style='opacity: 0.6;'><a href='" . BASE_URL . "/agenda/?control=agendamento&action=novo' style='text-decoration: none; color: inherit;'>1. Escolha o Serviço</a></span>
                <span style='margin: 0 10px;'>➜</span>
                <strong>2. Escolha o Dia e Hora</strong> 
            </div>
        </div>
        <div class='card p-4 shadow-lg'>
            <h5>Serviço Selecionado: {$servico->getNome()}</h5>
            <p><strong>Valor:</strong> R$ " . number_format($servico->getPreco(), 2, ',', '.') . "</p>
            <p><strong>Duração:</strong> {$servico->getDuracao()} minutos</p>

            <form action='?control=agendamento&action=revisarAgendamento' method='post'>
                <input type='hidden' name='servico_id' value='{$servico->getId()}'>
                
                <label for='data' class='form-label'>Escolha a Data:</label>
                <input type='date' id='data' name='data' class='form-control' required>

                <label for='hora' class='form-label mt-3'>Escolha o Horário:</label>
                <select id='hora' name='hora' class='form-control' required>";

        foreach ($horariosDisponiveis as $horario) {
            echo "<option value='{$horario}'>{$horario}</option>";
        }

        echo "
                </select>

                <button type='submit' class='btn btn-primary w-100 mt-3'>Avançar</button>
                <a href='". BASE_URL ."/agenda/?control=agendamento&action=novo' class='btn btn-secondary w-100 mt-3'>Voltar</a>
            </form>
        </div>
    </div>";
    }

    // Exibir a tela de confirmação do agendamento
    function exibirConfirmacao($servico, $data, $hora)
    {
        echo "
        <div class='container mt-4'>
            <h3 class='text-center'>Confirme seu agendamento</h3>
            <div class='progress mb-3' style='height: 60px;'>
                <div class='progress-bar' style='width: 100%; font-size: 18px; display: flex; flex-direction: row; justify-content: center; align-items: center; white-space: nowrap;' role='progressbar'>
                    <span style='opacity: 0.6;'><a href='" . BASE_URL . "/agenda/?control=agendamento&action=novo' style='text-decoration: none; color: inherit;'>1. Escolha o Serviço</a></span>
                    <span style='margin: 0 10px;'>➜</span>
                   <span style='opacity: 0.6;'><a href='" . BASE_URL . "/agenda/?control=agendamento&action=escolherData&servico_id={$servico->getId()}' style='text-decoration: none; color: inherit;'>2. Escolha o Dia e Hora</a></span>
                    <span style='margin: 0 10px;'>➜</span>
                    <strong>3. Revisão e Confirmar</strong>
                </div>
            </div>
            ";

            echo "
            <div class='card p-4 shadow-lg'>
                <h5>Serviço Selecionado: " . $servico->getNome() . "</h5>
                <p><strong>Valor:</strong> R$ " . number_format($servico->getPreco(), 2, ',', '.') . "</p>
                <p><strong>Duração:</strong> " . $servico->getDuracao() . " minutos</p>
                <p><strong>Data:</strong> " . date("d/m/Y", strtotime($data)) . "</p>
                <p><strong>Horário:</strong> " . $hora . "</p>
            
                <form action='?control=agendamento&action=cadastrar' method='post'>
                    <input type='hidden' name='servico_id' value='" . $servico->getId() . "'>
                    <input type='hidden' name='data' value='" . $data . "'>
                    <input type='hidden' name='hora' value='" . $hora . "'>
                    <input type='hidden' name='cliente_id' value='" . $_SESSION['user_id'] . "'>
                    <button type='submit' class='btn btn-primary w-100'>Confirmar Agendamento</button>
                </form>
                <a href='javascript:history.back();' class='btn btn-secondary w-100 mt-3'>Voltar</a>
            </div>
        </div>";
    }
}
