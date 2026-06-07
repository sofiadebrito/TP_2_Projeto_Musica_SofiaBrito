<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
require_once 'db/Database.php';
$db = (new Database())->getConnection();

$mensagem = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $artista_id = $_POST['artista_id'];
    $palco_id = $_POST['palco_id'];
    $dia_data = $_POST['dia_data'];
    $hora = $_POST['hora'];

    $sql = "INSERT INTO concertos (artista_id, palco_id, dia_data, hora) 
            VALUES (:artista_id, :palco_id, :dia_data, :hora)";
    $stmt = $db->prepare($sql);
    $stmt->execute([
        ':artista_id' => $artista_id,
        ':palco_id' => $palco_id,
        ':dia_data' => $dia_data,
        ':hora' => $hora
    ]);
    $mensagem = "Concerto adicionado com sucesso!";
}

$artistas = $db->query("SELECT * FROM artistas")->fetchAll(PDO::FETCH_ASSOC);
$palcos = $db->query("SELECT * FROM palcos")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Adicionar Concerto - Primavera Sound</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@700;900&family=Barlow:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body { background-color: #f5f0ea; font-family: 'Barlow', sans-serif; }
        .navbar-topo { background-color: #ffffff; border-bottom: 2px solid #e0d8cf; padding: 12px 24px; display: flex; justify-content: space-between; align-items: center; }
        .logo-texto { font-family: 'Barlow Condensed', sans-serif; font-weight: 900; font-size: 1.4rem; text-transform: uppercase; line-height: 1.1; color: #111; }
        .banner { background: linear-gradient(135deg, #f72585, #f4a019, #f72585); color: white; text-align: center; padding: 18px; font-family: 'Barlow Condensed', sans-serif; font-size: 1.1rem; letter-spacing: 2px; text-transform: uppercase; }
        .titulo-principal { font-family: 'Barlow Condensed', sans-serif; font-weight: 900; font-size: 2.5rem; text-transform: uppercase; color: #111; }
        .card { border: none; border-radius: 12px; }
        .btn-pink { background-color: #f72585; color: white; border: none; font-family: 'Barlow Condensed', sans-serif; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; }
        .btn-pink:hover { background-color: #d4006e; color: white; }
    </style>
</head>
<body>

<div class="navbar-topo">
    <div class="logo-texto">Primavera<br>Sound</div>
    <div>
        <a href="admin.php" class="btn btn-outline-secondary btn-sm me-2">Voltar</a>
        <a href="logout.php" class="btn btn-outline-secondary btn-sm">Logout</a>
    </div>
</div>

<div class="banner">Porto · 11 a 14 de Junho de 2026</div>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <p class="titulo-principal text-center">Adicionar Concerto</p>
            <div class="card shadow p-4">

                <?php if ($mensagem): ?>
                    <div class="alert alert-success"><?php echo $mensagem; ?></div>
                <?php endif; ?>

                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Artista</label>
                        <select name="artista_id" class="form-select" required>
                            <?php foreach ($artistas as $a): ?>
                                <option value="<?php echo $a['id']; ?>">
                                    <?php echo htmlspecialchars($a['nome']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Palco</label>
                        <select name="palco_id" class="form-select" required>
                            <?php foreach ($palcos as $p): ?>
                                <option value="<?php echo $p['id']; ?>">
                                    <?php echo htmlspecialchars($p['nome']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Data</label>
                        <input type="date" name="dia_data" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Hora</label>
                        <input type="time" name="hora" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-pink w-100">Adicionar</button>
                </form>
            </div>
        </div>
    </div>
</div>

</body>
</html>