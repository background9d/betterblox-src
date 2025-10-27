<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/dacore/head.php');
require_once $_SERVER["DOCUMENT_ROOT"]."/ReCaptcha.php";

error_reporting(E_ALL);
ini_set('display_errors', 1);

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);
    $invite_key = isset($_POST['invitekey']) ? strtoupper(trim($_POST['invitekey'])) : '';

    if (!$username || !$email || !$password || !$confirm_password || !$invite_key) {
        $error = "Please fill out all fields.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Please enter a valid email address.";
    } elseif ($password !== $confirm_password) {
        $error = "Passwords do not match.";
    } elseif (strlen($username) < 3 || strlen($username) > 20) {
        $error = "Username must be 3-20 characters.";
    } elseif (preg_match('/[^a-zA-Z0-9]/', $username)) {
        $error = "Username contains invalid characters.";
    }

    if (!$error) {
        $stmt = $db->prepare("SELECT * FROM invite_keys WHERE invite_key = :key LIMIT 1");
        $stmt->execute([':key' => $invite_key]);
        $key_data = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$key_data) {
            $error = "Invalid invite key.";
        } elseif ($key_data['used'] == 1) {
            $error = "That invite key has already been used.";
        } else {
            $stmt = $db->prepare("SELECT id FROM users WHERE username = :username OR email = :email");
            $stmt->execute([':username' => $username, ':email' => $email]);

            if ($stmt->fetch()) {
                $error = "Username or email already registered.";
            } else {

                $stmt = $db->prepare("INSERT INTO users (username, email, password) VALUES (:u, :e, :p)");
                $stmt->execute([
                    ':u' => $username,
                    ':e' => $email,
                    ':p' => password_hash($password, PASSWORD_BCRYPT)
                ]);

                $user_id = $db->lastInsertId();

                $stmt = $db->prepare("UPDATE invite_keys SET used = 1 WHERE id = :id");
                $stmt->execute([':id' => $key_data['id']]);

                $welcome_title = "Dear BetterBlox User!";
                $welcome_body = "Hello {$username}! Welcome to BetterBlox! — a private classic Roblox revival in development. We’re glad to have you here! Feel free to explore the site and customize your avatar.Have fun! The Betterblox Team. PD: you cant customize your avatar rn :( ";

                $stmt = $db->prepare("INSERT INTO messages (user_from, user_to, subject, content, readto, datesent) VALUES (:from, :to, :subj, :body, 0, NOW())");
                $stmt->execute([
                    ':from' => 1,
                    ':to' => $user_id,
                    ':subj' => $welcome_title,
                    ':body' => $welcome_body
                ]);

                header('Location: /User.aspx');
                exit;
            }
        }
    }
}
?>

<div id="Registration">
    <div id="ctl00_cphRoblox_upAccountRegistration">
        <h2>Sign Up and Play</h2>
        <h3>Create Account</h3>
        <form method="POST" action="">
            <center>
                <?php if ($error): ?>
                    <div style="color: red; font-weight: bold;"><?= htmlspecialchars($error) ?></div>
                <?php endif; ?>
            </center>

            <div id="EnterUsername">
                <fieldset title="Choose a name for your <?=$sitename ?> character">
                    <legend>Choose a name for your <?=$sitename ?> character</legend>
                    <div class="Suggestion">
                        Use 3-20 alphanumeric characters: A-Z, a-z, 0-9, no spaces
                    </div>
                    <div class="UsernameRow">
                        <label for="ctl00_cphRoblox_UserName" class="Label">Character Name:</label>
                        <input name="username" type="text" id="ctl00_cphRoblox_UserName" tabindex="1" class="TextBox" required/>
                    </div>
                </fieldset>
            </div>

            <div id="EnterPassword">
                <fieldset title="Choose your <?=$sitename ?> password">
                    <legend>Choose your <?=$sitename ?> password</legend>
                    <div class="Suggestion">
                        Passwords must be at least 8 characters
                    </div>
                    <div class="PasswordRow">
                        <label for="ctl00_cphRoblox_Password" class="Label">Password:</label>
                        <input name="password" type="password" id="ctl00_cphRoblox_Password" tabindex="2" class="TextBox" required/>
                    </div>
                    <div class="ConfirmPasswordRow">
                        <label for="ctl00_cphRoblox_TextBoxPasswordConfirm" class="Label">Confirm Password:</label>
                        <input name="confirm_password" type="password" id="ctl00_cphRoblox_TextBoxPasswordConfirm" tabindex="3" class="TextBox" required/>
                    </div>
                </fieldset>
            </div>

            <div id="EnterEmail">
                <fieldset title="Provide your email address">
                    <legend>Provide your email address</legend>
                    <div class="Suggestion">
                        This will allow you to recover a lost password
                    </div>
                    <div class="EmailRow">
                        <label for="ctl00_cphRoblox_TextBoxEMail" class="Label">Your Email:</label>
                        <input name="email" type="email" id="ctl00_cphRoblox_TextBoxEMail" tabindex="4" class="TextBox" required/>
                    </div>
                </fieldset>
            </div>

            <div id="EnterEmail">
                <fieldset title="Provide a BetterBlox invite key">
                    <legend>Provide a BetterBlox invite key</legend>
                    <div class="Suggestion">
                        BetterBlox is a private revival in development!
                    </div>
                    <div class="EmailRow">
                        <label for="ctl00_cphRoblox_TextBoxInviteKey" class="Label">Invite Key:</label>
                        <input name="invitekey" type="text" id="ctl00_cphRoblox_TextBoxInviteKey" placeholder="BETTERBLX-XXXX-XXXX-XXXX" tabindex="5" class="TextBox" required/>
                    </div>
                </fieldset>
            </div>

            <div class="Confirm">
                <input type="submit" value="Register" id="ctl00_cphRoblox_ButtonCreateAccount" tabindex="6" class="BigButton"/>
            </div>
        </form>
    </div>
</div>

<div id="Sidebars">
    <div id="AlreadyRegistered">
        <h3>Already Registered?</h3>
        <p>If you just need to login, go to the <a href="/Login/Default.aspx">Login</a> page.</p>
        <p>If you already registered but still need to download the game installer, go to <a href="/Install/Default.aspx">Download</a>.</p>
    </div>
    <div id="TermsAndConditions">
        <h3>Terms &amp; Conditions</h3>
        <p>Registration does not provide any guarantees of service.</p>
        <p><?=$sitename ?> will not share your email address with 3rd parties.</p>
    </div>
</div>

<div id="ctl00_cphRoblox_ie6_peekaboo" style="clear: both"></div>

<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/dacore/foot.php');
?>
<title>
  <?=$sitename?>: Register
</title>
