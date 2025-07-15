<?php

$db_host = '';
$db_user = '';
$db_pass = '';
$db_name = '';

function connect() {
    global $db_host, $db_user, $db_pass, $db_name;
    $conn_string = "host=$db_host dbname=$db_name user=$db_user password=$db_pass";
    $conn = pg_connect($conn_string);

    if (!$conn) {
        die("Erro de conexão com o PostgreSQL: " . pg_last_error());
    }

    return $conn;
}

function setUser($nome, $email, $tipo) {
    $conn = connect();
    $query = "INSERT INTO usuario (nome, email, tipo) VALUES (" . pg_escape_literal($conn, $nome) . ", " . pg_escape_literal($conn, $email) . ", " . pg_escape_literal($conn, $tipo) . ")";
    $result = pg_query($conn, $query);
    pg_close($conn);
    return $result;
}

function getUserByEmail($email) {
    $conn = connect();
    $query = "SELECT * FROM usuario WHERE email = " . pg_escape_literal($conn, $email);
    $result = pg_query($conn, $query);
    pg_close($conn);
    return $result;
}

function loginUser($email) {
    $conn = connect();
    $query = "SELECT id_usuario, nome, email, tipo FROM usuario WHERE email = " . pg_escape_literal($conn, $email);
    $result = pg_query($conn, $query);
    pg_close($conn);
    return $result;
}

function getAllVeiculos() {
    $conn = connect();
    $query = "SELECT * FROM veiculo";
    $result = pg_query($conn, $query);
    pg_close($conn);
    return $result;
}

function registerRental($id_usuario, $id_veiculo, $id_bicicletario_retirada) {
    $conn = connect();
    $query = "SELECT pr_register_rental($1, $2, $3)";
    $result = pg_query_params($conn, $query, array($id_usuario, $id_veiculo, $id_bicicletario_retirada));

    if (!$result) {
        error_log("Erro ao executar a procedure: " . pg_last_error($conn));
        pg_close($conn);
        return false;
    }
    pg_close($conn);
    return true;
}

function getAllBicicletarios() {
    $conn = connect();
    $query = "SELECT id_bicicletario, nome FROM bicicletario";
    $result = pg_query($conn, $query);
    pg_close($conn);
    return $result;
}

// Funções de Dashboard
function countPontosCadastrados() {
    $conn = connect();
    $query = "SELECT COUNT(*) FROM ponto_onibus";
    $result = pg_query($conn, $query);
    if ($result) {
        $row = pg_fetch_row($result);
        pg_close($conn);
        return $row[0];
    }
    pg_close($conn);
    return 0;
}

function countLinhasAtivas() {
    $conn = connect();
    $query = "SELECT COUNT(*) FROM itinerario";
    $result = pg_query($conn, $query);
    if ($result) {
        $row = pg_fetch_row($result);
        pg_close($conn);
        return $row[0];
    }
    pg_close($conn);
    return 0;
}

function countVeiculosRegistrados() {
    $conn = connect();
    $query = "SELECT COUNT(*) FROM veiculo";
    $result = pg_query($conn, $query);
    if ($result) {
        $row = pg_fetch_row($result);
        pg_close($conn);
        return $row[0];
    }
    pg_close($conn);
    return 0;
}

function countRotasConfiguradas() {
    $conn = connect();
    $query = "SELECT COUNT(*) FROM itinerario_ponto";
    $result = pg_query($conn, $query);
    if ($result) {
        $row = pg_fetch_row($result);
        pg_close($conn);
        return $row[0];
    }
    pg_close($conn);
    return 0;
}

// Funções para Pontos de Ônibus
function getAllPontosOnibus() {
    $conn = connect();
    $query = "SELECT codigo, endereco, cobertura, banco, iluminacao, acessibilidade FROM ponto_onibus ORDER BY codigo DESC"; // Ordenado pelo código, ajuste se tiver outra preferência
    $result = pg_query($conn, $query);
    pg_close($conn);
    return $result;
}

function searchPontosOnibus($searchTerm) {
    $conn = connect();
    $searchTerm = pg_escape_literal($conn, '%' . $searchTerm . '%');
    $query = "SELECT codigo, endereco, cobertura, banco, iluminacao, acessibilidade FROM ponto_onibus WHERE endereco ILIKE $searchTerm ORDER BY codigo DESC";
    $result = pg_query($conn, $query);
    pg_close($conn);
    return $result;
}

function addPontoOnibus($endereco, $cobertura, $banco, $iluminacao, $acessibilidade) {
    $conn = connect();
    $query = "INSERT INTO ponto_onibus (endereco, cobertura, banco, iluminacao, acessibilidade) VALUES ($1, $2, $3, $4, $5)";
    $params = array($endereco, $cobertura, $banco, $iluminacao, $acessibilidade);
    $result = pg_query_params($conn, $query, $params);
    pg_close($conn);
    return $result;
}

function deletePonto($codigo) {
    $conn = connect();
    $query = "DELETE FROM ponto_onibus WHERE codigo = $1";
    $result = pg_query_params($conn, $query, array($codigo));
    pg_close($conn);
    return $result;
}

// VEICULOS
function getAllVeiculosWithDetails() {
    $conn = connect();
    $query = "
        SELECT
            v.id_veiculo,
            v.tipo,
            v.status,
            v.modelo,
            v.capacidade,
            v.placa,
            v.quilometragem,
            o.acessibilidade AS onibus_acessibilidade,
            o.ar_condicionado,
            o.wifi,
            o.cameras,
            i.nome AS itinerario_nome,
            i.id_itinerario
        FROM
            veiculo v
        LEFT JOIN
            onibus o ON v.id_veiculo = o.id_veiculo AND v.tipo = 'onibus'
        LEFT JOIN
            itinerario i ON o.id_itinerario = i.id_itinerario
        ORDER BY
            v.id_veiculo DESC
    ";
    $result = pg_query($conn, $query);
    pg_close($conn);
    return $result;
}

function searchVeiculos($searchTerm) {
    $conn = connect();
    $searchTerm = pg_escape_literal($conn, '%' . $searchTerm . '%');
    $query = "
        SELECT
            v.id_veiculo,
            v.tipo,
            v.status,
            v.modelo,
            v.capacidade,
            v.placa,
            v.quilometragem,
            o.acessibilidade AS onibus_acessibilidade,
            o.ar_condicionado,
            o.wifi,
            o.cameras,
            i.nome AS itinerario_nome,
            i.id_itinerario
        FROM
            veiculo v
        LEFT JOIN
            onibus o ON v.id_veiculo = o.id_veiculo AND v.tipo = 'onibus'
        LEFT JOIN
            itinerario i ON o.id_itinerario = i.id_itinerario
        WHERE
            v.placa ILIKE $searchTerm OR v.modelo ILIKE $searchTerm OR i.nome ILIKE $searchTerm
        ORDER BY
            v.id_veiculo DESC
    ";
    $result = pg_query($conn, $query);
    pg_close($conn);
    return $result;
}

function addOnibus($modelo, $capacidade, $placa, $quilometragem, $acessibilidade, $ar_condicionado, $wifi, $cameras, $id_itinerario) {
    $conn = connect();
    pg_query($conn, "BEGIN");

    $query_veiculo = "INSERT INTO veiculo (tipo, status, modelo, capacidade, placa, quilometragem) VALUES ($1, $2, $3, $4, $5, $6) RETURNING id_veiculo";
    $params_veiculo = array('onibus', 'ativo', $modelo, $capacidade, $placa, $quilometragem);
    $result_veiculo = pg_query_params($conn, $query_veiculo, $params_veiculo);

    if (!$result_veiculo) {
        pg_query($conn, "ROLLBACK");
        error_log("Erro ao inserir veículo: " . pg_last_error($conn));
        pg_close($conn);
        return false;
    }
    $row = pg_fetch_row($result_veiculo);
    $new_veiculo_id = $row[0];

    $query_onibus = "INSERT INTO onibus (id_veiculo, acessibilidade, ar_condicionado, wifi, cameras, id_itinerario) VALUES ($1, $2, $3, $4, $5, $6)";
    $params_onibus = array($new_veiculo_id, $acessibilidade, $ar_condicionado, $wifi, $cameras, $id_itinerario);
    $result_onibus = pg_query_params($conn, $query_onibus, $params_onibus);

    if (!$result_onibus) {
        pg_query($conn, "ROLLBACK");
        error_log("Erro ao inserir detalhes do ônibus: " . pg_last_error($conn));
        pg_close($conn);
        return false;
    }

    pg_query($conn, "COMMIT");
    pg_close($conn);
    return true;
}

function deleteVeiculo($id_veiculo) {
    $conn = connect();
    pg_query($conn, "BEGIN"); 

    $query_delete_onibus = "DELETE FROM onibus WHERE id_veiculo = $1";
    $result_onibus = pg_query_params($conn, $query_delete_onibus, array($id_veiculo));

    if (!$result_onibus) {
        pg_query($conn, "ROLLBACK");
        error_log("Erro ao deletar detalhes do ônibus: " . pg_last_error($conn));
        pg_close($conn);
        return false;
    }

    $query_delete_veiculo = "DELETE FROM veiculo WHERE id_veiculo = $1";
    $result_veiculo = pg_query_params($conn, $query_delete_veiculo, array($id_veiculo));

    if (!$result_veiculo) {
        pg_query($conn, "ROLLBACK");
        error_log("Erro ao deletar veículo: " . pg_last_error($conn));
        pg_close($conn);
        return false;
    }

    pg_query($conn, "COMMIT");
    pg_close($conn);
    return true;
}

function getAllItinerarios() {
    $conn = connect();
    $query = "SELECT id_itinerario, nome FROM itinerario ORDER BY nome";
    $result = pg_query($conn, $query);
    pg_close($conn);
    return $result;
}

// Funções para Itinerários
function getAllItinerariosWithDetails() {
    $conn = connect();
    $query = "
        SELECT
            i.id_itinerario,
            i.nome,
            ARRAY_AGG(po.endereco ORDER BY ip.codigo_ponto) AS pontos_parada_enderecos
        FROM
            itinerario i
        LEFT JOIN
            itinerario_ponto ip ON i.id_itinerario = ip.id_itinerario
        LEFT JOIN
            ponto_onibus po ON ip.codigo_ponto = po.codigo
        GROUP BY
            i.id_itinerario, i.nome
        ORDER BY
            i.nome ASC
    ";
    $result = pg_query($conn, $query);
    pg_close($conn);
    return $result;
}

function searchItinerarios($searchTerm) {
    $conn = connect();
    $searchTerm = pg_escape_literal($conn, '%' . $searchTerm . '%');
    $query = "
        SELECT
            i.id_itinerario,
            i.nome,
            ARRAY_AGG(po.endereco ORDER BY ip.codigo_ponto) AS pontos_parada_enderecos
        FROM
            itinerario i
        LEFT JOIN
            itinerario_ponto ip ON i.id_itinerario = ip.id_itinerario
        LEFT JOIN
            ponto_onibus po ON ip.codigo_ponto = po.codigo
        WHERE
            i.nome ILIKE $searchTerm
        GROUP BY
            i.id_itinerario, i.nome
        ORDER BY
            i.nome ASC
    ";
    $result = pg_query($conn, $query);
    pg_close($conn);
    return $result;
}

function addItinerario($nome) { 
    $conn = connect();
    $query = "INSERT INTO itinerario (nome) VALUES ($1) RETURNING id_itinerario";
    $params = array($nome);
    $result = pg_query_params($conn, $query, $params);
    pg_close($conn);
    return $result;
}

function deleteItinerario($id_itinerario) {
    $conn = connect();
    pg_query($conn, "BEGIN");

    // 1. Deletar as paradas associadas a este itinerário na tabela itinerario_ponto
    $query_delete_paradas = "DELETE FROM itinerario_ponto WHERE id_itinerario = $1";
    $result_paradas = pg_query_params($conn, $query_delete_paradas, array($id_itinerario));

    if (!$result_paradas) {
        pg_query($conn, "ROLLBACK");
        error_log("Erro ao deletar paradas do itinerário: " . pg_last_error($conn));
        pg_close($conn);
        return false;
    }

    // 2. Deletar o itinerário da tabela itinerario
    $query_delete_itinerario = "DELETE FROM itinerario WHERE id_itinerario = $1";
    $result_itinerario = pg_query_params($conn, $query_delete_itinerario, array($id_itinerario));

    if (!$result_itinerario) {
        pg_query($conn, "ROLLBACK");
        error_log("Erro ao deletar itinerário: " . pg_last_error($conn));
        pg_close($conn);
        return false;
    }

    pg_query($conn, "COMMIT");
    pg_close($conn);
    return true;
}