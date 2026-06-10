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

$titulo = "Adicionar Concerto";
$pagina = "adicionar";
require_once 'includes/header.php';
?>

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

<?php require_once 'includes/footer.php'; ?>