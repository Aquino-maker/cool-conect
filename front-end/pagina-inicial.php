<?php
session_start();
include('/laragon/www/Preparacao-para-ADE/back-end/conexao.php');

if (!isset($_SESSION['usuario'])) {
  header("Location: login.php");
  exit;
}

$id_user = $_SESSION['usuario']['id_user'];
$name_user = $_SESSION['usuario']['name_user'];

// Buscar todos os eventos e suas interações
$sql = "
    SELECT 
        e.*, 
        COALESCE(SUM(i.tipo = 'like'), 0) AS likes,
        COALESCE(SUM(i.tipo = 'subscribe'), 0) AS subscribes,
        COALESCE(SUM(i.tipo = 'favorite'), 0) AS favorites
    FROM eventos e
    LEFT JOIN interacoes i ON e.id_event = i.id_event
    GROUP BY e.id_event
    ORDER BY e.start_date_event ASC
";
$stmt = $pdo->query($sql);
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
    <h1>Local Connect</h1>

    <div style="display: flex; gap: 10px; align-items: center;">
      <form action="criar-evento.php" method="get">
        <button type="submit" class="perfil-icon" title="Criar Evento">
          <i class="fas fa-plus-circle"></i>
        </button>
      </form>

    </div>
  </header>

  <main class="feed">

    <h2>Bem-vindo, <?= htmlspecialchars($name_user) ?>!</h2>

    <?php if (count($eventos) === 0): ?>
      <p>Nenhum evento disponível no momento.</p>
    <?php else: ?>
      <?php foreach ($eventos as $evento): ?>
        <div class="card-evento">
          <?php if (!empty($evento['image_event'])): ?>
            <img class="imagem-evento" src="<?= htmlspecialchars($evento['image_event']) ?>" alt="Imagem do evento" />
          <?php endif; ?>

          <h2><?= htmlspecialchars($evento['name_event']) ?></h2>
          <p><?= nl2br(htmlspecialchars($evento['description_event'])) ?></p>
          <p><strong>Data:</strong> <?= date('d/m/Y H:i', strtotime($evento['start_date_event'])) ?></p>
          <p><strong>Local:</strong> <?= htmlspecialchars($evento['event_location']) ?> (<?= htmlspecialchars($evento['city']) ?>)</p>
          <p><strong>Tipo:</strong> <?= htmlspecialchars($evento['event_type']) ?></p>
          <p><strong>Capacidade:</strong> <?= htmlspecialchars($evento['capacity']) ?></p>
          <p><strong>Preço:</strong> R$ <?= number_format($evento['price'], 2, ',', '.') ?></p>


          <div class="interacoes">
            <form method="POST" action="../back-end/interagir.php">
              <input type="hidden" name="id_event" value="<?= $evento['id_event'] ?>">
              <input type="hidden" name="tipo" value="like">
              <button type="submit">👍 Curtir (<?= $evento['likes'] ?>)</button>
            </form>

            <form method="POST" action="../back-end/interagir.php">
              <input type="hidden" name="id_event" value="<?= $evento['id_event'] ?>">
              <input type="hidden" name="tipo" value="subscribe">
              <button type="submit">🔔 Inscrever-se (<?= $evento['subscribes'] ?>)</button>
            </form>

            <form method="POST" action="../back-end/interagir.php">
              <input type="hidden" name="id_event" value="<?= $evento['id_event'] ?>">
              <input type="hidden" name="tipo" value="favorite">
              <button type="submit">⭐ Favoritar (<?= $evento['favorites'] ?>)</button>
            </form>
          </div>

          <!-- Comentários -->
          <div class="comentarios">
            <h3>Comentários</h3>

            <?php
            $stmtComentarios = $pdo->prepare("
                            SELECT c.*, u.name_user
                            FROM comentarios c
                            JOIN usuarios u ON c.id_user = u.id_user
                            WHERE c.id_event = ?
                            ORDER BY c.created_at DESC
                        ");
            $stmtComentarios->execute([$evento['id_event']]);
            $comentarios = $stmtComentarios->fetchAll(PDO::FETCH_ASSOC);
            ?>

            <?php if (count($comentarios) > 0): ?>
              <?php foreach ($comentarios as $comentario): ?>
                <div class="comentario-item">
                  <strong><?= htmlspecialchars($comentario['name_user']) ?>:</strong>
                  <p><?= nl2br(htmlspecialchars($comentario['content'])) ?></p>
                  <small><?= date('d/m/Y H:i', strtotime($comentario['created_at'])) ?></small>
                </div>
              <?php endforeach; ?>
            <?php else: ?>
              <p style="color: #ccc;">Nenhum comentário ainda. Seja o primeiro!</p>
            <?php endif; ?>

            <form method="POST" action="../back-end/comentar.php" class="comentario-form">
              <input type="hidden" name="id_event" value="<?= $evento['id_event'] ?>">
              <textarea name="content" rows="3" placeholder="Deixe um comentário..." required></textarea>
              <button type="submit">Comentar</button>
            </form>
          </div>


        </div>
      <?php endforeach; ?>
    <?php endif; ?>

  </main>

</body>

</html>