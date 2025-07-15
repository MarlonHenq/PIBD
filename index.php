<?php
require_once 'model/model.php';
session_start();

$pontos_cadastrados = countPontosCadastrados();
$linhas_ativas = countLinhasAtivas();
$veiculos_registrados = countVeiculosRegistrados();
$rotas_configuradas = countRotasConfiguradas();

require_once 'visual/index.php'; 
