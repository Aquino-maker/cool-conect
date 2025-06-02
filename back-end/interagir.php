<?php
session_start();

include('/laragon/www/Preparacao-para-ADE/back-end/conexao.php');

if (!isset($_SESSION['usuario'])) {
    header("Location: /Preparacao-para-ADE/front-end/login.php");
    exit;
}

$id_user = $_SESSION['usuario']['id'] ?? null;
$id_event = $_POST['id_event'] ?? null;
$tipo = $_POST['tipo'] ?? null;

$tipos_validos = ['like', 'subscribe', 'favorite'];

if (!$id_user || !$id_event || !in_array($tipo, $tipos_validos)) {
    header("Location: /Preparacao-para-ADE/front-end/pagina-inicial.php?erro=parametros_invalidos");
    exit;
}

try {
    $verifica = $pdo->prepare("SELECT * FROM interacoes WHERE id_user = :id_user AND id_event = :id_event AND tipo = :tipo");
    $verifica->execute([
        ':id_user' => $id_user,
        ':id_event' => $id_event,
        ':tipo' => $tipo
    ]);

    if ($verifica->rowCount() === 0) {
        $inserir = $pdo->prepare("INSERT INTO interacoes (id_user, id_event, tipo) VALUES (:id_user, :id_event, :tipo)");
        $inserir->execute([
            ':id_user' => $id_user,
            ':id_event' => $id_event,
            ':tipo' => $tipo
        ]);
    }

    header("Location: /Preparacao-para-ADE/front-end/pagina-inicial.php");
    exit;

} catch (PDOException $e) {
    header("Location: /Preparacao-para-ADE/pagina-inicial.php?erro=bd");
    exit;
}