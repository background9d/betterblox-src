<?php
require_once("peachepe.php");
error_reporting(0);
//error_reporting(E_ALL);
$host = 'mysql2.serv00.com';
$dbname = 'm4429_testt';
$username = 'm4429_better';
$password = 'BETTERBLOX11@d';

$loggedin = 'no';

try {
    $db = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $con = $db; //coneccion p insano
    $conn = $db;
} catch (PDOException $e) {
    echo "db connection failed: " . $e->getMessage();
}
?>
