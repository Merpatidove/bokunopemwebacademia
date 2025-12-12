<?php
require_once '../config/config.php';

if (!isAdmin()) {
    redirect('index.php');
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = sanitize($_POST['title']);
    $content = sanitize($_POST['content']);

    if (empty($title) || empty($content)) {
        $error = 'Judul dan konten harus diisi!';
    } else {
        $stmt = $conn->prepare("INSERT INTO articles (title, content, author_id) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $title, $content, $_SESSION['user_id']);

        if ($stmt->execute()) {
            $success = 'Artikel berhasil dibuat!';
            $article_id = $conn->insert_id;
        } else {
            $error = 'Gagal membuat artikel!';
        }
    }
}
?>

<?php include '../includes/header.php'; ?>

<?php include '../includes/navbar.php'; ?>

<div class="form-container" style="max-width: 800px;">
    <h2>Buat Postingan Baru</h2>

    <?php if ($error): ?>
        <div class="alert alert-error"><?= $error ?></div>
    <?php endif; ?>

    <?php if ($success): ?>
        <div class="alert alert-success">
            <?= $success ?>
            <a href="../public/article.php?id=<?= $article_id ?>">Lihat postingan</a> atau
            <a href="admin.php">kembali ke dashboard</a>
        </div>
    <?php endif; ?>

    <form method="POST" action="">
        <div class="form-group">
            <label>Judul</label>
            <input type="text" name="title" required placeholder="Contoh: Judul artikel atau postingan">
        </div>

        <div class="form-group">
            <label>Konten</label>
            <textarea name="content" required style="min-height: 300px;" placeholder="Tulis konten artikel di sini..."></textarea>
        </div>

        <button type="submit" class="btn-submit">Publikasikan Artikel</button>
    </form>

    <div class="text-center">
        <a href="admin.php">← Kembali ke Dashboard</a>
    </div>
</div>

<?php include '../includes/footer.php'; ?>