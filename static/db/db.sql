-- Usuários do sistema: cidadão comum, administrador ou empresa
CREATE TABLE usuario (
 id_usuario SERIAL PRIMARY KEY,
 nome VARCHAR(100) NOT NULL,
 email VARCHAR(100) UNIQUE NOT NULL,
 tipo VARCHAR(30) CHECK (tipo IN ('comum', 'administrador', 'empresa'))
);


-- Bicicletários: locais físicos onde bicicletas podem ser retiradas ou devolvidas
CREATE TABLE bicicletario (
 id_bicicletario SERIAL PRIMARY KEY,
 nome VARCHAR(100) NOT NULL,
 endereco TEXT NOT NULL,
 acessibilidade BOOLEAN NOT NULL DEFAULT FALSE
);


-- Pontos de ônibus da cidade
CREATE TABLE ponto_onibus (
 codigo SERIAL PRIMARY KEY,
 endereco TEXT NOT NULL,
 cobertura BOOLEAN DEFAULT FALSE,
 banco BOOLEAN DEFAULT FALSE,
 iluminacao BOOLEAN DEFAULT FALSE,
 acessibilidade BOOLEAN DEFAULT FALSE
);


-- Entidade genérica de veículos
CREATE TABLE veiculo (
 id_veiculo SERIAL PRIMARY KEY,
 tipo VARCHAR(20) NOT NULL CHECK (tipo IN ('onibus', 'bicicleta', 'moto')),
 -- Permite futuras expansões (e.g., incluir patinete)
 status VARCHAR(30) NOT NULL CHECK (status IN ('ativo', 'inativo', 'em_manutencao')),
 modelo VARCHAR(100),
 capacidade INTEGER CHECK (capacidade >= 0),
 placa VARCHAR(20) UNIQUE,
 quilometragem INTEGER CHECK (quilometragem >= 0)
);


-- Itinerários de ônibus (nome apenas, pontos virão em tabela associativa)
CREATE TABLE itinerario (
 id_itinerario SERIAL PRIMARY KEY,
 nome VARCHAR(100) NOT NULL
);


-- Especialização de veiculos
CREATE TABLE onibus (
 id_veiculo INTEGER PRIMARY KEY REFERENCES veiculo(id_veiculo),
 acessibilidade BOOLEAN,
 ar_condicionado BOOLEAN,
 wifi BOOLEAN,
 cameras BOOLEAN,
 id_itinerario INTEGER REFERENCES itinerario(id_itinerario)
 -- Cada ônibus está vinculado a um itinerário
);


-- Especialização de veiculos
CREATE TABLE bicicleta (
 id_veiculo INTEGER PRIMARY KEY REFERENCES veiculo(id_veiculo),
 numero_serie VARCHAR(50) NOT NULL UNIQUE,
 bateria INTEGER CHECK (bateria BETWEEN 0 AND 100),
 -- Representa o nível da bateria (se for elétrica)
 peso_maximo NUMERIC CHECK (peso_maximo > 0)
);


-- Representa os pontos por onde um itinerário passa, com horários definidos
CREATE TABLE itinerario_ponto (
 id_itinerario_ponto SERIAL PRIMARY KEY,
 nome VARCHAR(100) NOT NULL,
 hora_inicio TIME NOT NULL,
 hora_fim TIME NOT NULL,
 gap INTERVAL,
 -- Intervalo entre passagens, útil para cálculos de frequência
 dia VARCHAR(15) CHECK (dia IN ('segunda', 'terca', 'quarta', 'quinta', 'sexta', 'sabado', 'domingo')),
 id_itinerario INTEGER NOT NULL REFERENCES itinerario(id_itinerario),
 codigo_ponto INTEGER NOT NULL REFERENCES ponto_onibus(codigo)
 -- Relacionamento N:N resolvido por essa tabela com dados adicionais
);


-- Tabela associativa que relaciona itinerário e ônibus, registrando a quantidade de passageiros
CREATE TABLE passageiros_viagem (
 id_itinerario INTEGER,
 id_veiculo INTEGER,
 quantidade INTEGER CHECK (quantidade >= 0),
 PRIMARY KEY (id_itinerario, id_veiculo),
 FOREIGN KEY (id_itinerario) REFERENCES itinerario(id_itinerario),
 FOREIGN KEY (id_veiculo) REFERENCES veiculo(id_veiculo)
 -- Uso de chave composta por se tratar de uma relação N:N com dado agregado
);


-- Registros de manutenção dos veículos
CREATE TABLE manutencao (
 id_manutencao SERIAL PRIMARY KEY,
 id_veiculo INTEGER NOT NULL REFERENCES veiculo(id_veiculo),
 tipo VARCHAR(50) NOT NULL CHECK (tipo IN ('elétrico', 'mecânico', 'funilaria')),
 -- Controle do tipo facilita triagem e relatórios de manutenção
 data DATE NOT NULL,
 status VARCHAR(30) CHECK (status IN ('pendente', 'concluida', 'cancelada', 'em_andamento')),
 descricao TEXT
);


-- Registro de aluguéis feitos por usuários de bicicletas
CREATE TABLE aluguel (
 id_aluguel SERIAL PRIMARY KEY,
 id_usuario INTEGER NOT NULL REFERENCES usuario(id_usuario),
 id_veiculo INTEGER NOT NULL REFERENCES veiculo(id_veiculo),
 id_bicicletario_retirada INTEGER NOT NULL REFERENCES bicicletario(id_bicicletario),
 id_bicicletario_devolucao INTEGER REFERENCES bicicletario(id_bicicletario),
 horario_retirada TIMESTAMP NOT NULL,
 horario_devolucao TIMESTAMP,
 CHECK (horario_devolucao IS NULL OR horario_devolucao >= horario_retirada)
 -- Garantia de integridade temporal no aluguel
);
