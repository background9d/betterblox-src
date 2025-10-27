<?php require_once($_SERVER['DOCUMENT_ROOT'].'/dacore/head.php'); 
if ($_USER['user_admin'] !== "Administrator")
?>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') { if(!$fixlol){
    $username = $_POST["username"];
    $count = $_POST["count"];

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $usertogift = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usertogift) {
        $sql = "UPDATE users SET tix = tix + :count WHERE username = :username";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':count', $count, PDO::PARAM_INT);
        $stmt->bindParam(':username', $usertogift['username']);
        $stmt->execute();

        echo "<h1>Successfully gifted " . $usertogift['username'] . " " . $count . " Tickets</h1>";
    } else {
        echo "<h1>User not found</h1>";
    }
}else{die("kys 101 you testosterone nuthead");}
}
?>
<title>
  <?=$sitename?> - Gift Tix
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