<?php

include('/laragon/www/Preparacao-para-ADE/back-end/conexao.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name_user = trim($_POST['name_user'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $pass = $_POST['pass'] ?? '';

    // Abaixo verifica se já tem alguma pessoa utilizando o email ou username.
    $check = $pdo->prepare("SELECT id_user FROM usuarios WHERE username = :username OR email = :email");
    $check->bindParam(':username', $username);
    $check->bindParam(':email', $email);
    $check->execute();

    if ($check->rowCount() > 0) {
        echo json_encode(["status" => "erro", "mensagem" => "Usuário ou e-mail já cadastrados."]);
        exit;
    }
    $hashedPassword = password_hash($pass, PASSWORD_DEFAULT); // Serve para criptografar a senha

    $sql = "INSERT INTO usuarios (name_user, username, email, pass) VALUES (:name_user, :username, :email, :pass)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':name_user', $name_user);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':pass', $hashedPassword);

    if ($stmt->execute()) {
        echo json_encode(["status" => "sucesso", "mensagem" => "Usuário cadastrado com sucesso!"]);
    } else {
        echo json_encode(["status" => "erro", "mensagem" => "Erro ao cadastrar usuário."]);
    }
} else {
    echo json_encode(["status" => "erro", "mensagem" => "Método inválido. Use POST."]);
}
