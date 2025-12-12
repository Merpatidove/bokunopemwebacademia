<?php
require_once __DIR__ . '/../config/config.php';
?>


<?php include '../includes/header.php'; ?>
<?php include '../includes/navbar.php'; ?>

<main class="container">
    <h2>🏆 Leaderboard</h2>

    <?php
    $stmt = $conn->prepare("SELECT username, score, created_at FROM highscores ORDER BY score DESC, created_at ASC LIMIT 20");
    $stmt->execute();
    $result = $stmt->get_result();
    ?>

    <table style="width:100%; border-collapse: collapse;">
        <thead>
            <tr style="background:#f0f0f0;">
                <th style="padding:8px; text-align:left;">#</th>
                <th style="padding:8px; text-align:left;">Nama</th>
                <th style="padding:8px; text-align:left;">Score</th>
                <th style="padding:8px; text-align:left;">Tanggal</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 1; while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td style="padding:8px;"><?= $i ?></td>
                    <td style="padding:8px;"><?= htmlspecialchars($row['username']) ?></td>
                    <td style="padding:8px;"><?= htmlspecialchars($row['score']) ?></td>
                    <td style="padding:8px;"><?= htmlspecialchars($row['created_at']) ?></td>
                </tr>
            <?php $i++; endwhile; ?>
            <?php if ($i === 1): ?>
                <tr><td colspan="4" style="padding:12px; text-align:center;">Belum ada skor</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

    <br>
    <a href="index.php" class="btn-secondary" id="backBtn">⬅ Kembali ke Beranda</a>
    <a href="game.php" class="btn-secondary">Mainkan Game</a>
</main>

<?php include '../includes/footer.php'; ?>
