<?php
session_start();
require_once 'db/Database.php';

$erro = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $db = (new Database())->getConnection();
    $username = htmlspecialchars($_POST['username']);

    $sql = "SELECT * FROM utilizadores WHERE username = :username";
    $stmt = $db->prepare($sql);
    $stmt->execute([':username' => $username]);
    $utilizador = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($utilizador && password_verify($_POST['password'], $utilizador['password'])) {
        $_SESSION['user_id'] = $utilizador['id'];
        $_SESSION['username'] = $utilizador['username'];
        header('Location: index.php');
        exit();
    } else {
        $erro = "Username ou password incorretos.";
    }
}

$titulo = "Login";
$pagina = "login";
require_once 'includes/header.php';
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <p class="titulo-principal text-center">Entrar</p>
            <div class="card shadow p-4">

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
                    <button type="submit" class="btn btn-pink w-100">Entrar</button>
                </form>

                <p class="text-center mt-3">
                    Não tens conta? <a href="registar.php" style="color:#f72585;">Regista-te aqui</a>
                </p>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>