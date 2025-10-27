<?php require_once($_SERVER['DOCUMENT_ROOT'].'/dacore/head.php'); 
if (!isset($_USER) || ($_USER['user_admin'] !== 'Administrator' && $_USER['user_admin'] !== 'Moderator')) {
    die("No admin, NO PASS!");
}

?>
<title>
  <?=$sitename?> - Give Permissions
</title>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') { if(!$fixlol){
    $usertogive = str_replace("'","",$_POST['usertogive']);
    $usertogive = str_replace('"',"",$usertogive);
    $givetype = $_POST["admintype"];

    $sql = "UPDATE users SET user_admin = :givetype WHERE username = :usertogive";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':givetype', $givetype);
    $stmt->bindParam(':usertogive', $usertogive);
    $stmt->execute();
}else{die("What happened? the user doesn't have admin LOL");}
}

?>
<center>
    <a href="index.php"><h1 style="color: black;">< Back</h1></a>
    <form method="POST" action="">
    <input name="usertogive" type="text" tabindex="1" class="Text" placeholder="User to promote"><br>
    <input name="admintype" type="text" tabindex="1" class="Text" placeholder="Type"><br>
    <h5>Put None or Administrator on Type</h5>
    <input type="submit" value="Give" tabindex="4" class="Button" name="submit">
    </form>
</center>
<?php require_once($_SERVER['DOCUMENT_ROOT'].'/dacore/foot.php'); ?>