<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/dacore/head.php');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($con)) {
    die("Error:NO CONNECTION TO DB");
}

if (!isset($_USER) || ($_USER['user_admin'] !== 'Administrator' && $_USER['user_admin'] !== 'Moderator')) {
    die("No admin, NO PASS!!");
}

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);

    if ($username === "") {
        $message = "<p style='color:red;'>You need to type an User Name</p>";
    } else {
        $stmt = $con->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->execute([':username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            $message = "<p style='color:red;'>User <b>{$username}</b> not found.</p>";
        } elseif ($user['bantype'] === 'None') {
            $message = "<p style='color:orange;'>The user <b>{$username}</b> isn't banned</p>";
        } else {
            $stmt = $con->prepare("UPDATE users SET bantype = 'None', bandate = NULL, bannote = '' WHERE id = :id");
            $stmt->execute([':id' => $user['id']]);
            $message = "<p style='color:green;'>User <b>{$username}</b> has been unbanned Yay!</p>";
        }
    }
}
?>
<title>
  <?=$sitename?> - Unban User
</title>
<center>
<a href="index.aspx"><h1 style="color: black;">< Back</h1></a>
<h2>Unban user</h2>
<?= $message; ?>

<form method="POST" style="margin-top:15px;">
    <label>Username:</label><br>
    <input type="text" name="username" required><br><br>

    <button type="submit">Unban User!</button>
</form>
<center>
<?php require_once($_SERVER['DOCUMENT_ROOT'].'/dacore/foot.php'); ?>