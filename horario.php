<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
require_once 'db/Database.php';
$db = (new Database())->getConnection();

$query = "SELECT c.dia_data, c.hora, a.nome AS artista, p.nome AS palco 
          FROM concertos c
          JOIN artistas a ON c.artista_id = a.id
          JOIN palcos p ON c.palco_id = p.id
          ORDER BY c.dia_data ASC, c.hora ASC";
$stmt = $db->prepare($query);
$stmt->execute();
$concertos = $stmt->fetchAll(PDO::FETCH_ASSOC);

$titulo = "Horário";
$pagina = "horario";
require_once 'includes/header.php';
?>

<div class="container mt-5">
    <p class="titulo-principal" style="font-size:3.5rem; line-height:1;">Primavera Sound Porto</p>
    <p style="font-family:'Barlow Condensed',sans-serif; font-size:1.2rem; color:#555; text-transform:uppercase; letter-spacing:2px; margin-bottom:2rem;">Horário de Concertos</p>

    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>Data</th>
                <th>Hora</th>
                <th>Artista</th>
                <th>Palco</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($concertos)): ?>
                <tr><td colspan="4" class="text-center">Nenhum concerto encontrado.</td></tr>
            <?php else: ?>
                <?php foreach ($concertos as $c): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($c['dia_data']); ?></td>
                        <td><?php echo htmlspecialchars($c['hora']); ?></td>
                        <td><?php echo htmlspecialchars($c['artista']); ?></td>
                        <td><?php echo htmlspecialchars($c['palco']); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require_once 'includes/footer.php'; ?>