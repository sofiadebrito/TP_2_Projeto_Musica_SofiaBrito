<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
require_once 'db/Database.php';
$db = (new Database())->getConnection();

if (isset($_GET['apagar'])) {
    $stmt = $db->prepare("DELETE FROM concertos WHERE id = :id");
    $stmt->execute([':id' => $_GET['apagar']]);
    header('Location: admin.php');
    exit();
}

$query = "SELECT c.id, c.dia_data, c.hora, a.nome AS artista, p.nome AS palco 
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
    <title>Admin - Primavera Sound</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@700;900&family=Barlow:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body { background-color: #f5f0ea; font-family: 'Barlow', sans-serif; }
        .navbar-topo { background-color: #ffffff; border-bottom: 2px solid #e0d8cf; padding: 12px 24px; display: flex; justify-content: space-between; align-items: center; }
        .logo-texto { font-family: 'Barlow Condensed', sans-serif; font-weight: 900; font-size: 1.4rem; text-transform: uppercase; line-height: 1.1; color: #111; }
        .banner { background: linear-gradient(135deg, #f72585, #f4a019, #f72585); color: white; text-align: center; padding: 18px; font-family: 'Barlow Condensed', sans-serif; font-size: 1.1rem; letter-spacing: 2px; text-transform: uppercase; }
        .titulo-principal { font-family: 'Barlow Condensed', sans-serif; font-weight: 900; font-size: 3rem; text-transform: uppercase; color: #111; line-height: 1; }
        .table { background-color: #ffffff; border-radius: 8px; overflow: hidden; }
        .table thead th { background-color: #111; color: #ffffff; text-transform: uppercase; font-family: 'Barlow Condensed', sans-serif; font-size: 1rem; letter-spacing: 1px; }
        .table tbody tr:hover { background-color: #fde8f0; }
        .btn-gerir { background-color: #f72585; color: white; border: none; font-family: 'Barlow Condensed', sans-serif; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; }
        .btn-gerir:hover { background-color: #d4006e; color: white; }
    </style>
</head>
<body>

<div class="navbar-topo">
    <div class="logo-texto">Primavera<br>Sound</div>
    <div>
        <a href="index.php" class="btn btn-outline-secondary btn-sm me-2">Início</a>
        <a href="logout.php" class="btn btn-outline-secondary btn-sm">Logout</a>
    </div>
</div>

<div class="banner">Porto · 11 a 14 de Junho de 2026</div>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <p class="titulo-principal mb-0">Gestão de Concertos</p>
        <a href="adicionar.php" class="btn btn-gerir">+ Adicionar</a>
    </div>

    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>Data</th>
                <th>Hora</th>
                <th>Artista</th>
                <th>Palco</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($concertos as $c): ?>
                <tr>
                    <td><?php echo htmlspecialchars($c['dia_data']); ?></td>
                    <td><?php echo htmlspecialchars($c['hora']); ?></td>
                    <td><?php echo htmlspecialchars($c['artista']); ?></td>
                    <td><?php echo htmlspecialchars($c['palco']); ?></td>
                    <td>
                        <a href="editar.php?id=<?php echo $c['id']; ?>" class="btn btn-sm" style="background-color:#f4a019; color:#fff;">Editar</a>
                        <a href="admin.php?apagar=<?php echo $c['id']; ?>" class="btn btn-sm btn-danger"
                           onclick="return confirm('Tens a certeza?')">Apagar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

</body>
</html>