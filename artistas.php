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

if (isset($_GET['apagar'])) {
    try {
        $stmt = $db->prepare("DELETE FROM artistas WHERE id = :id");
        $stmt->execute([':id' => $_GET['apagar']]);
        $mensagem = "Artista apagado com sucesso!";
    } catch (Exception $e) {
        $erro = "Não é possível apagar, este artista tem concertos associados.";
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['adicionar'])) {
    $nome = htmlspecialchars($_POST['nome']);
    $stmt = $db->prepare("INSERT INTO artistas (nome) VALUES (:nome)");
    $stmt->execute([':nome' => $nome]);
    $mensagem = "Artista adicionado com sucesso!";
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['editar'])) {
    $nome = htmlspecialchars($_POST['nome']);
    $id = $_POST['id'];
    $stmt = $db->prepare("UPDATE artistas SET nome = :nome WHERE id = :id");
    $stmt->execute([':nome' => $nome, ':id' => $id]);
    $mensagem = "Artista atualizado com sucesso!";
}

$artista_editar = null;
if (isset($_GET['editar'])) {
    $stmt = $db->prepare("SELECT * FROM artistas WHERE id = :id");
    $stmt->execute([':id' => $_GET['editar']]);
    $artista_editar = $stmt->fetch(PDO::FETCH_ASSOC);
}

$artistas = $db->query("SELECT * FROM artistas ORDER BY nome ASC")->fetchAll(PDO::FETCH_ASSOC);

$titulo = "Artistas";
$pagina = "artistas";
require_once 'includes/header.php';
?>

<div class="container mt-5">
    <p class="titulo-principal">Gestão de Artistas</p>

    <?php if ($mensagem): ?>
        <div class="alert alert-success"><?php echo $mensagem; ?></div>
    <?php endif; ?>
    <?php if ($erro): ?>
        <div class="alert alert-danger"><?php echo $erro; ?></div>
    <?php endif; ?>

    <div class="row">
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

<?php require_once 'includes/footer.php'; ?>