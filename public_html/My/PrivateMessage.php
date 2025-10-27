<?php
if (isset($_REQUEST['MessageID'])) {
    header("location: Message.aspx?MessageID=" . $_REQUEST['MessageID']);
    exit;
}

require("../maincore/header.php");

$uid = intval($_GET['RecipientID'] ?? 0);
$replyto = intval($_GET['replyto'] ?? 0);

$userq = $db->prepare("SELECT * FROM users WHERE id = :uid");
$userq->bindParam(':uid', $uid);
$userq->execute();
$user = $userq->fetch(PDO::FETCH_ASSOC);

if (($userq->rowCount() < 1) || ($uid == $_USER['id'])) {
    die("<script>document.location = '/users/'</script>");
}

$reply = false;

if ($replyto != 0) {
    $mq = $db->prepare("SELECT * FROM messages WHERE user_from = :uid AND user_to = :user_id AND id = :replyto");
    $mq->bindParam(':uid', $uid);
    $mq->bindParam(':user_id', $_USER['id']);
    $mq->bindParam(':replyto', $replyto);
    $mq->execute();

    if ($mq->rowCount() != 0) {
        $reply = true;
        $reply_msg = $mq->fetch(PDO::FETCH_ASSOC);
    }
}

if (isset($_POST['subject'])) {
    $subject = filter_var($_POST['subject'], FILTER_SANITIZE_STRING);
    $message = filter_var(nl2br($_POST['message']), FILTER_SANITIZE_STRING);
    $currenttimelol = time();

    $stmt = $db->prepare("INSERT IGNORE INTO messages (user_from, user_to, subject, content, datesent) 
                          VALUES (:user_from, :user_to, :subject, :content, :datesent)");
    $stmt->bindValue(':user_from', $_USER['id']);
    $stmt->bindValue(':user_to', $uid);
    $stmt->bindValue(':subject', $subject);
    $stmt->bindValue(':content', $message);
    $stmt->bindValue(':datesent', $currenttimelol);
    $stmt->execute();

    echo '<script>
        alert("Message sent successfully!");
        window.location = "/User.aspx?ID=' . $uid . '";
    </script>';
    exit;
}
?>
<title>
  <?=$sitename?>: Message
</title>
<div id="Body">
  <div class="MessageContainer">
    <div id="MessagePane">
      <form method="post" id="msgform">
        <h3>Your Message</h3>
        <div id="MessageEditorContainer">
          <div class="MessageEditor">
            <table width="100%" style="font-size: 12px;">
              <tbody>
                <tr valign="top">
                  <td style="width:12em">
                    <div id="From">
                      <span class="Label"><span id="MsgFrom">From:</span></span>
                      <span class="Field"><span id="MsgAuthor"><?= htmlspecialchars($_USER['username']) ?></span></span>
                    </div>
                    <div id="To">
                      <span class="Label"><span id="MsgTo">Send To:</span></span>
                      <span class="Field"><span id="MsgRecipient"><?= htmlspecialchars($user['username']) ?></span></span>
                    </div>
                  </td>
                  <td style="padding:0 24px 6px 12px">
                    <div id="Subject">
                      <div class="Label"><label id="MsgSubjectText">Subject:</label></div>
                      <div class="Field">
                        <input name="subject" type="text" id="MsgSubject" class="TextBox" style="width:100%;"
                          value="<?php if ($reply) echo 'RE: ' . htmlspecialchars($reply_msg['subject']); ?>">
                      </div>
                    </div>
                    <div class="Body">
                      <div class="Label"><label id="MsgBodyTitle">Message:</label></div>
                      <textarea name="message" rows="4" id="MsgBody" class="MultilineTextBox" style="width:100%;"></textarea>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <div style="clear:both"></div>
        </div>
        <div class="Buttons">
          <input name="sd" value="Send" id="Send" class="Button" type="submit">
        </div>
      </form>
    </div>
    <div style="clear: both;"></div>
  </div>
</div>

<style>
.Button {
  background-color: #6e99c9;
  color: white;
  font-family: Verdana;
  font-size: 11px;
  border: 1px solid #3b5a82;
  padding: 5px 10px;
  cursor: pointer;
  box-shadow: 2px 2px 0px #999;
}
.Button:hover {
  background-color: #5a87b3;
}
</style>

<?php require("../maincore/foot.php"); ?>
