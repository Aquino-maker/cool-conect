<?php
session_start();
include('/laragon/www/Preparacao-para-ADE/back-end/conexao.php');

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Criar Evento</title>
    <link rel="stylesheet" href="src/criar-evento.css" />
</head>

<body>
    <h1>Criar Novo Evento</h1>
    <form action="/Preparacao-para-ADE/back-end/salvar-evento.php" method="POST">

        <label for="name_event">Título:</label><br />
        <input type="text" name="name_event" id="name_event" required /><br /><br />

        <label for="description_event">Descrição:</label><br />
        <textarea name="description_event" id="description_event" rows="4" required></textarea><br /><br />

        <label for="start_date_event">Data e hora início:</label><br />
        <input type="datetime-local" name="start_date_event" id="start_date_event" required /><br /><br />

        <label for="end_date">Data e hora fim:</label><br />
        <input type="datetime-local" name="end_date" id="end_date" /><br /><br />

        <label for="event_location">Local do Evento:</label><br />
        <input type="text" name="event_location" id="event_location" /><br /><br />

        <label for="address_event">Endereço:</label><br />
        <input type="text" name="address_event" id="address_event" /><br /><br />

        <label for="city">Cidade:</label><br />
        <input type="text" name="city" id="city" /><br /><br />

        <label for="event_type">Tipo de Evento:</label><br />
        <select name="event_type" id="event_type">
            <option value="Presencial" selected>Presencial</option>
            <option value="Online">Online</option>
            <option value="Híbrido">Híbrido</option>
        </select><br /><br />

        <label for="capacity">Capacidade:</label><br />
        <input type="number" name="capacity" id="capacity" min="1" /><br /><br />

        <label for="price">Preço (R$):</label><br />
        <input type="number" name="price" id="price" min="0" step="0.01" value="0.00" /><br /><br />

        <button type="submit">Criar Evento</button>
    </form>

    <p><a href="pagina-inicial.php">Voltar ao feed</a></p>
</body>

</html>