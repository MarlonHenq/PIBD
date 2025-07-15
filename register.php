<?php
require_once 'model/model.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $tipo = 'comum'; // Definindo um tipo padrão

    $captcha_resposta = $_POST['captcha'];
    if ($captcha_resposta != '4') {
        echo "<script>alert('Resposta do Captcha incorreta!');</script>";
        exit;
    }

    $result = setUser($nome, $email, $tipo);

    if ($result) {
        $mensagem = urlencode("Usuário registrado com sucesso!");
        header("Location: index.php?alert=$mensagem");
        exit;
    } else {
        echo "<h2>Erro ao registrar usuário.</h2>";
    }
}

require_once 'visual/register.php';
