<?php

include('/laragon/www/Preparacao-para-ADE/back-end/conexao.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = $_POST['user'] ?? '';
    $password = $_POST['pass'] ?? '';

    if (empty($login) || empty($password)) {
        echo json_encode(["status" => "erro", "mensagem" => "Preencha todos os campos."]);
        exit;
    }

    $sql = "SELECT * FROM usuarios WHERE email = :login OR username = :login";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':login', $login);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['pass'])) {
        echo json_encode([
            "status" => "sucesso",
            "mensagem" => "Login bem-sucedido!",
            "usuario" => [
                "id" => $user['id_user'],
                "nome" => $user['name_user'],
                "username" => $user['username'],
                "email" => $user['email']
            ]
        ]);
    } else {
        echo json_encode(["status" => "erro", "mensagem" => "Usuário ou senha inválida."]);
    }
} else {
    echo json_encode(["status" => "erro", "mensagem" => "Método inválido. Use POST."]);
}