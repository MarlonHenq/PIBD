<?php
require_once 'model/model.php';
session_start();

// Verifica se o usuário está logado e é administrador
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'administrador') {
    header("Location: login.php?alert=" . urlencode("Acesso negado: Você não tem permissão para excluir itinerários."));
    exit;
}

if (isset($_GET['id'])) {
    $itinerario_id = intval($_GET['id']);

    if ($itinerario_id > 0) {
        $result = deleteItinerario($itinerario_id);

        if ($result) {
            header("Location: itinerarios.php?alert=" . urlencode("Itinerário excluído com sucesso!"));
            exit;
        } else {
            header("Location: itinerarios.php?alert=" . urlencode("Erro ao excluir itinerário."));
            exit;
        }
    } else {
        header("Location: itinerarios.php?alert=" . urlencode("ID de itinerário inválido."));
        exit;
    }
} else {
    header("Location: itinerarios.php?alert=" . urlencode("Nenhum ID de itinerário fornecido para exclusão."));
    exit;
}