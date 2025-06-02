<?php

include('/laragon/www/Preparacao-para-ADE/back-end/conexao.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name_user = trim($_POST['name_user'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $pass = $_POST['pass'] ?? '';

    if (empty($name_user) || empty($username) || empty($email) || empty($pass)) {
        echo "<script>alert('Preencha todos os campos.'); window.history.back();</script>";
        exit;
    }

    $check = $pdo->prepare("SELECT id_user FROM usuarios WHERE username = :username OR email = :email");
    $check->bindParam(':username', $username);
    $check->bindParam(':email', $email);
    $check->execute();

    if ($check->rowCount() > 0) {
        echo "<script>alert('Usuário ou e-mail já cadastrados.'); window.history.back();</script>";
        exit;
    }

    $hashedPassword = password_hash($pass, PASSWORD_DEFAULT);

    $sql = "INSERT INTO usuarios (name_user, username, email, pass) VALUES (:name_user, :username, :email, :pass)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':name_user', $name_user);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':pass', $hashedPassword);

    if ($stmt->execute()) {
        echo "<script>alert('Cadastro realizado com sucesso!'); window.location.href = '/Preparacao-para-ADE/front-end/login.php';</script>";
        exit;
    } else {
        echo "<script>alert('Erro ao cadastrar. Tente novamente.'); window.history.back();</script>";
        exit;
    }
} else {
    echo "<script>alert('Método inválido.'); window.history.back();</script>";
    exit;
}