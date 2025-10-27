<?php
require($_SERVER['DOCUMENT_ROOT'].'/dacore/head.php');

if (!isset($_USER['id'])) {
    echo "<div style='text-align:center;color:red;font-weight:bold;'>You must be logged in to edit your profile.</div>";
    require_once($_SERVER["DOCUMENT_ROOT"]."/dacore/foot.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $blurb = trim($_POST['ctl00$cphRoblox$tbBlurb'] ?? '');
    $theme = trim($_POST['theme'] ?? '');

    if (!empty($blurb)) {
        if (strlen($blurb) > 1000) {
            exit("Your blurb exceeds the maximum number of characters.");
        }
        $stmt = $db->prepare("UPDATE users SET description = ? WHERE id = ?");
        $stmt->execute([$blurb, $_USER['id']]);
    }

    if (!empty($theme)) {
        $stmt = $db->prepare("UPDATE users SET themes = ? WHERE id = ?");
        $stmt->execute([$theme, $_USER['id']]);
    }

    echo "<div style='color: green; text-align:center; font-weight:bold;'>Profile updated successfully!</div>";
}
?>
<title>
  <?=$sitename?> - Edit Your Profile
</title>
<style>
#EditProfileContainer {
    background-color: #eeeeee;
    border: 1px solid #000;
    color: #555;
    margin: 0 auto;
    width: 620px;
}
fieldset {
    font-size: 1.2em;
    margin: 15px 0 0 0;
}
#EditProfileContainer #AgeGroup, 
#EditProfileContainer #ChatMode, 
#EditProfileContainer #PrivacyMode, 
#EditProfileContainer #EnterEmail, 
#EditProfileContainer #ResetPassword, 
#EditProfileContainer #Blurb, 
#Theme, 
#LogOut {
    margin: 0 auto;
    width: 60%;
}
.Suggestion {
    font-size: 0.9em;
    color: #333;
}
</style>

<div id="EditProfileContainer">
  <h2>Edit Profile</h2>
 <div id="EnterEmail">
            <fieldset title="Update Your Email Address">
                <legend>Update Your Email Address</legend>
                <div class="Suggestion">Click the button below to update your email address.</div>
                <div class="ResetPasswordRow">
                    &nbsp;<a>you cant do this rn</a>
                </div>
            </fieldset>
        </div>
        
  <div id="Blurb">
    <form action="" method="post">
      <fieldset title="Update your personal blurb">
        <legend>Update your personal blurb</legend>
        <div class="Suggestion">
          Describe yourself here (max. 1000 characters). Make sure not to provide any details that can be used to identify you outside <?=$sitename?>.
        </div>
        
        <div class="BlurbRow">
          <textarea name="ctl00$cphRoblox$tbBlurb" rows="3" cols="40" id="ctl00_cphRoblox_tbBlurb" tabindex="3" class="MultilineTextBox"><?=htmlspecialchars($_USER['description'])?></textarea>
        </div>
      </fieldset>
        

      <div class="Buttons">
        <button type="submit" class="Button">Update</button>
        <a href="/User.php" class="Button">Cancel</a>
      </div>
    </form>
  </div>
</div>

<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/dacore/foot.php");
?>
