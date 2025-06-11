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
    <link rel="stylesheet" href="src/criar-evento.css"/>
</head>

<body>
    <h1>Criar Novo Evento</h1>

    <!-- enctype necessário para envio de arquivos -->
    <form action="/Preparacao-para-ADE/back-end/salvar-evento.php" method="POST" enctype="multipart/form-data">

        <label for="name_event">Título:</label>
        <input type="text" name="name_event" id="name_event" required />

        <label for="description_event">Descrição:</label>
        <textarea name="description_event" id="description_event" rows="4" required></textarea>

        <label for="start_date_event">Data e hora início:</label>
        <input type="datetime-local" name="start_date_event" id="start_date_event" required />

        <label for="end_date">Data e hora fim:</label>
        <input type="datetime-local" name="end_date" id="end_date" />

        <label for="event_location">Local do Evento:</label>
        <input type="text" name="event_location" id="event_location" />

        <label for="address_event">Endereço:</label>
        <input type="text" name="address_event" id="address_event" />

        <label for="city">Cidade:</label>
        <input type="text" name="city" id="city" />

        <label for="event_type">Tipo de Evento:</label>
        <select name="event_type" id="event_type">
            <option value="Presencial" selected>Presencial</option>
            <option value="Online">Online</option>
            <option value="Híbrido">Híbrido</option>
        </select>

        <label for="capacity">Capacidade:</label>
        <input type="number" name="capacity" id="capacity" min="1" />

        <label for="price">Preço (R$):</label><br />
        <input type="number" name="price" id="price" min="0" step="0.01" value="0.00" />

        <label for="image_event">Imagem do Evento:</label>
        <input type="file" name="image_event" id="image_event" accept="image/*" />

        <button type="submit">Criar Evento</button>
    </form>

    <p><a href="pagina-inicial.php">Voltar ao feed</a></p>
</body>

</html>