<?php
require_once 'model/model.php';
session_start();

if (isset($_GET["alert"])) {
    echo "<script>alert('" . $_GET["alert"] . "')</script>";
    echo "<script>window.location.href = 'login.php'</script>";
    exit;
}

if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $captcha_resposta = $_POST['captcha'];

    if ($captcha_resposta != '4') { // Captcha: 2 + 2 = 4
        $mensagem = urlencode("Resposta do Captcha incorreta!");
        header("Location: login.php?alert=$mensagem");
        exit;
    }

    $result = loginUser($email);

if ($result && pg_num_rows($result) > 0) {
    $user = pg_fetch_assoc($result);

    $_SESSION['user_id'] = $user['id_usuario'];
    $_SESSION['username'] = $user['nome'];
    $_SESSION['user_type'] = $user['tipo'];

    header("Location: index.php");
    } else {
        $mensagem = urlencode("Email não encontrado ou inválido.");
        header("Location: login.php?alert=$mensagem");
    }   
}

require_once 'visual/login.php';
