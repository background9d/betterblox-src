<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/maincore/header.php");
?>
<title>
  <?=$sitename?> - Edit my friends
</title>
<div id="Body">
    <div id="FriendsContainer">
        <?php
        $sql = "SELECT * FROM friends WHERE 
                (`sent_from` = :id AND `timeAdded` = 'accepted') 
                OR (`sent_to` = :id AND `timeAdded` = 'accepted')";
        $stmt = $db->prepare($sql);
        $stmt->execute(['id' => $_USER['id']]);
        $friends = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $resultCheck = count($friends);
        ?>

        <div id="Friends">
            <h4>My Friends (<?= $resultCheck ?>)</h4>
            <div id="ctl00_cphRoblox_rbxEditFriendsPane_Pager1_PanelPages" style="text-align:center;">
                Pages:
            </div>

            <table id="ctl00_cphRoblox_rbxEditFriendsPane_dlFriends" cellspacing="0" align="Center" border="0" style="border-collapse:collapse;">
                <tr>
                    <td>
                        <?php
                        if ($resultCheck > 0) {
                            foreach ($friends as $row) {
                                $friendid = ($row['sent_from'] == $_USER['id']) ? $row['sent_to'] : $row['sent_from'];

                                $stmt = $db->prepare("SELECT * FROM users WHERE id = :sent_id");
                                $stmt->execute(['sent_id' => $friendid]);
                                $creator = $stmt->fetch(PDO::FETCH_ASSOC);

                                if (!$creator) continue;
                                ?>
                                <div class="Friend" 
                                    onmouseover="this.style.borderStyle='outset';this.style.margin='6px'" 
                                    onmouseout="this.style.borderStyle='none';this.style.margin='10px'">
                                    <div class="Avatar">
                                        <a 
                                          id="ctl00_cphRoblox_rbxEditFriendsPane_dlFriends_ctl00_hlAvatar" 
                                          title="<?= htmlspecialchars($creator['username']); ?>" 
                                          href="/User.aspx?ID=<?= $creator['id']; ?>" 
                                          style="display:inline-block;height:100px;width:100px;cursor:pointer;">
                                            <img 
                                              width="100" 
                                              height="100" 
                                              src="/renders/render_user_<?= $creator['id']; ?>&v=<?= rand(1, 9999); ?>" 
                                              border="0" 
                                              alt="<?= htmlspecialchars($creator['username']); ?>" />
                                        </a>
                                    </div>
                                    <div class="Summary">
                                        <span class="OnlineStatus">
                                            <?php
                                            $isOnline = ($creator['lastseen'] + 300 >= time());
                                            $statusImg = $isOnline ? 'Online' : 'Offline';
                                            $statusText = $isOnline
                                                ? "{$creator['username']} is online"
                                                : "{$creator['username']} is offline (last seen at " . date('d/m/Y g:i A', (int)$creator['lastseen']) . ")";
                                            ?>
                                            <img 
                                              src="../images/OnlineStatusIndicator_Is<?= $statusImg ?>.gif" 
                                              alt="<?= htmlspecialchars($statusText); ?>" 
                                              style="border-width:0px;" />
                                        </span>
                                        <span class="Name">
                                            <a href="../User.aspx?ID=<?= $creator['id']; ?>">
                                                <?= htmlspecialchars($creator['username']); ?>
                                            </a>
                                        </span>
                                    </div>
                                    <div class="Options">
                                        <input 
                                          type="submit" 
                                          name="ctl00$cphRoblox$rbxEditFriendsPane$dlFriends$ctl00$bDelete" 
                                          value="Delete" 
                                          id="ctl00_cphRoblox_rbxEditFriendsPane_dlFriends_ctl00_bDelete" />
                                    </div>
                                </div>
                            <?php
                            }
                        } else {
                            echo "<p>i am workin on this thing dude :v</p>";
                        }
                        ?>
                    </td>
                    <td></td><td></td><td></td>
                </tr>
            </table>
        </div>
    </div>
</div>

<?php require_once($_SERVER["DOCUMENT_ROOT"] . "/maincore/foot.php"); ?>
