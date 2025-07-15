<?php
require_once 'model/model.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'administrador') {
    header("Location: login.php?alert=" . urlencode("Acesso negado: Você não tem permissão para excluir veículos."));
    exit;
}

if (isset($_GET['id'])) {
    $veiculo_id = intval($_GET['id']);

    if ($veiculo_id > 0) {
        $result = deleteVeiculo($veiculo_id);

        if ($result) {
            header("Location: veiculos.php?alert=" . urlencode("Veículo excluído com sucesso!"));
            exit;
        } else {
            header("Location: veiculos.php?alert=" . urlencode("Erro ao excluir veículo."));
            exit;
        }
    } else {
        header("Location: veiculos.php?alert=" . urlencode("ID de veículo inválido."));
        exit;
    }
} else {
    header("Location: veiculos.php?alert=" . urlencode("Nenhum ID de veículo fornecido para exclusão."));
    exit;
}
