<?php
session_start();
include('/laragon/www/Preparacao-para-ADE/back-end/conexao.php');

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}

$id_usuario = $_SESSION['usuario']['id_user'];

$stmt = $pdo->prepare("SELECT * FROM organizadores WHERE id_user = ?");
$stmt->execute([$id_usuario]);
$jaOrganizador = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['name_fugleman'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $tipo = $_POST['type_org'] ?? 'Pessoa Física';

    if ($jaOrganizador) {
        echo "Você já é um organizador.";
        exit;
    }

    if (empty($nome) || empty($email) || empty($phone)) {
        echo "Preencha todos os campos.";
        exit;
    }

    $sql = "INSERT INTO organizadores (id_user, name_fugleman, email, phone, type_org)
            VALUES (:id_user, :name_fugleman, :email, :phone, :type_org)";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':id_user' => $id_usuario,
        ':name_fugleman' => $nome,
        ':email' => $email,
        ':phone' => $phone,
        ':type_org' => $tipo
    ]);

    echo "Cadastro de organizador realizado com sucesso! <a href='criar-evento.php'>Criar evento agora</a>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Torne-se um Organizador</title>
    <link rel="stylesheet" href="src/form.css">
</head>
<body>
    <h1>Torne-se um Organizador</h1>

    <?php if ($jaOrganizador): ?>
        <p>Você já é um organizador. <a href="criar-evento.php">Criar evento</a></p>
    <?php else: ?>
        <form method="POST">
            <label for="name_fugleman">Nome do Organizador:</label>
            <input type="text" name="name_fugleman" id="name_fugleman" required>

            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required>

            <label for="phone">Telefone:</label>
            <input type="text" name="phone" id="phone" required>

            <label for="type_org">Tipo:</label>
            <select name="type_org" id="type_org">
                <option value="Pessoa Física">Pessoa Física</option>
                <option value="Empresa">Empresa</option>
            </select>

            <button type="submit">Cadastrar</button>
        </form>
    <?php endif; ?>
</body>
</html>