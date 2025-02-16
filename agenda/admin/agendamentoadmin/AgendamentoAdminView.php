<?php

class AgendamentoAdminView {
    
    public function exibirListaAgendamentos($agendamentos, $filtros) {
        $statusSelecionado = $filtros['status'] ?? '';
        $dataInicio = $filtros['data_inicio'] ?? '';
        $dataFim = $filtros['data_fim'] ?? '';

        echo "
        <div class='container mt-4'>
            <h3 class='text-center'>Gerenciamento de Agendamentos</h3>
            <div class='card p-4 shadow-lg'>
                
                <!-- Filtro -->
                <form method='GET' action=''>
                    <input type='hidden' name='control' value='agendamentoAdmin'>
                    <input type='hidden' name='action' value='listar'>

                    <div class='row mb-3'>
                        <!-- Filtro por Status -->
                        <div class='col-md-4'>
                            <label class='form-label'>Status:</label>
                            <select name='status' class='form-select'>
                                <option value=''>Todos</option>
                                <option value='agendado' " . ($statusSelecionado === 'agendado' ? 'selected' : '') . ">Agendado</option>
                                <option value='cancelado' " . ($statusSelecionado === 'cancelado' ? 'selected' : '') . ">Cancelado</option>
                                <option value='concluido' " . ($statusSelecionado === 'concluido' ? 'selected' : '') . ">Concluído</option>
                            </select>
                        </div>

                        <!-- Filtro por Data -->
                        <div class='col-md-3'>
                            <label class='form-label'>Data Início:</label>
                            <input type='date' name='data_inicio' class='form-control' value='$dataInicio'>
                        </div>
                        <div class='col-md-3'>
                            <label class='form-label'>Data Fim:</label>
                            <input type='date' name='data_fim' class='form-control' value='$dataFim'>
                        </div>

                        <!-- Botão Filtrar -->
                        <div class='col-md-2 d-flex align-items-end'>
                            <button type='submit' class='btn btn-primary w-100'>Filtrar</button>
                        </div>
                    </div>
                </form>

                <!-- Tabela de Agendamentos -->
                <table class='table table-striped'>
                    <thead>
                        <tr>
                            <th>Cliente</th>
                            <th>Data</th>
                            <th>Horário</th>
                            <th>Serviço</th>
                            <th>Status</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>";

        if (!$agendamentos) {
            echo "<tr><td colspan='6' class='text-center'>Nenhum agendamento encontrado.</td></tr>";
        } else {
            foreach ($agendamentos as $agendamento) {
                $data = date("d/m/Y", strtotime($agendamento->getDataHoraInicio()));
                $hora = date("H:i", strtotime($agendamento->getDataHoraInicio()));
                $status = $agendamento->getStatus();

                $badgeClass = $status == 'cancelado' ? 'badge bg-danger' : ($status == 'agendado' ? 'badge bg-primary' : 'badge bg-success');
                
                echo "<tr>
                        <td>{$agendamento->getClienteNome()}</td>
                        <td>{$data}</td>
                        <td>{$hora}</td>
                        <td>{$agendamento->getServicoNome()}</td>
                        <td><span class='$badgeClass'>" . ucfirst($status) . "</span></td>
                        <td>
                            <a href='#' class='btn btn-warning btn-sm'>Editar</a>
                            <a href='#' class='btn btn-danger btn-sm'>Excluir</a>
                        </td>
                      </tr>";
            }
        }

        echo "
                    </tbody>
                </table>
            </div>
        </div>";
    }
}