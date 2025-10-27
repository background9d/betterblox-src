<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/dacore/head.php'); 

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($con)) {
    die("Error:NO CONNECTION TO DB");
}


if (!isset($_USER) || ($_USER['user_admin'] !== 'Administrator' && $_USER['user_admin'] !== 'Moderator')) {
    die("No admin, NO PASS!");
}

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $bantype = $_POST['bantype'];
    $bannote = trim($_POST['bannote']);
    $bandate = date('Y-m-d H:i:s');

    if ($username === "") {
        $message = "<p style='color:red;'>Type the user's name</p>";
    } else {
        $stmt = $con->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->execute([':username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            $message = "<p style='color:red;'>User <b>{$username}</b> not found.</p>";
        } else {
            $stmt = $con->prepare("UPDATE users SET bantype = :bantype, bandate = :bandate, bannote = :bannote WHERE id = :id");
            $stmt->execute([
                ':bantype' => $bantype,
                ':bandate' => $bandate,
                ':bannote' => $bannote,
                ':id' => $user['id']
            ]);
            $message = "<p style='color:green;'> User <b>{$username}</b> has been banned with: <b>{$bantype}</b>.</p>";
        }
    }
}
?>
<title>
  <?=$sitename?> - Ban User
</title>
<style>
    #Item {
        font-family: Verdana, Sans-Serif;
        padding: 10px;
    }

    #ItemContainer {
        background-color: #eee;
        border: solid 1px #555;
        color: #555;
        margin: 0 auto;
        width: 620px;
    }

    #Actions {
        background-color: #fff;
        border-bottom: dashed 1px #555;
        border-left: dashed 1px #555;
        border-right: dashed 1px #555;
        clear: left;
        float: left;
        padding: 5px;
        text-align: center;
        min-width: 0;
        position: relative;
    }

    .PlayGames {
        background-color: #ccc;
        border: dashed 1px Green;
        color: Green;
        float: right;
        margin-top: 10px;
        padding: 10px 5px;
        text-align: right;
        width: 325px;
    }
</style>
<center>
<a href="index.aspx"><h1 style="color: black;">< Back</h1></a>
<h2>Ban users >:( 🔨</h2>
<?= $message; ?>

<form method="POST" style="margin-top:15px;">
    <label>User Name:</label><br>
    <input type="text" name="username" required><br><br>

    <label>Ban Type:</label><br>
    <select name="bantype" required>
        <option value="Ban">Banned forever</option>
        <option value="1dayban">1 Day</option>
        <option value="3dayban">3 Days</option>
        <option value="7dayban">7 Days</option>
        <option value="14dayban">14 Days</option>
        <option value="Warning">Warning</option>
        <option value="Reminder">Reminder</option>
    </select><br><br>

    <label>Ban Note:</label><br>
    <textarea name="bannote" rows="4" cols="40" placeholder="Type here"></textarea><br><br>

    <button type="submit">BAN HAMMER!!</button>
    <center>
</form>
<?php require_once($_SERVER['DOCUMENT_ROOT'].'/dacore/foot.php'); ?>

