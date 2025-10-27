<?php require_once($_SERVER['DOCUMENT_ROOT'].'/dacore/head.php'); 
if ($_USER['user_admin'] !== "Administrator")
?>
<title>
  <?=$sitename?> - Give Money
</title>
<center>
<a href="index.php"><h1 style="color: black;">< Back</h1></a>
    <a style="color: blue;" href="givebux.php">BETTERBUX</a><br>
    <a style="color: blue;" href="givetux.php">TICKETS</a><br>
</center>
<?php require_once($_SERVER['DOCUMENT_ROOT'].'/dacore/foot.php'); ?>