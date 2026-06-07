<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
require_once 'db/Database.php';
$db = (new Database())->getConnection();

$mensagem = "";
$erro = "";

// APAGAR artista
if (isset($_GET['apagar'])) {
    try {
        $stmt = $db->prepare("DELETE FROM artistas WHERE id = :id");
        $stmt->execute([':id' => $_GET['apagar']]);
        $mensagem = "Artista apagado com sucesso!";
    } catch (Exception $e) {
        $erro = "Não é possível apagar — este artista tem concertos associados.";
    }
}

// ADICIONAR artista
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['adicionar'])) {
    $nome = htmlspecialchars($_POST['nome']);
    $stmt = $db->prepare("INSERT INTO artistas (nome) VALUES (:nome)");
    $stmt->execute([':nome' => $nome]);
    $mensagem = "Artista adicionado com sucesso!";
}

// EDITAR artista
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['editar'])) {
    $nome = htmlspecialchars($_POST['nome']);
    $id = $_POST['id'];
    $stmt = $db->prepare("UPDATE artistas SET nome = :nome WHERE id = :id");
    $stmt->execute([':nome' => $nome, ':id' => $id]);
    $mensagem = "Artista atualizado com sucesso!";
}

// Buscar artista para editar
$artista_editar = null;
if (isset($_GET['editar'])) {
    $stmt = $db->prepare("SELECT * FROM artistas WHERE id = :id");
    $stmt->execute([':id' => $_GET['editar']]);
    $artista_editar = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Listar todos os artistas
$artistas = $db->query("SELECT * FROM artistas ORDER BY nome ASC")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Artistas - Primavera Sound</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@700;900&family=Barlow:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body { background-color: #f5f0ea; font-family: 'Barlow', sans-serif; }
        .navbar-topo { background-color: #ffffff; border-bottom: 2px solid #e0d8cf; padding: 12px 24px; display: flex; justify-content: space-between; align-items: center; }
        .logo-texto { font-family: 'Barlow Condensed', sans-serif; font-weight: 900; font-size: 1.4rem; text-transform: uppercase; line-height: 1.1; color: #111; }
        .banner { background: linear-gradient(135deg, #f72585, #f4a019, #f72585); color: white; text-align: center; padding: 18px; font-family: 'Barlow Condensed', sans-serif; font-size: 1.1rem; letter-spacing: 2px; text-transform: uppercase; }
        .titulo-principal { font-family: 'Barlow Condensed', sans-serif; font-weight: 900; font-size: 2.5rem; text-transform: uppercase; color: #111; }
        .table { background-color: #ffffff; border-radius: 8px; overflow: hidden; }
        .table thead th { background-color: #111; color: #ffffff; text-transform: uppercase; font-family: 'Barlow Condensed', sans-serif; font-size: 1rem; letter-spacing: 1px; }
        .table tbody tr:hover { background-color: #fde8f0; }
        .btn-pink { background-color: #f72585; color: white; border: none; font-family: 'Barlow Condensed', sans-serif; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; }
        .btn-pink:hover { background-color: #d4006e; color: white; }
        .btn-orange { background-color: #f4a019; color: white; border: none; font-family: 'Barlow Condensed', sans-serif; font-weight: 700; text-transform: uppercase; }
        .btn-orange:hover { background-color: #d4880a; color: white; }
        .card { border: none; border-radius: 12px; }
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
    <p class="titulo-principal">Gestão de Artistas</p>

    <?php if ($mensagem): ?>
        <div class="alert alert-success"><?php echo $mensagem; ?></div>
    <?php endif; ?>
    <?php if ($erro): ?>
        <div class="alert alert-danger"><?php echo $erro; ?></div>
    <?php endif; ?>

    <div class="row">
        <!-- Formulário adicionar / editar -->
        <div class="col-md-4">
            <div class="card shadow p-4 mb-4">
                <?php if ($artista_editar): ?>
                    <h5 class="mb-3">Editar Artista</h5>
                    <form method="POST">
                        <input type="hidden" name="id" value="<?php echo $artista_editar['id']; ?>">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nome</label>
                            <input type="text" name="nome" class="form-control" 
                                   value="<?php echo htmlspecialchars($artista_editar['nome']); ?>" required>
                        </div>
                        <button type="submit" name="editar" class="btn btn-orange w-100">Guardar</button>
                        <a href="artistas.php" class="btn btn-outline-secondary w-100 mt-2">Cancelar</a>
                    </form>
                <?php else: ?>
                    <h5 class="mb-3">Adicionar Artista</h5>
                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nome</label>
                            <input type="text" name="nome" class="form-control" required>
                        </div>
                        <button type="submit" name="adicionar" class="btn btn-pink w-100">Adicionar</button>
                    </form>
                <?php endif; ?>
            </div>
        </div>

        <!-- Lista de artistas -->
        <div class="col-md-8">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($artistas as $a): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($a['nome']); ?></td>
                            <td>
                                <a href="artistas.php?editar=<?php echo $a['id']; ?>" 
                                   class="btn btn-sm btn-orange">Editar</a>
                                <a href="artistas.php?apagar=<?php echo $a['id']; ?>" 
                                   class="btn btn-sm btn-danger"
                                   onclick="return confirm('Tens a certeza?')">Apagar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>