-- Tabela cliente
CREATE TABLE cliente (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    telefone VARCHAR(15),
    email VARCHAR(100) UNIQUE NOT NULL,
    senha VARCHAR(255) NOT NULL
);

-- Tabela servico
CREATE TABLE servico (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    descricao TEXT,
    preco DECIMAL(10, 2) NOT NULL,
    duracao TIME NOT NULL
);

-- Tabela empresa
CREATE TABLE empresa (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    cnpj VARCHAR(18) UNIQUE NOT NULL,
    telefone VARCHAR(15),
    email VARCHAR(100) UNIQUE NOT NULL
);

-- Tabela funcionario
CREATE TABLE funcionario (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    cpf VARCHAR(14) UNIQUE NOT NULL,
    endereco VARCHAR(200),
    telefone VARCHAR(15),
    email VARCHAR(100) UNIQUE NOT NULL,
    senha VARCHAR(255) NOT NULL,
    funcao VARCHAR(50),
    status BOOLEAN DEFAULT TRUE,
    empresa_id BIGINT,
    FOREIGN KEY (empresa_id) REFERENCES empresa(id) ON DELETE CASCADE
);

-- Tabela agendamento
CREATE TABLE agendamento (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    data_hora_inicio DATETIME NOT NULL,
    data_hora_final DATETIME NOT NULL,
    status ENUM('agendado', 'cancelado', 'concluido') DEFAULT 'agendado',
    data_hora_cadastro DATETIME DEFAULT CURRENT_TIMESTAMP,
    tipo VARCHAR(50),
    cliente_id BIGINT,
    servico_id BIGINT,
    funcionario_id BIGINT,
    FOREIGN KEY (cliente_id) REFERENCES cliente(id) ON DELETE CASCADE,
    FOREIGN KEY (servico_id) REFERENCES servico(id) ON DELETE CASCADE,
    FOREIGN KEY (funcionario_id) REFERENCES funcionario(id) ON DELETE CASCADE
);

-- Tabela notificacao
CREATE TABLE notificacao (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    texto TEXT NOT NULL,
    meio ENUM('email', 'sms') NOT NULL,
    status ENUM('pendente', 'enviado') DEFAULT 'pendente',
    agendamento_id BIGINT,
    FOREIGN KEY (agendamento_id) REFERENCES agendamento(id) ON DELETE CASCADE
);

-- Tabela disponibilidade inicial dos serviços
CREATE TABLE disponibilidade (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    dia_semana ENUM('segunda', 'terca', 'quarta', 'quinta', 'sexta', 'sabado', 'domingo') NOT NULL,
    horario_inicio TIME NOT NULL,
    horario_fim TIME NOT NULL,
    servico_id BIGINT,
    FOREIGN KEY (servico_id) REFERENCES servico(id) ON DELETE CASCADE
);