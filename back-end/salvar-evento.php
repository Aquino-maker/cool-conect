<?php
session_start();
include('/laragon/www/Preparacao-para-ADE/back-end/conexao.php');

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_user = $_SESSION['usuario']['id_user'];

    $stmtOrg = $pdo->prepare("SELECT id_org FROM organizadores WHERE id_user = ?");
    $stmtOrg->execute([$id_user]);
    $org = $stmtOrg->fetch(PDO::FETCH_ASSOC);

    if (!$org) {
        echo "Organizador não encontrado.";
        exit;
    }

    $id_org = $org['id_org'];
    $name_event = trim($_POST['name_event'] ?? '');
    $description_event = trim($_POST['description_event'] ?? '');
    $start_date_event = $_POST['start_date_event'] ?? null;
    $end_date = $_POST['end_date'] ?? null;
    $event_location = trim($_POST['event_location'] ?? '');
    $address_event = trim($_POST['address_event'] ?? '');
    $city = trim($_POST['city'] ?? '');
    $event_type = $_POST['event_type'] ?? 'Presencial';
    $capacity = !empty($_POST['capacity']) ? (int)$_POST['capacity'] : null;
    $price = !empty($_POST['price']) ? (float)$_POST['price'] : 0.00;

    // Processar upload da imagem
    $imagePath = null;

    if (isset($_FILES['image_event']) && $_FILES['image_event']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '/laragon/www/Preparacao-para-ADE/uploads/';
        $uploadWebPath = '/Preparacao-para-ADE/uploads/';

        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $fileTmp = $_FILES['image_event']['tmp_name'];
        $fileName = uniqid() . '-' . basename($_FILES['image_event']['name']);
        $filePath = $uploadDir . $fileName;

        if (move_uploaded_file($fileTmp, $filePath)) {
            $imagePath = $uploadWebPath . $fileName;
        } else {
            echo "Erro ao salvar a imagem.";
            exit;
        }
    }

    // Inserção no banco
    $sql = "INSERT INTO eventos 
        (id_org, name_event, description_event, start_date_event, end_date, event_location, address_event, city, event_type, capacity, price, image_event)
        VALUES
        (:id_org, :name_event, :description_event, :start_date_event, :end_date, :event_location, :address_event, :city, :event_type, :capacity, :price, :image_event)";

    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute([
        ':id_org' => $id_org,
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
        ':image_event' => $imagePath
    ]);

    if ($result) {
        header("Location: ../front-end/pagina-inicial.php");
        exit;
    } else {
        echo "Erro ao criar o evento.";
    }
} else {
    echo "Acesso inválido.";
}
