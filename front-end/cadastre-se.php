<?php 
include('/laragon/www/Preparacao-para-ADE/back-end/conexao.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Cadastro - LocalConnect</title>
    <link rel="stylesheet" href="src/form.css">
</head>

<body>


    <form action="/Preparacao-para-ADE/back-end/cadastro.php" method="POST">
        <div class="right-login">
            <div class="card-login">
                <h1>CADASTRO</h1>

                <div class="textfield">
                    <label for="name_user">Nome Completo</label>
                    <input type="text" name="name_user" id="name_user" required>
                </div>

                <div class="textfield">
                    <label for="username">Usuário</label>
                    <input type="text" name="username" id="username" required>
                </div>

                <div class="textfield">
                    <label for="email">E-mail</label>
                    <input type="email" name="email" id="email" required>
                </div>

                <div class="textfield">
                    <label for="pass">Senha</label>
                    <input type="password" name="pass" id="pass" required>
                </div>

                <!-- Botão para ativar os campos de organizador -->
                <button type="button" onclick="toggleOrganizador()">Deseja também se tornar um Organizador?</button>

                <!-- Campos de organizador (escondidos por padrão) -->
                <div id="organizadorFields" style="display: none; margin-top: 20px;">
                    <h3>Informações de Organizador</h3>

                    <div class="textfield">
                        <label for="name_fugleman">Nome do Representante</label>
                        <input type="text" name="name_fugleman" id="name_fugleman">
                    </div>

                    <div class="textfield">
                        <label for="org_email">E-mail do Organizador</label>
                        <input type="email" name="org_email" id="org_email">
                    </div>

                    <div class="textfield">
                        <label for="phone">Telefone</label>
                        <input type="text" name="phone" id="phone">
                    </div>

                    <div class="textfield">
                        <label for="type_org">Tipo de Organização</label>
                        <select name="type_org" id="type_org">
                            <option value="Pessoa Física">Pessoa Física</option>
                            <option value="Empresa">Empresa</option>
                        </select>
                    </div>
                </div>

                <button class="btn-login" type="submit">Cadastrar</button>

                <p class="cadastro-msg">
                    <span>Já tem conta?</span> <a href="login.php">Faça login</a>
                </p>
            </div>
        </div>
    </form>

    <script>
        function toggleOrganizador() {
            const fields = document.getElementById("organizadorFields");
            fields.style.display = fields.style.display === "none" ? "block" : "none";
        }
    </script>

</body>

</html>