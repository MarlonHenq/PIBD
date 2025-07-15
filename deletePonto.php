<?php
require_once 'model/model.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'administrador') {
    header("Location: login.php?alert=" . urlencode("Acesso negado: Você não tem permissão para excluir pontos."));
    exit;
}

if (isset($_GET['id'])) {
    $ponto_codigo = intval($_GET['id']);

    if ($ponto_codigo > 0) {
        $result = deletePonto($ponto_codigo);

        if ($result) {
            header("Location: pontos.php?alert=" . urlencode("Ponto de ônibus excluído com sucesso!"));
            exit;
        } else {
            header("Location: pontos.php?alert=" . urlencode("Erro ao excluir ponto de ônibus."));
            exit;
        }
    } else {
        header("Location: pontos.php?alert=" . urlencode("ID de ponto inválido."));
        exit;
    }
} else {
    header("Location: pontos.php?alert=" . urlencode("Nenhum ID de ponto fornecido para exclusão."));
    exit;
}
