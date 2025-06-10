<?php
session_start();
include('conexao.php');

if (!isset($_SESSION['usuario'])) {
    header("Location: ../front-end/login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_user = $_SESSION['usuario']['id_user'];
    $id_event = $_POST['id_event'] ?? null;
    $content = trim($_POST['content'] ?? '');

    if (!$id_event || empty($content)) {
        header("Location: ../front-end/pagina-inicial.php?erro=ComentarioInvalido");
        exit;
    }

    $stmt = $pdo->prepare("INSERT INTO comentarios (id_user, id_event, content) VALUES (?, ?, ?)");
    $stmt->execute([$id_user, $id_event, $content]);

    header("Location: ../front-end/pagina-inicial.php");
    exit;
} else {
    header("Location: ../front-end/pagina-inicial.php");
    exit;
}
