<?php
require_once __DIR__ . '/../config/config.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$loggedIn = false;
$sessionUsername = '';
if (function_exists('isLoggedIn') && isLoggedIn()) {
    $loggedIn = true;
    $sessionUsername = $_SESSION['username'] ?? '';
}

//Verifikasi Login

if (!$loggedIn) {
    header('Location: ../auth/login.php');
    exit;
}
?>
<?php include __DIR__ . '/../includes/header.php'; ?>

<?php include __DIR__ . '/../includes/navbar.php'; ?>

<main class="container">
    <div class="form-container" style="max-width:700px;">
        <h2 style="text-align:center;">🎮 Tebak Karakter</h2>

        <div class="game-container" style="padding:30px;margin-top:20px;">
            <div class="img-box" style="width:100%;max-width:420px;height:420px;margin:0 auto 20px;border-radius:12px;overflow:hidden;">
                <img src="" id="gameImage" style="width:100%;height:100%;object-fit:cover;filter:blur(20px) brightness(0.7);transition:0.25s;">
            </div>

            <div class="options" style="display:grid;grid-template-columns:repeat(2,1fr);gap:12px;">
                <button onclick="checkAnswer(0)" id="btn0" class="btn btn-read"></button>
                <button onclick="checkAnswer(1)" id="btn1" class="btn btn-read"></button>
                <button onclick="checkAnswer(2)" id="btn2" class="btn btn-read"></button>
                <button onclick="checkAnswer(3)" id="btn3" class="btn btn-read"></button>
            </div>

                <div style="text-align:center;margin-top:18px;">
                    <div class="result" id="resultText" style="font-weight:700;margin-bottom:8px;color:#2c3e50"></div>
                    <div class="score">Jumlah Benar: <span id="score">0</span></div>

                    <div class="game-actions">
                        <a href="index.php" class="btn-secondary" id="backBtn">⬅ Kembali ke Beranda</a>
                        <button type="button" class="featured-btn" onclick="nextQuestion()" id="nextBtn">Next ➡️</button>
                    </div>
                </div>
        </div>
    </div>
</main>

<script>
    const characters = [
        "All_Might_Portrait.jpg",
        "Eijiro_Kirishima_Portrait.jpg",
        "Hanta_Sero_Portrait.jpg",
        "Hiryu_Rin_Portrait.jpg",
        "Hitoshi_Shinso_Portrait.jpg",
        "Izuku_Midoriya_Portrait.jpg",
        "Juzo_Honenuki_Portrait.jpg",
        "Kinoko_Komori_Portrait.jpg",
        "Kosei_Tsuburaba_Portrait.jpg",
        "Mina_Ashido_Portrait.jpg",
        "Neito_Monoma_Portrait.jpg",
        "Ochaco_Uraraka_Portrait.jpg",
        "Reiko_Yanagi_Portrait.jpg",
        "Rikido_Sato_Portrait.jpg",
        "Sen_Kaibara_Portrait.jpg",
        "Shoto_Todoroki_Portrait.jpg",
        "Tenya_Ida_Portrait.jpg",
        "Tsuyu_Asui_Portrait.jpg",
        "Yosetsu_Awase_Portrait.jpg",
        "Minoru_Mineta_Portrait.jpg"
    ];

    function shuffle(array) {
        for (let i = array.length - 1; i > 0; i--) {
            let j = Math.floor(Math.random() * (i + 1));
            [array[i], array[j]] = [array[j], array[i]];
        }
    }

    shuffle(characters);

    let current = 0;
    let score = 0;

    const gameImage = document.getElementById("gameImage");
    const resultText = document.getElementById("resultText");
    const scoreText = document.getElementById("score");

    const buttons = [
        document.getElementById("btn0"),
        document.getElementById("btn1"),
        document.getElementById("btn2"),
        document.getElementById("btn3")
    ];

    function getNameFromFile(file) {
        return file.replace("_Portrait.jpg", "").replace(/_/g, " ");
    }

    function getRandomOptions(correctName) {
        let options = [correctName];
        while (options.length < 4) {
            let rnd = characters[Math.floor(Math.random() * characters.length)];
            let name = getNameFromFile(rnd);

            if (!options.includes(name)) {
                options.push(name);
            }
        }

        // acak pilihan jawaban
        shuffle(options);
        return options;
    }

    function loadQuestion() {
        const file = characters[current];
        const correctName = getNameFromFile(file);

        gameImage.src = "../assets/game/" + file;
        gameImage.classList.remove("show");
        gameImage.style.filter = 'blur(20px) brightness(0.7)';
        resultText.textContent = "";

        const options = getRandomOptions(correctName);

        for (let i = 0; i < 4; i++) {
            buttons[i].textContent = options[i];
            buttons[i].disabled = false;
            buttons[i].style.background = "#2c3e50";
            buttons[i].setAttribute("data-answer", options[i]);
        }
    }

    function checkAnswer(index) {
        const file = characters[current];
        const correctName = getNameFromFile(file);
        const chosen = buttons[index].getAttribute("data-answer");

        if (chosen === correctName) {
            resultText.textContent = "✅ Benar! GG!";
            // reveal the image (remove blur)
            gameImage.classList.add("show");
            gameImage.style.filter = 'blur(0px) brightness(1)';
            score += 1;
            scoreText.textContent = score;
        } else {
            resultText.textContent = "❌ Salah!";
        }

        buttons.forEach(btn => btn.disabled = true);
    }

    function nextQuestion() {
        current++;
        if (current >= characters.length) {
            showPopup("Game selesai! Score kamu: " + score, {
                primaryText: 'Simpan',
                primaryCallback: function(){
                    saveHighscore(score).then(()=>{
                        shuffle(characters);
                        current = 0;
                        score = 0;
                        scoreText.textContent = 0;
                        loadQuestion();
                    });
                },
                secondaryText: 'Tutup',
                secondaryCallback: function(){
                    shuffle(characters);
                    current = 0;
                    score = 0;
                    scoreText.textContent = 0;
                    loadQuestion();
                }
            });
            return;
        }
        loadQuestion();
    }

    // Mulai game
    loadQuestion();
    
    (function(){
        const modalHtml = `
        <div id="popupModal" style="display:none;position:fixed;left:0;top:0;width:100%;height:100%;background:rgba(0,0,0,0.6);align-items:center;justify-content:center;z-index:9999;">
            <div style="background:#fff;padding:20px;border-radius:8px;max-width:480px;width:92%;box-shadow:0 10px 30px rgba(0,0,0,0.2);">
                <div id="popupMessage" style="color:#1a1a1a;font-size:1rem;line-height:1.5;margin-bottom:14px;"></div>
                <div style="text-align:right;margin-top:6px;">
                    <button id="popupSecondary" class="btn" style="margin-right:8px;background:transparent;border:1px solid #e6e6e6;color:#333;padding:8px 12px;border-radius:8px;">Tutup</button>
                    <button id="popupPrimary" class="btn btn-primary" style="padding:8px 14px;">OK</button>
                </div>
            </div>
        </div>`;
        document.body.insertAdjacentHTML('beforeend', modalHtml);
    })();

    function showPopup(message, opts){
        opts = opts || {};
        const modal = document.getElementById('popupModal');
        const msg = document.getElementById('popupMessage');
        const primary = document.getElementById('popupPrimary');
        const secondary = document.getElementById('popupSecondary');
        msg.textContent = message;
        primary.textContent = opts.primaryText || 'OK';
        secondary.textContent = opts.secondaryText || 'Tutup';
        primary.onclick = function(){ modal.style.display='none'; if(typeof opts.primaryCallback === 'function') opts.primaryCallback(); };
        secondary.onclick = function(){ modal.style.display='none'; if(typeof opts.secondaryCallback === 'function') opts.secondaryCallback(); };
        modal.style.display = 'flex';
    }
    async function saveHighscore(finalScore) {
        try {
            let username = "";
            const loggedIn = <?= $loggedIn ? 'true' : 'false' ?>;
            const sessionUsername = <?= json_encode($sessionUsername) ?>;

            if (loggedIn && sessionUsername) {
                username = sessionUsername;
            } else {
                username = prompt("Isi nama untuk leaderboard (guest):", "Guest");
                if (username === null) username = "Guest"; 
                username = username.trim();
                if (username === "") username = "Guest";
            }

            const payload = {
                score: finalScore,
                username: username
            };

            const res = await fetch('save_score.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(payload)
            });

            const data = await res.json();
            if (data.status === 'success') {
                showPopup('Score disimpan ke leaderboard! 🎉', { primaryText: 'OK' });
            } else {
                showPopup('Gagal simpan score: ' + data.message, { primaryText: 'OK' });
            }
        } catch (err) {
            console.error(err);
            showPopup('Terjadi error saat menyimpan score.');
        }
    }
</script>

<?php include __DIR__ . '/../includes/footer.php'; ?>
