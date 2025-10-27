<?php require_once($_SERVER['DOCUMENT_ROOT'].'/dacore/head.php'); 
if ($_USER['user_admin'] !== "Administrator")
?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') { if(!$fixedlol){
    $username = $_POST["username"];
    $count = $_POST["count"];

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $usertogift = $stmt->fetch(PDO::FETCH_ASSOC);

    $stmt = $conn->prepare("UPDATE users SET bux = bux + ? WHERE username = ?");
    $stmt->execute([$count, $usertogift["username"]]);

    echo "<h1>Successfully gifted " . $usertogift['username'] . " " . $count . " RLBUX</h1>";
}else{die("not funny you testosterone-nut");}
}
?>
<title>
  <?=$sitename?> - Gift <?=$bux?>
</title>
<center>
<a href="giftcurrency.aspx"><h1 style="color: black;">< Back</h1></a>
<form method="POST" action="">
    <input type="text" name="username" placeholder="Username to gift">
    <input type="text" name="count" placeholder="How many">
    <input type="submit" name="submit" value="Gift">
</form>
</center>
<?php require_once($_SERVER['DOCUMENT_ROOT'].'/dacore/foot.php'); ?>