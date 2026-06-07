<?php
session_start();
require_once 'db/Database.php';

$mensagem = "";
$erro = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $db = (new Database())->getConnection();
    
    $username = htmlspecialchars($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    try {
        $sql = "INSERT INTO utilizadores (username, password) VALUES (:username, :password)";
        $stmt = $db->prepare($sql);
        $stmt->execute([':username' => $username, ':password' => $password]);
        $mensagem = "Conta criada com sucesso!";
    } catch (Exception $e) {
        $erro = "Esse username já existe. Tenta outro.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registar - Primavera Sound</title>
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
</div>

<div class="banner">Porto · 11 a 14 de Junho de 2026</div>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <p class="titulo-principal text-center">Criar Conta</p>
            <div class="card shadow p-4">

                <?php if ($mensagem): ?>
                    <div class="alert alert-success">
                        <?php echo $mensagem; ?>
                        <a href="login.php" style="color:#f72585;">Fazer login</a>
                    </div>
                <?php endif; ?>

                <?php if ($erro): ?>
                    <div class="alert alert-danger"><?php echo $erro; ?></div>
                <?php endif; ?>

                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Username</label>
                        <input type="text" name="username" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-pink w-100">Registar</button>
                </form>

                <p class="text-center mt-3">
                    Já tens conta? <a href="login.php" style="color:#f72585;">Faz login aqui</a>
                </p>
            </div>
        </div>
    </div>
</div>

</body>
</html>