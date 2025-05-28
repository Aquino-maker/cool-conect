<?php
include('/laragon/www/Preparacao-para-ADE/back-end/conexao.php');
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cartão - Login</title>
    <link rel="stylesheet" href="src/login.css">
</head>

<body>
    <div class="main-login">
        <div class="left-login">
            <h1>Faça seu login <br>E aproveite</h1>
            <img src="img/Connect-local-inicial.png" class="left-login-img" alt="">
        </div>
        <form action="/Preparacao-para-ADE/back-end/login.php" method="POST">
            <div class="right-login">
                <div class="card-login">
                    <h1>LOGIN</h1>
                    <div class="textfield">
                        <label for="user">Usuário</label>
                        <input type="text" name="user" id="user" placeholder="Usuário">
                    </div>
                    <div class="textfield">
                        <label for="pass">Senha</label>
                        <input type="password" name="pass" id="pass" placeholder="Senha">
                    </div>
                    <button class="btn-login">Login</button>
                    <p class="cadastro-msg">
                        <span>Não tem conta?</span> <a href="cadastre-se.php">Cadastre-se</a>
                    </p>
                </div>
            </div>
        </form>
    </div>
</body>

</html>