<?php
session_start();
include('/laragon/www/Preparacao-para-ADE/back-end/conexao.php');

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}

$id_user = $_SESSION['usuario']['id_user'];
$name_user = $_SESSION['usuario']['name_user'];

// Buscar eventos com organizadores
$stmt = $pdo->query("SELECT e.*, o.name_fugleman 
                     FROM eventos e 
                     JOIN organizadores o ON e.id_org = o.id_org 
                     ORDER BY e.start_date_event DESC");
$eventos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Feed de Eventos</title>
  <link rel="stylesheet" href="src/pagina-inicial.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>

<header>
  <h1>Eventos+</h1>

  <div style="display: flex; gap: 10px; align-items: center;">
    <form action="criar-evento.php" method="get">
      <button type="submit" class="perfil-icon" title="Criar Evento">
        <i class="fas fa-plus-circle"></i>
      </button>
    </form>

    <form action="perfil.php" method="get">
      <input type="hidden" name="id" value="<?= htmlspecialchars($id_user) ?>">
      <button type="submit" class="perfil-icon" title="Meu perfil">
        <i class="fas fa-user-circle"></i>
      </button>
    </form>
  </div>
</header>

<main class="feed">
  <h2>Bem-vindo, <?= htmlspecialchars($name_user) ?>!</h2>

  <?php if (count($eventos) > 0): ?>
    <?php foreach ($eventos as $evento): ?>
      <div class="card-evento">
        <h2><?= htmlspecialchars($evento['name_event']) ?></h2>
        <p><strong>Organizador:</strong> <?= htmlspecialchars($evento['name_fugleman']) ?></p>
        <p><strong>Descrição:</strong> <?= nl2br(htmlspecialchars($evento['description_event'])) ?></p>
        <p><strong>Data:</strong> <?= date('d/m/Y H:i', strtotime($evento['start_date_event'])) ?></p>
        <p><strong>Local:</strong> <?= htmlspecialchars($evento['event_location']) ?> - <?= htmlspecialchars($evento['city']) ?></p>
        <p><strong>Tipo:</strong> <?= htmlspecialchars($evento['event_type']) ?></p>
        <p><strong>Capacidade:</strong> <?= htmlspecialchars($evento['capacity']) ?> pessoas</p>
        <p><strong>Preço:</strong> R$ <?= number_format($evento['price'], 2, ',', '.') ?></p>

        <form method="POST" action="../back-end/interagir.php">
          <input type="hidden" name="id_event" value="<?= $evento['id_event'] ?>">
          <input type="hidden" name="tipo" value="like">
          <button type="submit">👍 Curtir</button>
        </form>

        <form method="POST" action="../back-end/interagir.php">
          <input type="hidden" name="id_event" value="<?= $evento['id_event'] ?>">
          <input type="hidden" name="tipo" value="subscribe">
          <button type="submit">🔔 Inscrever-se</button>
        </form>

        <form method="POST" action="../back-end/interagir.php">
          <input type="hidden" name="id_event" value="<?= $evento['id_event'] ?>">
          <input type="hidden" name="tipo" value="favorite">
          <button type="submit">⭐ Favoritar</button>
        </form>
      </div>
    <?php endforeach; ?>
  <?php else: ?>
    <p>Nenhum evento encontrado.</p>
  <?php endif; ?>

</main>

</body>
</html>