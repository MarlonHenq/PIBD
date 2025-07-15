<?php
require_once 'model/model.php';
session_start();

$is_admin = (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'administrador');

$alert_message = '';
$alert_type = '';

// add veiculo se adm
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['addVeiculo'])) {
    if (!$is_admin) {
        $alert_message = "Acesso negado: Você não tem permissão para cadastrar veículos.";
        $alert_type = "danger";
    } else {
        // Dados do veiculo
        $modelo = $_POST['modelo'];
        $capacidade = intval($_POST['capacidade']);
        $placa = $_POST['placa'];
        $quilometragem = intval($_POST['quilometragem']);

        // Dados do onibus
        $acessibilidade = isset($_POST['acessibilidade']) ? 't' : 'f';
        $ar_condicionado = isset($_POST['ar_condicionado']) ? 't' : 'f';
        $wifi = isset($_POST['wifi']) ? 't' : 'f';
        $cameras = isset($_POST['cameras']) ? 't' : 'f';
        $id_itinerario = intval($_POST['id_itinerario']);

        $result = addOnibus($modelo, $capacidade, $placa, $quilometragem, $acessibilidade, $ar_condicionado, $wifi, $cameras, $id_itinerario);

        if ($result) {
            $alert_message = "Veículo (Ônibus) cadastrado com sucesso!";
            $alert_type = "success";
        } else {
            $alert_message = "Erro ao cadastrar veículo (Ônibus): " . pg_last_error(connect());
            $alert_type = "danger";
        }
    }
}

// buscar
$search_term = $_GET['search'] ?? '';
if (!empty($search_term)) {
    $veiculosResult = searchVeiculos($search_term);
} else {
    $veiculosResult = getAllVeiculosWithDetails();
}

$veiculos = [];
if ($veiculosResult) {
    while ($row = pg_fetch_assoc($veiculosResult)) {
        $veiculos[] = $row;
    }
}

// buscar itinerários para o dropdown
$itinerariosResult = getAllItinerarios();
$itinerarios = [];
if ($itinerariosResult) {
    while ($row = pg_fetch_assoc($itinerariosResult)) {
        $itinerarios[] = $row;
    }
}

require_once 'visual/veiculos.php';
