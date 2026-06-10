<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
require_once 'db/Database.php';
$db = (new Database())->getConnection();

if (isset($_GET['apagar'])) {
    $stmt = $db->prepare("DELETE FROM concertos WHERE id = :id");
    $stmt->execute([':id' => $_GET['apagar']]);
    header('Location: admin.php');
    exit();
}

$query = "SELECT c.id, c.dia_data, c.hora, a.nome AS artista, p.nome AS palco 
          FROM concertos c
          JOIN artistas a ON c.artista_id = a.id
          JOIN palcos p ON c.palco_id = p.id
          ORDER BY c.dia_data ASC, c.hora ASC";
$stmt = $db->prepare($query);
$stmt->execute();
$concertos = $stmt->fetchAll(PDO::FETCH_ASSOC);

$titulo = "Gestão de Concertos";
$pagina = "admin";
require_once 'includes/header.php';
?>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <p class="titulo-principal mb-0" style="font-size:3rem; line-height:1;">Gestão de Concertos</p>
        <div>
            <a href="artistas.php" class="btn btn-orange me-2">Gerir Artistas</a>
            <a href="adicionar.php" class="btn btn-pink">+ Adicionar Concerto</a>
        </div>
    </div>

    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>Data</th>
                <th>Hora</th>
                <th>Artista</th>
                <th>Palco</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($concertos as $c): ?>
                <tr>
                    <td><?php echo htmlspecialchars($c['dia_data']); ?></td>
                    <td><?php echo htmlspecialchars($c['hora']); ?></td>
                    <td><?php echo htmlspecialchars($c['artista']); ?></td>
                    <td><?php echo htmlspecialchars($c['palco']); ?></td>
                    <td>
                        <a href="editar.php?id=<?php echo $c['id']; ?>" class="btn btn-sm btn-orange">Editar</a>
                        <a href="admin.php?apagar=<?php echo $c['id']; ?>" class="btn btn-sm btn-danger"
                           onclick="return confirm('Tens a certeza?')">Apagar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require_once 'includes/footer.php'; ?>