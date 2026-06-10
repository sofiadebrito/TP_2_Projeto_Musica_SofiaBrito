<?php
session_start();

// se nao tiver logado, vai para a pagina login
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$titulo = "Início";
$pagina = "index";

require_once 'includes/header.php';
?>

<div class="container mt-5 text-center">
    <img src="images/primavera_sound2026.png" alt="Cartaz Primavera Sound 2026" class="cartaz">
</div>

<?php require_once 'includes/footer.php'; ?>