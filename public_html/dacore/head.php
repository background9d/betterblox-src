<?php 

require('data.php');

if($loggedin == 'yes') {
    if($_USER['bantype'] !== 'None'){
        header("Location: /Membership/NotApproved.aspx");
    }
}

?>



<?php

if (isset($_USER['id'])) {
    $userId = $_USER['id'];

    $dailyReward = 15;

    $stmt = $con->prepare("SELECT tix, reward_tix FROM users WHERE id = :id");
    $stmt->execute([':id' => $userId]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    $now = time(); // timestamp lol
    $lastClaim = (int)$user['reward_tix'];

    // +24 hours
    if ($now - $lastClaim >= 86400) {
        $newTix = $user['tix'] + $dailyReward;

        $stmt = $con->prepare("UPDATE users SET tix = :tix, reward_tix = :now WHERE id = :id");
        $stmt->execute([
            ':tix' => $newTix,
            ':now' => $now,
            ':id' => $userId
        ]);
        
        echo '
        <div style="background:#ffeb9b; border:1px solid #d4a017; color:#000; text-align:center; font-family:Comic Sans MS; padding:5px; width:500px; margin:10px auto;">
            You received your <b>daily 15 Tix</b>! Come back tomorrow for more!
        </div>';
    }
}
?>
<?php
if ($_USER["buildersclub"] === "1")
if (isset($_USER['id'])) {
    $userId = $_USER['id'];

    $dailyReward = 50;

    $stmt = $con->prepare("SELECT bux, reward_bucks FROM users WHERE id = :id");
    $stmt->execute([':id' => $userId]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    $now = time();
    $lastClaim = (int)$user['reward_bucks'];

    if ($now - $lastClaim >= 86400) {
        $newTix = $user['bux'] + $dailyReward;

        $stmt = $con->prepare("UPDATE users SET bux = :bux, reward_bucks = :now WHERE id = :id");
        $stmt->execute([
            ':bux' => $newTix,
            ':now' => $now,
            ':id' => $userId
        ]);
        
        echo '
        <div style="background:#0084ffff; border:1px solid #000000ff; color:#000; text-align:center; font-family:Comic Sans MS; padding:5px; width:500px; margin:10px auto;">
            You received your <b>daily 50 Bux</b>! Come back tomorrow for more!
        </div>';
    }
}
?>
<?php
 $message = 0;

if (isset($_USER['id'])) {
    $stmt = $db->prepare("
        SELECT COUNT(*) 
        FROM messages 
        WHERE readto = 0 
        AND user_to = :user_to
    ");
    $stmt->execute([':user_to' => $_USER['id']]);
    $message = (int)$stmt->fetchColumn();
}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" id="www-roblox-com">
<link id="ctl00_Imports" rel="stylesheet" type="text/css" href="/css/AllCSS.css"/><link rel="icon" type="image/vnd.microsoft.icon" href="<?=$favicon?>"/>
            </script>
<script src="/ScriptResource.axd" type="text/javascript"></script> 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="/CSS/Tabs.css?v=<?php echo rand(1,9999); ?>" />
    <script src="/CSS/Tabs.js" type="text/javascript"></script>
        </head>
  <body>
    
      <div id="Container">
</div><br>

        
        <div id="AdvertisingLeaderboard">

</div>
         <div id="Header">
          <div id="Banner">
            <div id="Options">
              <div id="Authentication">
  <?php if($loggedin == "yes"){ ?> Logged in as <?=htmlspecialchars($_USER['username'])?> &nbsp;<strong>|</strong>&nbsp;<a href="/LogoutRequest.aspx">Logout</a> <?php } else { ?> <a id="ctl00_BannerOptionsLoginView_BannerOptions_Anonymous_LoginHyperLink" href="/Login/Default.aspx">Login</a> <?php } ?>
              </div><?php if($loggedin == "yes"){ ?><div id="Settings">
              Age 13+, Chat Mode: Filter              </div><?php } ?>
            </div>
            <div id="Logo"><a id="ctl00_rbxImage_Logo" title="<?=$sitename?>" href="<?php echo $siteurl; ?>/" style="display:inline-block;cursor:pointer;"><img style="width:257px;height:67px;" src="<?=$logo?>" border="0" id="img" alt="<?=$sitename?>" blankurl="http://t2.roblox.com:80/blank-267x70.gif" class="thebannerlogo"/></a>
            </div>
            <div id="Alerts">
              <table style="width:100%;height:100%">
                <tr>
                    <?php if($loggedin == "yes") { ?>
                  <td valign="middle">
                                        <table style="width:123%;height:101%;padding-right:20px;">
                <tbody><tr>
                  <td valign="middle">
          
                    <div>
                     <div id="AlertSpace" style="background-opacity: 0.5">
                        <?php if($message > 0){ ?>
                          
                          <div id="MessageAlert">
                              <a class="TicketsAlertIcon"><img src="/images/Message.gif" style="border-width:0px;"></a>&nbsp;
                              <a href="/My/Messages/Inbox.aspx" class="TicketsAlertCaption"><?=$message?> New Messages!</a>
                            </div>
                          
                          <?php } ?>
                          <?php if($_USER['bux'] > 0) { ?>
                         <div id="RobuxAlert">
    <a class="RobuxAlertIcon">
      <img src="/images/Robux.png" style="border-width:0px;">
    </a>&nbsp;
    <a href="/My/Accountbalance.aspx" class="RobloxAlertCaption" style="<?=$buxcolo?>">
      $_USER['bux']?> Rlbux</a>
    </a>
  </div>
            <?php } ?>
                          <div id="TicketsAlert">
                            <a class="TicketsAlertIcon"><img src="/images/Tickets.png" style="border-width:0px;"></a>&nbsp;
                            <a href="/My/Accountbalance.aspx" class="TicketsAlertCaption"><?=$_USER['tix']?> Tickets</a>
            </div> 
                  </div>
                      </div>
                    </div>
                  </td>
                      </tr>
                    </tbody></table>              
</td><?php } else { ?>
<td valign="middle">
            <a id="ctl00_rbxAlerts_SignupAndPlayHyperLink" class="SignUpAndPlay" href="/Login/NewAge.aspx"><img src="/images/SignupBannerV2.png" alt="Sign-up and Play!" border="0"></a>                          
</td>
<?php } ?>
                </tr>
              </table>
            </div>
          </div>

<div class="Navigation">
  <?php if($loggedin == "yes") { ?>
  <span><a id="ctl00_Menu_hlMyRoblox" class="MenuItem" href="/My/Home.aspx">My <?=$sitename?></a></span>
  <span class="Separator">&nbsp;|&nbsp;</span>
  <span><a id="ctl00_Menu_hlGames" class="MenuItem" href="/Games.aspx">Games</a></span>
  <span class="Separator">&nbsp;|&nbsp;</span>
  <span><a id="ctl00_Menu_hlCatalog" class="MenuItem" href="/Catalog.aspx">Catalog</a></span>
  <span class="Separator">&nbsp;|&nbsp;</span>
  <span><a id="ctl00_Menu_hlBrowse" class="MenuItem" href="/Browse.aspx">People</a></span>
  <span class="Separator">&nbsp;|&nbsp;</span>
    <span><a id="ctl00_Menu_hlBuildersClub" class="MenuItem" href="/Upgrades/BuildersClub.aspx">Builders Club</a></span>
  <span class="Separator">&nbsp;|&nbsp;</span>
  <?php } ?>
  <span><a id="ctl00_Menu_hlForum" class="MenuItem" href="/Forum/Default.aspx">Forum</a></span>
  <span class="Separator">&nbsp;|&nbsp;</span>
  <span><a id="ctl00_Menu_hlNews" class="MenuItem" href="https://blog.blxrl.xyz/" target="_blank">News</a>&nbsp;<a id="ctl00_Menu_hlNewsFeed" href="https://blog.blxrl.xyz/?feed=rss"><img src="/images/feed-icons/feed-icon-14x14.png" alt="RSS" border="0"/></a></span>
    <span class="Separator">&nbsp;|&nbsp;</span>  
  <span><a id="ctl00_Menu_hlForum" class="MenuItem" href="https://discord.gg/QCKccgQnKk" target="_blank">Discord</a>&nbsp;<a id="ctl00_Menu_hlNewsFeed" href=""><img src="/images/feed-icons/discord.png" alt="Discord" border="0"/></a></span>
 <?php if($_USER['user_admin'] == "Administrator"){?>
<span class="Separator">&nbsp;|&nbsp;</span>
  <span><a id="ctl00_Menu_hlBrowse" class="MenuItem" href="/admin/">Admin</a></span>
   <?php } ?>  
</div>
</div>
<div id="Body">