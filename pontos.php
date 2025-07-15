<?php
require_once 'model/model.php';
session_start();

// Não redireciona mais se o usuário não estiver logado.
// A visibilidade dos botões será controlada na view.

$is_admin = (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'administrador');

$alert_message = '';
$alert_type = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['addPonto'])) {
    if (!$is_admin) {
        $alert_message = "Acesso negado: Você não tem permissão para cadastrar pontos.";
        $alert_type = "danger";
    } else {
        $endereco = $_POST['endereco'];
        $cobertura = isset($_POST['cobertura']) ? 't' : 'f';
        $banco = isset($_POST['banco']) ? 't' : 'f';
        $iluminacao = isset($_POST['iluminacao']) ? 't' : 'f';
        $acessibilidade = isset($_POST['acessibilidade']) ? 't' : 'f';

        $result = addPontoOnibus($endereco, $cobertura, $banco, $iluminacao, $acessibilidade);

        if ($result) {
            $alert_message = "Ponto de ônibus cadastrado com sucesso!";
            $alert_type = "success";
        } else {
            $alert_message = "Erro ao cadastrar ponto de ônibus: " . pg_last_error(connect()); // Adiciona o erro do PG para debug
            $alert_type = "danger";
        }
    }
}

$search_term = $_GET['search'] ?? '';
if (!empty($search_term)) {
    $pontosResult = searchPontosOnibus($search_term);
} else {
    $pontosResult = getAllPontosOnibus();
}

$pontos = [];
if ($pontosResult) {
    while ($row = pg_fetch_assoc($pontosResult)) { // Usar pg_fetch_assoc para PostgreSQL
        $pontos[] = $row;
    }
}

require_once 'visual/pontos.php';
?>