<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'bokunoresponsi');
define('BASE_URL', '/bokunopemwebacademia-main/public/');
define('ADMIN_URL', '/bokunopemwebacademia-main/admin/');

$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($mysqli->connect_errno) {
    error_log("DB connect error: " . $mysqli->connect_error);
    die("Koneksi database gagal. Cek konfigurasi.");
}
$mysqli->set_charset("utf8mb4");
$conn = $mysqli; 
function isLoggedIn()
{
    return isset($_SESSION['user_id']);
}

function isAdmin()
{
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}

function redirect($url)
{
    if (filter_var($url, FILTER_VALIDATE_URL)) {
        header("Location: " . $url);
    } else {
        header("Location: " . BASE_URL . ltrim($url, '/'));
    }
    exit();
}

function redirectAdmin($url)
{
    if (filter_var($url, FILTER_VALIDATE_URL)) {
        header("Location: " . $url);
    } else {
        header("Location: " . ADMIN_URL . ltrim($url, '/'));
    }
    exit();
}

function sanitize($data)
{
    if (is_array($data)) {
        return array_map('sanitize', $data);
    }
    $data = trim($data);
    $data = str_replace("\0", '', $data);
    return $data;
}
