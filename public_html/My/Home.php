<?php
// include header (keeps your CSS + scripts)
include $_SERVER["DOCUMENT_ROOT"]."/dacore/head.php";

// Safe defaults so PHP doesn't throw notices
if (!isset($_USER)) $_USER = [];
if (!isset($_USER['username'])) $_USER['username'] = 'Guest';
if (!isset($_USER['id'])) $_USER['id'] = 0;
if (!isset($_USER['user_admin'])) $_USER['user_admin'] = '';
if (!isset($_USER['buildersclub'])) $_USER['buildersclub'] = 0;

if (!isset($sitename)) $sitename = 'BetterBlox';
if (!isset($sitelink)) $sitelink = $_SERVER['HTTP_HOST'];
if (!isset($bux)) $bux = 'R$';
if (!isset($message)) $message = 0;
if (!isset($db)) $db = null; // if DB not provided, queries will be skipped
if (!isset($total)) $total = 0;
?>
<title>
  Home - <?=$sitename?>
</title>
<div id="Body">
<div id="UserContainer">
  <div id="LeftBank">
    <div id="ProfilePane">
      <table width="100%" bgcolor="lightsteelblue" cellpadding="6" cellspacing="0">
        <tr>
          <td>
            <span class="Title">Hi, <?=htmlspecialchars($_USER['username'])?>!</span><br>
          </td>
        </tr>
        <tr>
          <td>
            <span>Your <?=$sitename?>:</span><br>
            <a href="/User.aspx?ID=<?=intval($_USER['id'])?>">https://<?=htmlspecialchars($sitelink)?>/User.aspx?ID=<?=intval($_USER['id'])?></a>
            <br><br>

            <div style="left:0; float:left; position:relative; top:0; margin-top:67px; margin-left:10px;">
              <a title="<?=htmlspecialchars($_USER['username'])?>" style="display:inline-block;height:220px;width:180px;">
                <img src="/renders/render_user_<?=intval($_USER['id'])?>.png" 
                     border="0" 
                     style="height:200px;width:180px;" 
                     alt="<?=htmlspecialchars($_USER['username'])?>">
              </a><br>
            </div>

            <div style="float:right;text-align:left;width:210px;">
              <p><a href="/My/Messages/Inbox.aspx">Inbox (<?=intval($message)?>)</a></p>
              <p><a href="/My/Character.aspx">Change Character</a></p>
              <p><a href="/My/EditProfile.aspx">Edit Profile</a></p>
              <p><a href="/DiscordVerify.aspx">Verify With Discord</a></p>
              <p><a href="/Upgrades/BuildersClub.aspx">Account Upgrades</a></p>
              <p><a href="/My/AccountBalance.aspx">Account Balance</a></p>
              <p><a href="/User.aspx?ID=<?=intval($_USER['id'])?>">View Public Profile</a></p>
              <p><a href="/My/InviteAFriend.aspx">Share <?=$sitename?></a></p>
              <p><a href="/Upgrades/Rlbux.aspx">Buy <?=$bux?></a></p>
              <p><a href="/My/TradeCurrency.aspx">Trade Currency</a></p>
              <p><a href="/info/TermsOfService.aspx">Terms, Conditions, and Rules</a></p>
            </div>
          </td>
        </tr>
      </table>
    </div>

<div id="UserBadgesPane">
  <div id="UserBadges">
    <h4><a href="/Badges.aspx">Badges</a></h4>

    <div style="display:flex; gap:10px; flex-wrap:wrap; justify-content:center;">

      <?php
      $hasBadge = false;

      if ($_USER["user_admin"] === "Administrator") {
          $hasBadge = true;
          ?>
          <div class="Badge">
            <div class="BadgeImage">
              <img src="/images/Badges/BBadge.png" width="75" height="75" title="This badge is given to administrators on the site." alt="Administrator">
            </div>
            <div class="BadgeLabel"><a href="/Badges.aspx">Administrator</a></div>
          </div>
      <?php }

      if ($_USER["user_admin"] === "beta_tester") {
          $hasBadge = true;
          ?>
          <div class="Badge">
            <div class="BadgeImage">
              <img src="/images/Badges/beta.jpg" width="75" height="75" title="This badge is awarded to Beta Testers who helped test <?=$sitename?> before release." alt="Beta Tester">
            </div>
            <div class="BadgeLabel"><a href="/Badges.aspx">Beta Tester</a></div>
          </div>
      <?php }

      if ((int)$_USER["buildersclub"] === 1) {
          $hasBadge = true;
          ?>
          <div class="Badge">
            <div class="BadgeImage">
              <img src="/images/Badges/BuildersClub-75x75.png" width="75" height="75" title="This badge is given to people who have Builders Club!!" alt="Builders Club">
            </div>
            <div class="BadgeLabel">
               <div class="BadgeLabel"><a href="/Badges.aspx">Builders Club</a></div>
            </div>
          </div>
      <?php }

      if (!$hasBadge) { ?>
        <p>This user doesn't have any <?=$sitename?> badges.</p>
      <?php } ?>

    </div>
  </div>
</div>
    <div id="UserStatisticsPane" style="margin-bottom: 0px;">
        <div id="UserStatistics">
          <div id="StatisticsPanel" style="transition: height 0.5s ease-out; overflow: hidden; height: 200px;">
            <h4>Statistics</h4> 
            <div style="margin: 10px 10px 150px 10px;" id="Results">
              <div class="Statistic"><div class="Label">Friends:</div><div class="Value"><span>? (? last week)</span></div></div>
              <div class="Statistic"><div class="Label">Forum Posts:</div><div class="Value"><span>? (? last week)</span></div></div>
              <div class="Statistic"><div class="Label">Profile Views:</div><div class="Value"><span>? (? last week)</span></div></div>
              <div class="Statistic"><div class="Label">Place Visits:</div><div class="Value"><span>? (? last week)</span></div></div>
              <div class="Statistic"><div class="Label">Model Views:</div><div class="Value"><span>? (? last week)</span></div></div>
              <div class="Statistic"><div class="Label">Knockouts:</div><div class="Value"><span>? (? last week)</span></div></div>
              <div class="Statistic"><div class="Label">Wipeouts:</div><div class="Value"><span>? (? last week)</span></div></div>
            </div>
          </div>
        </div>
      </div>
    </div>

  <div id="RightBank">
    <div id="UserPlacesPane">
      <p style="padding:10px;">Places soon!</p>
    </div>

   <div id="FriendsPane"><div id="Friends">
          <?php
// Friends section: only try DB queries if $db is a real PDO
if ($db instanceof PDO) {
    $frs = $db->prepare("SELECT * FROM friends WHERE (sent_to=:id AND accepted=1) OR (sent_from=:id AND accepted=1) LIMIT 0, 6");
    $frs->execute([':id' => $_USER['id']]);

    $frss = $db->prepare("SELECT * FROM friends WHERE (sent_to=:id AND accepted=1) OR (sent_from=:id AND accepted=1)");
    $frss->execute([':id' => $_USER['id']]);
    $friendss = $frss->rowCount();
} else {
    // fallback if no DB: empty result behavior
    $frs = null;
    $friendss = 0;
}

$maxRows = 6;
$roww = 0;
?>

<h4>My friends <a href="/Friends.aspx?UserID=<?=intval($_USER['id'])?>">See all <?= intval($friendss) ?></a> (<a href="/My/EditFriends.aspx">Edit</a>)</h4>
<table cellspacing="0" align="center" border="0" style="border-collapse:collapse;">
    <tbody>
        <tr>
            <?php
            if (!$frs || $frs->rowCount() < 1) {
                echo ("<p style='padding: 10px 10px 10px 10px;'>You don't have any $sitename friends.</p>");
            } else {
                while ($b = $frs->fetch(PDO::FETCH_ASSOC)) {
                    if ($b['sent_from'] == $_USER['id']) {
                        $friendid = $b['sent_to'];
                    } else {
                        $friendid = $b['sent_from'];
                    }
                    $userq = $db->prepare("SELECT * FROM users WHERE id=:id");
                    $userq->execute([":id" => $friendid]);
                    $row = $userq->fetch(PDO::FETCH_ASSOC);

                    // make sure $row exists
                    if (!$row) continue;

                    $lastseen = isset($row['lastseen']) ? (int)$row['lastseen'] : 0;
                    $onlinetest = ($lastseen + 300 <= time()) ? "<img src=\"/images/Offline.gif\" style=\"border-width:0px;\">" : "<img src=\"/images/Online.gif\" style=\"border-width:0px;\">";

                    echo "<td><div class=\"Friend\">
                        <div class=\"Avatar\">
                            <a title=\"" . htmlspecialchars($row['username']) . "\" href=\"/User.aspx?ID=" . intval($friendid) . "\" style=\"display:inline-block;max-height:100px;max-width:100px;cursor:pointer;\">
                                <img src=\"/images/AvatarPlaceholder" . intval($row['id']) . ".png?rand=" . random_int(1, 999999999) . "\" width=\"95\" border=\"0\" alt=\"" . htmlspecialchars($row['username']) . "\" blankurl=\"http://t6.roblox.com:80/blank-100x100.gif\">
                            </a>
                        </div>
                        <div class=\"Summary\">
                            <span class=\"OnlineStatus\">$onlinetest</span>

                            <span class=\"Name\"><a href=\"/User.aspx?ID=" . intval($friendid) . "\">" . htmlspecialchars($row['username']) . "</a></span>
                        </div>
                    </div></td>";

                    $roww++;

                    if ($roww >= 3) {
                        echo "</tr><tr>";
                        $roww = 0;
                    }
                }
            }
            ?>
        </tr>
    </tbody>
</table>

<style>
fix {
    display: table-cell;
    vertical-align: inherit;
}
</style>
<table cellspacing="0" align="Center" border="0" style="border-collapse:collapse;width: 360px;">
          <tbody><tr></tr>
          <tr>
                    </tr>

        </tbody></table>
              </div>

    </div>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <div id="FavoritesPane">
      <div id="Favorites">
        <h4>Favorites</h4>
        <div id="FavoritesContent">This user does not have any favorites for this type</div>
        <div class="PanelFooter">
          Category:&nbsp;
          <select id="FavCategories">
            <option value="7">Heads</option>
            <option value="8">Faces</option>
            <option value="2">T-Shirts</option>
            <option value="5">Shirts</option>
            <option value="6">Pants</option>
            <option value="1">Hats</option>
            <option value="4">Decals</option>
            <option value="3">Models</option>
            <option selected value="0">Places</option>
          </select>
        </div>
      </div>
    </div>

    <div id="FriendRequestsPane">
    <div id="FriendRequests">
      <span id="FriendRequestsHeaderLabel"><h4>My Friend Requests</h4></span>

      <table cellspacing="0" border="0" style="border-collapse:collapse;">
        <tbody><tr>
            <?php
if ($db instanceof PDO) {
    $frsReq = $db->prepare("SELECT * FROM friends WHERE sent_to=:id AND accepted=0 AND declined=0");
    $frsReq->execute([':id' => $_USER['id']]);

    if ($frsReq->rowCount() < 1) {
      echo ("<p style='padding: 10px 10px 10px 10px;'>You don't have any $sitename Friend Requests.</p>");
    }

    while ($frz = $frsReq->fetch(PDO::FETCH_ASSOC)) {
      $stmt = $db->prepare("SELECT * FROM users WHERE id=:sent_id");
      $stmt->bindParam(':sent_id', $frz['sent_from']);
      $stmt->execute();
      $userar = $stmt->fetch(PDO::FETCH_ASSOC);

      if (!$userar) continue;

      $lastseen2 = isset($userar['lastseen']) ? (int)$userar['lastseen'] : 0;
      $onlinetestReq = ($lastseen2 + 300 <= time()) ? "<img src=\"/images/Offline.gif\" style=\"border-width:0px;\">" : "<img src=\"/images/Online.gif\" style=\"border-width:0px;\">";

      echo "<td>
            <div class='Friend'>
              <div class='Avatar'>
<a href='/My/FriendInvitation.aspx?ID=" . intval($frz['id']) . "'> <img height='100' src='/renders/render_user_" . intval($userar['id']) . ".png?rand=" . random_int(1,999999999) . "'> </a>
                
              </div>
              <div class='Summary'>
                              <span class=\"OnlineStatus\">$onlinetestReq</span>
                <span class='Name'>
                  <a title='Click to view this invitation' href='/My/FriendInvitation.aspx?ID=" . intval($frz['id']) . "'>" . htmlspecialchars($userar['username']) . "</a><br>    <br>
                </span>
              </div>
            </div>
          </td>";
    }
}
            ?>
      </tr>
      </tbody></table>
    </div>
  </div>
    </div>
  </div>



        </div>
<style>
#ProfilePane { background: #aec0d9; }
#UserPlaces h4 {
  background-color: #6e99c9;
  color: #fff;
  font-family: Verdana,Sans-Serif;
  font-size: 1.4em;
  letter-spacing: .1em;
  margin: 0;
}
#UserBadgesPane h4, #UserStatisticsPane h4, #FavoritesPane h4 {
  background-color: #ccc;
  border-bottom: solid 1px #000;
  color: #333;
  font-family: Comic Sans MS,Verdana,Sans-Serif;
  margin: 0;
  text-align: center;
}
#FriendsPane, #FavoritesPane {
  clear: right;
  margin: 10px 0 0;
  background: #fff;
}
#FavoritesPane { color: #000; border: solid 1px #000; }
#FavoritesContent { background: #eee; }
#Favorites .PanelFooter {
  background-color: #fff;
  border-top: solid 1px #000;
  text-align: center;
  padding: 3px;
}
.BadgeImage img {
  border-radius: 6px;
  border: 1px solid #777;
  background: #f8f8f8;
}
</style>

<?php
// include footer (keeps site-wide footer)
include $_SERVER["DOCUMENT_ROOT"]."/dacore/foot.php";
?>
