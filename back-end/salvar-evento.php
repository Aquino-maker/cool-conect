<?php
session_start();
include('/laragon/www/Preparacao-para-ADE/back-end/conexao.php');

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_org = $_POST['id_org'] ?? null;
    $name_event = trim($_POST['name_event'] ?? '');
    $description_event = trim($_POST['description_event'] ?? '');
    $start_date_event = $_POST['start_date_event'] ?? null;
    $end_date = $_POST['end_date'] ?? null;
    $event_location = trim($_POST['event_location'] ?? null);
    $address_event = trim($_POST['address_event'] ?? null);
    $city = trim($_POST['city'] ?? null);
    $event_type = $_POST['event_type'] ?? 'Presencial';
    $capacity = !empty($_POST['capacity']) ? (int)$_POST['capacity'] : null;
    $price = !empty($_POST['price']) ? (float)$_POST['price'] : 0.00;

    // Validação básica
    if (empty($id_org) || empty($name_event) || empty($start_date_event)) {
        echo "Por favor, preencha os campos obrigatórios: título e data de início.";
        exit;
    }

    // Preparar e executar inserção
    $sql = "INSERT INTO eventos 
        (id_org, name_event, description_event, start_date_event, end_date, event_location, address_event, city, event_type, capacity, price)
        VALUES
        (:id_org, :name_event, :description_event, :start_date_event, :end_date, :event_location, :address_event, :city, :event_type, :capacity, :price)";

    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute([
        // ':id_org' => $id_org,
        ':name_event' => $name_event,
        ':description_event' => $description_event,
        ':start_date_event' => $start_date_event,
        ':end_date' => $end_date,
        ':event_location' => $event_location,
        ':address_event' => $address_event,
        ':city' => $city,
        ':event_type' => $event_type,
        ':capacity' => $capacity,
        ':price' => $price,
    ]);

    if ($result) {
        header("Location: ../pagina-inicial.php");
        exit;
    } else {
        echo "Erro ao criar o evento.";
    }
} else {
    echo "Acesso inválido.";
}