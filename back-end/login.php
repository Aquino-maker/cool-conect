<?php
session_start();

include('/laragon/www/Preparacao-para-ADE/back-end/conexao.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = $_POST['user'] ?? '';
    $password = $_POST['pass'] ?? '';

    if (empty($login) || empty($password)) {
        $_SESSION['erro_login'] = "Preencha todos os campos.";
        header('Location: /Preparacao-para-ADE/front-end/login.php');
        exit;
    }

    $sql = "SELECT * FROM usuarios WHERE email = :login OR username = :login";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':login', $login);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['pass'])) {
        $_SESSION['usuario'] = [
            'id_user' => $user['id_user'],
            'name_user' => $user['name_user'],
            'username' => $user['username'],
            'email' => $user['email']
        ];

        header('Location: /Preparacao-para-ADE/front-end/pagina-inicial.php');
        exit;
    } else {
        $_SESSION['erro_login'] = "Usuário ou senha inválidos.";
        header('Location: /Preparacao-para-ADE/front-end/login.php');
        exit;
    }
} else {
    $_SESSION['erro_login'] = "Acesso inválido.";
    header('Location: /Preparacao-para-ADE/front-end/login.php');
    exit;
}