<?php require_once($_SERVER['DOCUMENT_ROOT'].'/dacore/head.php'); 
if (!isset($_USER) || ($_USER['user_admin'] !== 'Administrator' && $_USER['user_admin'] !== 'Moderator')) {
    die("No admin, NO PASS!");
}

?>
<title>
  <?=$sitename?> - Administrator Page
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
<br>
<div id="ItemContainer">
    <h2>da Admin Panel</h2>
    <div id="Item">
        
<center>

<h3>Users</h3>
<a href="ban.aspx">Moderate User</a>
<br>
<a href="unban.aspx">Unmoderate User</a>
<br>
<a href="giveadmin.aspx">Give admin (DO IT IF THE OWNER ALLOWS)</a>
<br>
<a href="giftcurrency.aspx">Give money</a>

<br>
<br>

<h3>Site</h3>
<a href="keygenerate.aspx">Generate Invite Keys</a>
<br>
<a href="maintenance.aspx">Manage Maintenance</a>
<br>
</center>

        </div>

    </div>

<?php require_once($_SERVER['DOCUMENT_ROOT'].'/dacore/foot.php'); ?>