<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
require_once 'db/Database.php';
$db = (new Database())->getConnection();

$mensagem = "";

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: admin.php');
    exit();
}

$stmt = $db->prepare("SELECT * FROM concertos WHERE id = :id");
$stmt->execute([':id' => $id]);
$concerto = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$concerto) {
    header('Location: admin.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $sql = "UPDATE concertos SET artista_id = :artista_id, palco_id = :palco_id, 
            dia_data = :dia_data, hora = :hora WHERE id = :id";
    $stmt = $db->prepare($sql);
    $stmt->execute([
        ':artista_id' => $_POST['artista_id'],
        ':palco_id' => $_POST['palco_id'],
        ':dia_data' => $_POST['dia_data'],
        ':hora' => $_POST['hora'],
        ':id' => $id
    ]);
    $mensagem = "Concerto atualizado com sucesso!";

    $stmt = $db->prepare("SELECT * FROM concertos WHERE id = :id");
    $stmt->execute([':id' => $id]);
    $concerto = $stmt->fetch(PDO::FETCH_ASSOC);
}

$artistas = $db->query("SELECT * FROM artistas")->fetchAll(PDO::FETCH_ASSOC);
$palcos = $db->query("SELECT * FROM palcos")->fetchAll(PDO::FETCH_ASSOC);

$titulo = "Editar Concerto";
$pagina = "editar";
require_once 'includes/header.php';
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <p class="titulo-principal text-center">Editar Concerto</p>
            <div class="card shadow p-4">

                <?php if ($mensagem): ?>
                    <div class="alert alert-success"><?php echo $mensagem; ?></div>
                <?php endif; ?>

                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Artista</label>
                        <select name="artista_id" class="form-select" required>
                            <?php foreach ($artistas as $a): ?>
                                <option value="<?php echo $a['id']; ?>"
                                    <?php echo $a['id'] == $concerto['artista_id'] ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($a['nome']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Palco</label>
                        <select name="palco_id" class="form-select" required>
                            <?php foreach ($palcos as $p): ?>
                                <option value="<?php echo $p['id']; ?>"
                                    <?php echo $p['id'] == $concerto['palco_id'] ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($p['nome']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Data</label>
                        <input type="date" name="dia_data" class="form-control"
                               value="<?php echo $concerto['dia_data']; ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Hora</label>
                        <input type="time" name="hora" class="form-control"
                               value="<?php echo substr($concerto['hora'], 0, 5); ?>" required>
                    </div>

                    <button type="submit" class="btn btn-orange w-100">Guardar Alterações</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>