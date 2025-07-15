<?php
require_once 'model/model.php';
session_start();

$is_admin = (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'administrador');

$alert_message = '';
$alert_type = '';

// add se for adm
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['addItinerario'])) {
    if (!$is_admin) {
        $alert_message = "Acesso negado: Você não tem permissão para cadastrar itinerários.";
        $alert_type = "danger";
    } else {
        $nome = $_POST['nome'];
        // $descricao = $_POST['descricao'];

        $result = addItinerario($nome);

        if ($result) {
            $alert_message = "Itinerário cadastrado com sucesso!";
            $alert_type = "success";
        } else {
            $alert_message = "Erro ao cadastrar itinerário: " . pg_last_error(connect());
            $alert_type = "danger";
        }
    }
}

// buscar
$search_term = $_GET['search'] ?? '';
if (!empty($search_term)) {
    $itinerariosResult = searchItinerarios($search_term);
} else {
    $itinerariosResult = getAllItinerariosWithDetails();
}

$itinerarios = [];
if ($itinerariosResult) {
    while ($row = pg_fetch_assoc($itinerariosResult)) {
        $row['pontos_parada_enderecos'] = !empty($row['pontos_parada_enderecos']) ? explode(',', trim($row['pontos_parada_enderecos'], '{}')) : [];
        $itinerarios[] = $row;
    }
}

require_once 'visual/itinerarios.php';
?>