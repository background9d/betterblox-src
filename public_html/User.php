<?php
require_once("dacore/head.php");

$id = isset($_GET['ID']) ? filter_var($_GET['ID'], FILTER_SANITIZE_NUMBER_INT) : 0;

$stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$id]);
$a = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$a) {
    if ($loggedin) {
        include("/My/Home.php");
    } else {
        header("Location: Browse.aspx");
    }
    exit;
}

$online = isset($a['lastseen']) && ($a['lastseen'] + 300 >= time());


?>

<title>
  <?= htmlspecialchars($a['username']) ?>'s Home Page
</title>
<div id="Body">
<div id="UserContainer">
    <div id="LeftBank">
      <div id="ProfilePane">
        <table width="100%" bgcolor="lightsteelblue" cellpadding="6" cellspacing="0">
          <tr>
            <td>
              <span class="Title"><?= htmlspecialchars($a['username']) ?></span><br>
              <span class="UserOnlineMessage">[ <?= $online ? 'Online' : 'Offline' ?> ]</span>
            </td>
          </tr>
          <tr>
            <td>
              <span><?= htmlspecialchars($a['username']) ?>'s <?= $sitename ?>:</span><br>
              <a href="/User.aspx?ID=<?= $a['id'] ?>">https://<?= htmlspecialchars($sitelink) ?>/User.aspx?ID=<?= $a['id'] ?></a><br><br>
              
              <table width="100%">
                <tr>
                  <td>
                    <a class="AvatarImage" title="<?= htmlspecialchars($a['username']) ?>" style="display:inline-block;">
                      <img src="/renders/render_user_<?= $a['id'] ?>.png" height="200" border="0" alt="Avatar">
                    </a><br>
                  </td>
                  <td>
                    <?php if ($loggedin == 'yes') { ?>
                      <p><a href="/My/PrivateMessage.aspx?RecipientID=<?= $a['id'] ?>">Send Message</a></p>
                      <p><a href="/api/userthing/addFriend.aspx?sentto=<?= $a['id'] ?>">Send Friend Request</a></p>
                    <?php } ?>
                    <p><span style="word-break: break-word;"><?= nl2br(htmlspecialchars($a['description'])) ?></span></p>
                  </td>
                </tr>
                <tr>
                  <td>
                    <a href="/AbuseReport.php?UserID=<?= $a['id'] ?>">
                      <span class="AbuseIcon"><img src="/images/abuse.gif" alt="Report Abuse" border="0"></span>
                    </a>
                    <a href="/AbuseReport.php?UserID=<?= $a['id'] ?>">
                      <span class="AbuseButton">Report Abuse</span>
                    </a>
                  </td>
                </tr>
              </table>
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

      if ($a["user_admin"] === "Administrator") {
          $hasBadge = true;
          ?>
          <div class="Badge">
            <div class="BadgeImage">
              <img src="/images/Badges/BBadge.png" width="75" height="75" title="This badge is given to administrators on the site." alt="Administrator">
            </div>
            <div class="BadgeLabel"><a href="/Badges.aspx">Administrator</a></div>
          </div>
      <?php }

      if ($a["user_admin"] === "beta_tester") {
          $hasBadge = true;
          ?>
          <div class="Badge">
            <div class="BadgeImage">
              <img src="/images/Badges/beta.jpg" width="75" height="75" title="This badge is awarded to Beta Testers who helped test <?=$sitename?> before release." alt="Beta Tester">
            </div>
            <div class="BadgeLabel"><a href="/Badges.aspx">Beta Tester</a></div>
          </div>

      <?php }
      if ((int)$a["buildersclub"] === 1) {
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
              <div class="Statistic"><div class="Label">Forum Posts:</div><div class="Value"><span>?</span></div></div>
              <div class="Statistic">
              <div class="Label"><acronym title="The number of times this user's profile has been viewed.">Profile Views</acronym>:</div>
              <div class="Value"><span>? (¿? last week)</span></div>
            </div>
              <div class="Statistic"><div class="Label">Place Visits:</div><div class="Value"><span>???</span></div></div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div id="RightBank">
      <div id="UserPlacesPane">
        <div id="UserPlaces">
          <p style="padding:10px">This person doesn't have any <?= $sitename ?> places.</p>
        </div>
      </div>

      <div id="Friends">
        <?php
        $friendsQuery = $db->prepare("
          SELECT * FROM friends 
          WHERE (sent_to = :uid OR sent_from = :uid)
          AND accepted = 1
        ");
        $friendsQuery->execute(['uid' => $a['id']]);
        $friends = $friendsQuery->fetchAll(PDO::FETCH_ASSOC);
        $friendsCount = count($friends);
        ?>

        <h4><?= htmlspecialchars($a['username']) ?>'s friends 
          <a href="/Friends.aspx?UserID=<?= $a['id'] ?>">See all <?= $friendsCount ?></a>
        </h4>

        <?php
        if ($friendsCount < 1) {
            echo "<p style='padding:10px;'>This person does not have any $sitename friends.</p>";
        } else {
            echo '<table cellspacing="0" align="center" border="0" style="border-collapse:collapse;"><tr>';
            $count = 0;

            foreach ($friends as $f) {
                $friendId = ($f['sent_from'] == $a['id']) ? $f['sent_to'] : $f['sent_from'];

                $userq = $db->prepare("SELECT id, username, lastseen FROM users WHERE id = :id");
                $userq->execute(['id' => $friendId]);
                $friend = $userq->fetch(PDO::FETCH_ASSOC);

                if (!$friend) continue;

                $isOnline = ($friend['lastseen'] + 300 >= time());
                $statusImg = $isOnline ? "/images/Online.gif" : "/images/Offline.gif";
                $statusAlt = $isOnline ? "Online" : "Offline";

                echo "
                <td>
                    <div class='Friend'>
                        <div class='Avatar'>
                            <a title='{$friend['username']}' href='/User.aspx?ID={$friend['id']}' style='display:inline-block;max-height:100px;max-width:100px;cursor:pointer;'>
                                <img src='/renders/render_user_{$friend['id']}.png?v=" . rand(1, 99999) . "' width='95' border='0' alt='{$friend['username']}'>
                            </a>
                        </div>
                        <div class='Summary'>
                            <span class='OnlineStatus'><img src='{$statusImg}' alt='{$statusAlt}'></span>
                            <span class='Name'><a href='/User.aspx?ID={$friend['id']}'>" . htmlspecialchars($friend['username']) . "</a></span>
                        </div>
                    </div>
                </td>";

                $count++;
                if ($count % 3 == 0) echo "</tr><tr>";
                if ($count >= 6) break;
            }

            echo '</tr></table>';
        }
        ?>
      </div>

      <div id="FavoritesPane" style="margin-top: 10px; margin-bottom: 0px;">
        <div id="Favorites">
          <h4>Favorites</h4>
          <div id="FavoritesContent">
            <p>This user does not have any favorites for this type.</p>
          </div>
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
    </div>
</div>
</div>
