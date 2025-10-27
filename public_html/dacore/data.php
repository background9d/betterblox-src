<?php
require 'db.php';
  
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$con = $db;

function generateSessionCookie($userId, $con) {
    $token = bin2hex(random_bytes(32));
    $created = time();

    $stmt = $con->prepare("INSERT INTO sessions (sessKey, userId, created) VALUES (:sessKey, :userId, :created)");
    $stmt->execute([
        ':sessKey' => $token,
        ':userId' => $userId,
        ':created' => $created
    ]);

    setcookie("session_token", $token, $created + 86400, "/", "", false, true);
}

$_USER = null;
$loggedin = false;

if (isset($_COOKIE['session_token'])) {
    $token = $_COOKIE['session_token'];

    $stmt = $con->prepare("SELECT users.* FROM users 
        JOIN sessions ON users.id = sessions.userId 
        WHERE sessions.sessKey = :sessKey LIMIT 1");
    $stmt->execute([':sessKey' => $token]);
    $_USER = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($_USER) {
        $loggedin = true;
    }
}

$errors = 0;
if($errors == 1){
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
}else{
    error_reporting(0);
    ini_set('display_errors', 0);
}  


$sitename = "BETTERBLOX";
$logo = "/images/bttrblx.png";
$descrp = "A FREE Virtual World-Building Game with Avatar Chat, 3D Environments, and Physics";
$domain = "test1.betterblox.xyz";
$favicon = "";