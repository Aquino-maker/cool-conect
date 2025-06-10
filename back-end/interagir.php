<?php
session_start();
require_once 'conexao.php';

// Verifique a sessão da mesma forma que na página inicial
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}

$id_user = $_SESSION['usuario']['id_user'];  // Acesse o ID do usuário da mesma forma
$id_event = $_POST['id_event'] ?? null;
$tipo = $_POST['tipo'] ?? null;

if (!$id_event || !$tipo) {
    die("Dados incompletos.");
}

try {
    $sqlCheck = "SELECT * FROM interacoes WHERE id_user = :id_user AND id_event = :id_event AND tipo = :tipo";
    $stmt = $pdo->prepare($sqlCheck);
    $stmt->execute([
        ':id_user' => $id_user,
        ':id_event' => $id_event,
        ':tipo' => $tipo
    ]);

    if ($stmt->rowCount() > 0) {
        $sqlDelete = "DELETE FROM interacoes WHERE id_user = :id_user AND id_event = :id_event AND tipo = :tipo";
        $stmtDelete = $pdo->prepare($sqlDelete);
        $stmtDelete->execute([
            ':id_user' => $id_user,
            ':id_event' => $id_event,
            ':tipo' => $tipo
        ]);
    } else {
        $sqlInsert = "INSERT INTO interacoes (id_user, id_event, tipo) VALUES (:id_user, :id_event, :tipo)";
        $stmtInsert = $pdo->prepare($sqlInsert);
        $stmtInsert->execute([
            ':id_user' => $id_user,
            ':id_event' => $id_event,
            ':tipo' => $tipo
        ]);
    }

    header("Location: ../front-end/pagina-inicial.php");
    exit;

} catch (PDOException $e) {
    die("Erro: " . $e->getMessage());
}
