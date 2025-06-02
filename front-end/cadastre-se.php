<?php
include('/laragon/www/Preparacao-para-ADE/back-end/conexao.php');
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Local Connect - Cadastro</title>
    <link rel="stylesheet" href="src/login.css">
</head>

<body>
    <div class="main-login">
        <div class="left-login">
            <h1>Cadastre-se <br>E aproveite</h1>
            <img src="img/Connect-local-inicial.png" class="left-login-img" alt="">
        </div>
        <form action="/Preparacao-para-ADE/back-end/cadastro.php" method="POST">
            <div class="right-login">
                <div class="card-login">
                    <h1>CADASTRO</h1>

                    <div class="textfield">
                        <label for="name_user">Nome Completo</label>
                        <input type="text" name="name_user" id="name_user" placeholder="Seu nome completo" required>
                    </div>

                    <div class="textfield">
                        <label for="username">Usuário</label>
                        <input type="text" name="username" id="username" placeholder="Usuário desejado" required>
                    </div>

                    <div class="textfield">
                        <label for="email">E-mail</label>
                        <input type="email" name="email" id="email" placeholder="Seu e-mail" required>
                    </div>

                    <div class="textfield">
                        <label for="pass">Senha</label>
                        <input type="password" name="pass" id="pass" placeholder="Senha" required>
                    </div>

                    <button class="btn-login" type="submit">Cadastrar</button>

                    <p class="cadastro-msg">
                        <span>Já tem conta?</span> <a href="login.php">Faça login</a>
                    </p>
                </div>
            </div>
        </form>
    </div>
</body>

</html>