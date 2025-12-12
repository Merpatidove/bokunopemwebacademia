<?php
require_once __DIR__ . '/../config/config.php';

header('Content-Type: application/json');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


$raw = file_get_contents('php://input');
$input = json_decode($raw, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid JSON']);
    exit;
}

if (!isset($input['score'])) {
    echo json_encode(['status' => 'error', 'message' => 'Missing score']);
    exit;
}

$score = (int)$input['score'];
$username = trim($input['username'] ?? 'Guest');
if ($username === '') $username = 'Guest';

$user_id = null;
if (isset($_SESSION['user_id'])) {
    $user_id = (int)$_SESSION['user_id'];
    if (!empty($_SESSION['username'])) {
        $username = $_SESSION['username'];
    }
}

if (!isset($conn) || !$conn) {
    echo json_encode(['status' => 'error', 'message' => 'DB not connected']);
    exit;
}

if ($user_id !== null) {
    $stmt = $conn->prepare("INSERT INTO highscores (user_id, username, score) VALUES (?, ?, ?)");
    if (!$stmt) {
        echo json_encode(['status' => 'error', 'message' => 'Prepare failed: ' . $conn->error]);
        exit;
    }
    $stmt->bind_param('isi', $user_id, $username, $score);
} else {
    $stmt = $conn->prepare("INSERT INTO highscores (username, score) VALUES (?, ?)");
    if (!$stmt) {
        echo json_encode(['status' => 'error', 'message' => 'Prepare failed: ' . $conn->error]);
        exit;
    }
    $stmt->bind_param('si', $username, $score);
}

if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Score saved']);
} else {
    echo json_encode(['status' => 'error', 'message' => $stmt->error ?: $conn->error]);
}
$stmt->close();
