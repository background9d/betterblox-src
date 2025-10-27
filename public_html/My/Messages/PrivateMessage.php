<?php
require_once("../../dacore/head.php");

$MessageID = isset($_GET['MessageID']) ? (int)$_GET['MessageID'] : 0;

if ($MessageID <= 0) {
    die("⚠️ Invalid message ID!");
}

$stmt = $db->prepare("SELECT * FROM messages WHERE id = :id");
$stmt->execute(['id' => $MessageID]);
$fpost = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$fpost) {
    die("⚠️ Message not found in the database (ID: $MessageID)");
}

if ($fpost['user_to'] != $_USER['id']) {
    die("❌ This message wasn’t sent to you.");
}

$stmt = $db->prepare("SELECT id, username FROM users WHERE id = :user_id");
$stmt->execute(['user_id' => $fpost['user_from']]);
$fauthor = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$fauthor) {
    die("⚠️ Message author not found.");
}

$q = $db->prepare("UPDATE messages SET readto = 1 WHERE id = :id");
$q->bindParam(':id', $MessageID, PDO::PARAM_INT);
$q->execute();

?>
<title>
  <?=$sitename?> - Private Message
</title>
<div id="Body">
    <div class="MessageContainer">
        <div id="MessagePane">
            <div id="ctl00_cphRoblox_pPrivateMessage">
                <div id="ctl00_cphRoblox_pPrivateMessageReader">
                    <h3>Private Message</h3>
                    <div class="MessageReaderContainer">

                        <div id="Message">
                            <table width="100%">
                                <tr valign="top">
                                    <td style="width: 10em">
                                        <div id="DateSent">
                                            <?php 
                                            echo date("m/d/Y g:i A", $fpost['datesent']); 
                                            ?>
                                        </div>

                                        <div id="Author">
                                            <a 
                                              id="ctl00_cphRoblox_rbxMessageReader_Avatar" 
                                              disabled="disabled" 
                                              title="<?= htmlspecialchars($fauthor['username']); ?>" 
                                              onclick="return false" 
                                              style="display:inline-block;height:64px;width:64px;">
                                                <img 
                                                  src="/renders/render_user_<?= (int)$fauthor['id'] ?>.png?rand=<?= random_int(1,999999999) ?>" 
                                                  border="0" 
                                                  id="img" 
                                                  alt="<?= htmlspecialchars($fauthor['username']); ?>" 
                                                  height="64px">
                                            </a><br>
                                            <a 
                                              id="ctl00_cphRoblox_rbxMessageReader_AuthorHyperLink" 
                                              title="Visit <?= htmlspecialchars($fauthor['username']); ?>'s Home Page" 
                                              href="/User.aspx?ID=<?= (int)$fauthor['id'] ?>">
                                                <?= htmlspecialchars($fauthor['username']); ?>
                                            </a>
                                        </div>

                                        <div id="Subject" style="margin-top:10px;">
                                            <b><?= htmlspecialchars($fpost['subject']); ?></b><br><br>
                                            <div class="ReportAbusePanel">
                                                <span class="AbuseIcon">
                                                    <a href="/AbuseReport/Message.aspx?ID=<?= (int)$fpost['id']; ?>">
                                                        <img src="/images/abuse.gif" alt="Report Abuse" style="border-width:0px;">
                                                    </a>
                                                </span>
                                                <span class="AbuseButton">
                                                    <a href="/AbuseReport/Message.aspx?ID=<?= (int)$fpost['id']; ?>">Report Abuse</a>
                                                </span>
                                            </div>
                                        </div>
                                    </td>

                                    <td style="padding: 0 10px 0 10px">
                                        <div class="Body">
                                            <div 
                                              id="ctl00_cphRoblox_rbxMessageReader_pBody" 
                                              class="MultilineTextBox" 
                                              style="height:250px;overflow-y:auto;width:455px;background-color:#fff;border:1px solid #ccc;padding:6px;">
                                                <?php 
                                                $content = trim($fpost['content']);
                                                if ($content === '') {
                                                    echo "<i>(No message content)</i>";
                                                } else {
                                                    echo nl2br(htmlspecialchars($content));
                                                }
                                                ?>
                                            </div>
                                            <p style="color:red;margin-top:10px;">
                                                <b>Remember, <?= htmlspecialchars($sitename); ?> staff will never ask for your password.<br>
                                                People who ask for your password are trying to steal your account.</b>
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <div style="clear:both"></div>

                        <div class="Buttons" style="margin-top:10px;">
                            <a class="Button" href="/My/Messages/Inbox.aspx">Cancel</a>
                            <a class="Button" href="/My/Messages/Delete.aspx?MessageID=<?= (int)$MessageID; ?>">Delete</a>
                            <a class="Button" href="/My/PrivateMessage.aspx?RecipientID=<?= (int)$fauthor['id']; ?>&replyto=<?= (int)$fpost['id']; ?>">Reply</a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
