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

$titulo = "Criar Conta";
$pagina = "registar";
require_once 'includes/header.php';
?>

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

<?php require_once 'includes/footer.php'; ?>