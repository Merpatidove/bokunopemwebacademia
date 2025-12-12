<?php
require_once '../config/config.php';
require_once '../handlers/article_handlers.php';
require_once '../handlers/statistic_handlers.php';

$search = sanitize($_GET['search'] ?? '');

if (!empty($search)) {
    $articles_result = searchArticles($search);
} else {
    $articles_result = getAllArticles();
}

$total_articles = getTotalArticles();
$total_users = getTotalUsers();
$total_comments = getTotalComments();
$featured_article = getFeaturedArticle();
// Ambil 5 highscore tertinggi
$hs_stmt = $conn->prepare("SELECT username, score FROM highscores ORDER BY score DESC, created_at ASC LIMIT 5");
$hs_stmt->execute();
$hs_result = $hs_stmt->get_result();

// Load character images from assets/game
$game_dir = __DIR__ . '/../assets/game';
$character_files = [];
if (is_dir($game_dir)) {
    $files = scandir($game_dir);
    foreach ($files as $f) {
        if (preg_match('/\.(jpg|jpeg|png|gif)$/i', $f)) {
            $character_files[] = $f;
        }
    }
}

function displayNameFromFile($file)
{
    $name = preg_replace('/_Portrait\.(jpg|jpeg|png|gif)$/i', '', $file);
    $name = preg_replace('/\.(jpg|jpeg|png|gif)$/i', '', $name);
    $name = str_replace('_', ' ', $name);
    return $name;
}

$article_title_map = [];
$all_articles_res = $conn->query("SELECT id, title FROM articles");
if ($all_articles_res) {
    while ($r = $all_articles_res->fetch_assoc()) {
        $article_title_map[strtolower($r['title'])] = $r['id'];
    }
}

$matched_character_files = [];
if (!empty($search) && count($character_files) > 0) {
    foreach ($character_files as $f) {
        if (stripos(displayNameFromFile($f), $search) !== false) {
            $matched_character_files[] = $f;
        }
    }
}
?>

<?php include '../includes/header.php'; ?>

<?php include '../includes/navbar.php'; ?>

<header class="hero">
    <div class="container">
        <h2>Ayo main game Bokuno Responsi   </h2>
        <p>Seru banget lho!!</p>
        <a href="game.php" class="featured-btn">Mainkan Game!</a>
    </div>
</header>

<?php $is_logged_in = function_exists('isLoggedIn') && isLoggedIn(); ?>
<div id="loginModal" style="display:none;position:fixed;left:0;top:0;width:100%;height:100%;background:rgba(0,0,0,0.6);align-items:center;justify-content:center;z-index:9999;">
    <div style="background:#fff;padding:20px;border-radius:8px;max-width:420px;margin:auto;text-align:left;box-shadow:0 10px 30px rgba(0,0,0,0.2);">
        <h3 style="margin-top:0;">Harus Login</h3>
        <p>Anda harus login terlebih dahulu untuk memainkan game.</p>
        <div style="text-align:right;margin-top:15px;">
            <a href="../auth/login.php" class="btn btn-primary" style="margin-right:8px; background_color: #1b3E3b">Login</a>
            <button id="loginCancelBtn" class="btn">Batal</button>
        </div>
    </div>
</div>

<script>    
    const loggedIn = <?= $is_logged_in ? 'true' : 'false' ?>;

    function showLoginModal() {
        document.getElementById('loginModal').style.display = 'flex';
    }
    function hideLoginModal() {
        document.getElementById('loginModal').style.display = 'none';
    }

    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('a[href="game.php"]').forEach(function(el){
            el.addEventListener('click', function(e){
                if (!loggedIn) {
                    e.preventDefault();
                    showLoginModal();
                }
            });
        });

        const cancelBtn = document.getElementById('loginCancelBtn');
        if (cancelBtn) cancelBtn.addEventListener('click', function(){ hideLoginModal(); });
    });
</script>

<main class="container">
    <section class="stats-container">
        <div class="stat-card">
            <h3>20</h3>
            <p>👥 Total Karakter di game ini</p>
        </div>
    </section>

    <?php if ($featured_article): ?>
        <section class="featured-section">
            <div class="container">
                <div class="featured-content">
                    <div class="featured-text">
                        <h1>🏆 Highscore</h1>
                        <h2>Nama | Total Benar</h2>
                        <?php if ($hs_result->num_rows > 0): ?>
                            <?php $rank = 1; ?>
                            <?php while ($row = $hs_result->fetch_assoc()): ?>
                                <p><?= $rank ?>. <?= htmlspecialchars($row['username']) ?> | <?= $row['score'] ?></p>
                                <?php $rank++; ?>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <p>Belum ada score 😢</p>
                        <?php endif; ?>
                        <a href="highscores.php" class="featured-btn">Lihat Selengkapnya →</a>
                    </div>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <section class="posts-section" style="margin-top:40px;">
        <h2 class="section-title">📰 Postingan Terbaru</h2>
        <?php
            $latest_posts = $conn->query("SELECT a.*, u.username as author FROM articles a JOIN users u ON a.author_id = u.id ORDER BY a.id DESC LIMIT 5");
        ?>
        <?php if ($latest_posts && $latest_posts->num_rows > 0): ?>
            <div class="articles-grid">
                <?php while ($post = $latest_posts->fetch_assoc()): ?>
                    <div class="article-card">
                        <div class="article-top">
                            <h3><?= htmlspecialchars($post['title']) ?></h3>
                            <p class="article-preview"><?= htmlspecialchars(substr($post['content'],0,150)) ?>...</p>
                        </div>
                        <div class="article-bottom">
                            <div class="article-meta">📝 <?= htmlspecialchars($post['author']) ?></div>
                            <a href="article.php?id=<?= $post['id'] ?>" class="btn btn-read">Baca Selengkapnya</a>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <p style="color:#7f8c8d;">Belum ada postingan dari admin.</p>
        <?php endif; ?>
    </section>

    <section class="articles-section">
        <?php if (!empty($search)): ?>
            <h2 class="section-title">Hasil Pencarian: "<?= htmlspecialchars($search) ?>"</h2>
        <?php else: ?>
            <h2 class="section-title">📖 Daftar Karakter</h2>
        <?php endif; ?>
        <section class=" search-section">
            <h3 style="text-align: center; margin-bottom: 20px; color: #2c3e50;">🔍 Cari Karakter</h3>
            <form method="GET" action="">
                <div class="search-container">
                    <input type="text" name="search" placeholder="Cari karakter..." value="<?= htmlspecialchars($search) ?>">
                    <button type="submit">Cari</button>
                </div>
            </form>
            <?php if (!empty($search)): ?>
                <div class="clear-search">
                    <a href="index.php">← Hapus pencarian</a>
                </div>
            <?php endif; ?>
        </section>

        <?php if (empty($search)): ?>
            <?php if (count($character_files) > 0): ?>
                <div class="articles-grid">
                    <?php foreach ($character_files as $file): ?>
                        <?php $name = displayNameFromFile($file); $key = strtolower($name); $hasDetail = isset($article_title_map[$key]); ?>
                        <div class="article-card character-card">
                            <div class="img-cover">
                                <img src="../assets/game/<?= rawurlencode($file) ?>" alt="<?= htmlspecialchars($name) ?>" loading="lazy" decoding="async">
                                <div class="img-overlay">
                                    <h3><?= htmlspecialchars($name) ?></h3>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="no-results">
                    <h3>😔 Tidak ada karakter ditemukan</h3>
                    <p>Belum ada gambar karakter di folder `assets/game`.</p>
                </div>
            <?php endif; ?>
        <?php else: ?>
            <?php
            ?>
            <?php if (count($matched_character_files) > 0): ?>
                <div class="articles-grid">
                    <?php foreach ($matched_character_files as $file): ?>
                        <?php $name = displayNameFromFile($file); $key = strtolower($name); $hasDetail = isset($article_title_map[$key]); ?>
                        <div class="article-card character-card">
                            <div class="img-cover">
                                <img src="../assets/game/<?= rawurlencode($file) ?>" alt="<?= htmlspecialchars($name) ?>" loading="lazy" decoding="async">
                                <div class="img-overlay">
                                    <h3><?= htmlspecialchars($name) ?></h3>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <?php if ($articles_result && $articles_result->num_rows > 0): ?>
                <h3 style="margin-top:20px;">Hasil dari artikel/DB</h3>
                <div class="articles-grid">
                    <?php while ($article = $articles_result->fetch_assoc()): ?>
                        <div class="article-card">
                            <div class="article-top">
                                <h3><?= htmlspecialchars($article['title']) ?></h3>
                                <p class="article-preview">
                                    <?= htmlspecialchars(substr($article['content'], 0, 150)) ?>...
                                </p>
                            </div>
                            <div class="article-bottom">
                                <div class="article-meta">
                                    <span style="color: black;">📝 <?= htmlspecialchars($article['author']) ?></span>
                                </div>
                                <a href="article.php?id=<?= $article['id'] ?>" class="btn btn-read btn-detail">Baca Selengkapnya</a>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </section>
</main>

<?php include '../includes/footer.php'; ?>