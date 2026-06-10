<?php ?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $titulo ?? 'Primavera Sound'; ?> - Primavera Sound</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@700;900&family=Barlow:wght@400;600&display=swap" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>

<div class="navbar-topo">
    <div class="logo-texto">Primavera<br>Sound</div>
    <div>
        <?php if (!isset($pagina) || $pagina == 'login' || $pagina == 'registar'): ?>
            
        <?php elseif ($pagina == 'index'): ?>
            <span class="me-3 text-muted">Olá, <?php echo htmlspecialchars($_SESSION['username']); ?></span>
            <a href="horario.php" class="btn btn-pink btn-sm me-2">Ver Horário</a>
            <a href="admin.php" class="btn btn-outline-secondary btn-sm me-2">Gerir</a>
            <a href="logout.php" class="btn btn-outline-secondary btn-sm">Logout</a>

        <?php elseif ($pagina == 'horario'): ?>
            <a href="index.php" class="btn btn-outline-secondary btn-sm me-2">Início</a>
            <a href="admin.php" class="btn btn-outline-secondary btn-sm me-2">Gerir</a>
            <a href="logout.php" class="btn btn-outline-secondary btn-sm">Logout</a>

        <?php elseif ($pagina == 'admin'): ?>
            <a href="index.php" class="btn btn-outline-secondary btn-sm me-2">Início</a>
            <a href="logout.php" class="btn btn-outline-secondary btn-sm">Logout</a>
            
        <?php elseif ($pagina == 'artistas' || $pagina == 'adicionar' || $pagina == 'editar'): ?>
            <a href="admin.php" class="btn btn-outline-secondary btn-sm me-2">Voltar</a>
            <a href="logout.php" class="btn btn-outline-secondary btn-sm">Logout</a>
        <?php endif; ?>
    </div>
</div>

<div class="banner">Porto · 11 a 14 de Junho de 2026</div>