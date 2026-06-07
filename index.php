<?php

//Inicia a sessão e verifica se o utilizador está logado
session_start();

// Se o utilizador não estiver logado, redireciona para a página de login
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Primavera Sound 2026</title>
    <!-- Bootstrap para estilização responsiva -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Fonte Barlow Condensed parecida com a do site oficial -->
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@700;900&family=Barlow:wght@400;600&display=swap" rel="stylesheet">
    <style>
        /* Fundo bege claro inspirado no site oficial do festival */
        body { background-color: #f5f0ea; font-family: 'Barlow', sans-serif; }
        /* Barra de navegacao superior */
        .navbar-topo { background-color: #ffffff; border-bottom: 2px solid #e0d8cf; padding: 12px 24px; display: flex; justify-content: space-between; align-items: center; }
        /* Estilo do logo */
        .logo-texto { font-family: 'Barlow Condensed', sans-serif; font-weight: 900; font-size: 1.4rem; text-transform: uppercase; line-height: 1.1; color: #111; }
        /* Banner com gradiente de rosa e laranja inspirado no site oficial */
        .banner { background: linear-gradient(135deg, #f72585, #f4a019, #f72585); color: white; text-align: center; padding: 18px; font-family: 'Barlow Condensed', sans-serif; font-size: 1.1rem; letter-spacing: 2px; text-transform: uppercase; }
        /* Botão rosa para ver o horário, inspirado nas cores do site oficial */
        .btn-pink { background-color: #f72585; color: white; border: none; font-family: 'Barlow Condensed', sans-serif; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; }
        .btn-pink:hover { background-color: #d4006e; color: white; }
        /* Estilo para o cartaz do festival, com bordas arredondadas e sombra para destacar a imagem */
        .cartaz { max-width: 420px; width: 100%; border-radius: 12px; box-shadow: 0 8px 32px rgba(0,0,0,0.15); }
    </style>
</head>
<body>

<!-- Barra de navegacao com o nome do utilizador e links -->
<div class="navbar-topo">
    <div class="logo-texto">Primavera<br>Sound</div>
    <div>
        <!-- Mostra o username do utilizador logado e os links para ver o horário, gerir e logout -->
        <span class="me-3 text-muted">Olá, <?php echo htmlspecialchars($_SESSION['username']); ?></span>
        <a href="horario.php" class="btn btn-pink btn-sm me-2">Ver Horário</a>
        <a href="admin.php" class="btn btn-outline-secondary btn-sm me-2">Gerir</a>
        <a href="logout.php" class="btn btn-outline-secondary btn-sm">Logout</a>
    </div>
</div>

<!-- Banner com as datas e local do festival -->
<div class="banner">Porto · 11 a 14 de Junho de 2026</div>

<!-- Cartaz oficial do festival centrado na pagina -->
<div class="container mt-5 text-center">
    <img src="images/primavera_sound2026.png" alt="Cartaz Primavera Sound 2026" class="cartaz">
</div>

</body>
</html>