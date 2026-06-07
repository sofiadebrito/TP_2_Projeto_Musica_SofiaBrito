<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
require_once 'db/Database.php';
$db = (new Database())->getConnection();

$query = "SELECT c.dia_data, c.hora, a.nome AS artista, p.nome AS palco 
          FROM concertos c
          JOIN artistas a ON c.artista_id = a.id
          JOIN palcos p ON c.palco_id = p.id
          ORDER BY c.dia_data ASC, c.hora ASC";
$stmt = $db->prepare($query);
$stmt->execute();
$concertos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Horário - Primavera Sound 2026</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@700;900&family=Barlow:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body { background-color: #f5f0ea; font-family: 'Barlow', sans-serif; }
        .navbar-topo { background-color: #ffffff; border-bottom: 2px solid #e0d8cf; padding: 12px 24px; display: flex; justify-content: space-between; align-items: center; }
        .logo-texto { font-family: 'Barlow Condensed', sans-serif; font-weight: 900; font-size: 1.4rem; text-transform: uppercase; line-height: 1.1; color: #111; }
        .banner { background: linear-gradient(135deg, #f72585, #f4a019, #f72585); color: white; text-align: center; padding: 18px; font-family: 'Barlow Condensed', sans-serif; font-size: 1.1rem; letter-spacing: 2px; text-transform: uppercase; }
        .titulo-principal { font-family: 'Barlow Condensed', sans-serif; font-weight: 900; font-size: 3.5rem; text-transform: uppercase; color: #111; line-height: 1; }
        .subtitulo { font-family: 'Barlow Condensed', sans-serif; font-size: 1.2rem; color: #555; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 2rem; }
        .table { background-color: #ffffff; border-radius: 8px; overflow: hidden; }
        .table thead th { background-color: #111; color: #ffffff; text-transform: uppercase; font-family: 'Barlow Condensed', sans-serif; font-size: 1rem; letter-spacing: 1px; }
        .table tbody tr:hover { background-color: #fde8f0; }
        .btn-pink { background-color: #f72585; color: white; border: none; font-family: 'Barlow Condensed', sans-serif; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; }
        .btn-pink:hover { background-color: #d4006e; color: white; }
    </style>
</head>
<body>

<div class="navbar-topo">
    <div class="logo-texto">Primavera<br>Sound</div>
    <div>
        <a href="index.php" class="btn btn-outline-secondary btn-sm me-2">Início</a>
        <a href="admin.php" class="btn btn-outline-secondary btn-sm me-2">Gerir</a>
        <a href="logout.php" class="btn btn-outline-secondary btn-sm">Logout</a>
    </div>
</div>

<div class="banner">Porto · 11 a 14 de Junho de 2026</div>

<div class="container mt-5">
    <p class="titulo-principal">Primavera Sound Porto</p>
    <p class="subtitulo">Horário de Concertos</p>

    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>Data</th>
                <th>Hora</th>
                <th>Artista</th>
                <th>Palco</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($concertos)): ?>
                <tr><td colspan="4" class="text-center">Nenhum concerto encontrado.</td></tr>
            <?php else: ?>
                <?php foreach ($concertos as $c): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($c['dia_data']); ?></td>
                        <td><?php echo htmlspecialchars($c['hora']); ?></td>
                        <td><?php echo htmlspecialchars($c['artista']); ?></td>
                        <td><?php echo htmlspecialchars($c['palco']); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>