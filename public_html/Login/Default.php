<?php
require_once($_SERVER['DOCUMENT_ROOT']."/dacore/head.php");

if ($loggedin === "yes") {
    header("Location: /");
    exit;
}

error_reporting(E_ALL);
ini_set("display_errors", 1);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = htmlspecialchars(trim($_POST['UserName'] ?? ''), ENT_QUOTES, 'UTF-8');
    $password = htmlspecialchars(trim($_POST['Password'] ?? ''), ENT_QUOTES, 'UTF-8');

    if (empty($username) || empty($password)) {
        die("Please enter both username and password.");
    } else {
        $sql = "SELECT id, username, password FROM users WHERE username = :username";
        $stmt = $db->prepare($sql);
        $stmt->execute([':username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            generateSessionCookie($user['id'], $db);

            session_start();
            $_SESSION['id'] = $user['id'];
            $_SESSION['username'] = $user['username'];

            header("Location: /");
            exit;
        } else {
            die("Invalid username or password.");
        }
    }
}
?>
<title>
  <?=$sitename?>: Log-In
</title>

<div id="Body">
    <div id="FrameLogin" style="margin: 50px auto 150px auto; width: 500px; border: black thin solid; padding: 21px; z-index: 8; background-color: white;">
        <div id="PaneNewUser">
            <h3>New User?</h3>
            <p>You need an account to play <?=$sitename?>.</p>
            <p>If you aren't a <?=$sitename?> member then <a id="ctl00_cphRoblox_HyperLink1" href="/Login/NewAge.aspx">register</a>. 
            It's easy and we do <em>not</em> share your personal information with anybody.</p>
        </div>

        <div id="PaneLogin">
            <h3>Log In</h3>
            <div class="AspNet-Login">
                <div style="color:red; text-align:center;"></div>
                <form method="POST" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <div class="AspNet-Login-UserPanel">
                        <label for="ctl00_cphRoblox_lRobloxLogin_UserName" class="TextboxLabel"><em>U</em>ser Name:</label>
                        <input type="text" id="ctl00_cphRoblox_lRobloxLogin_UserName" name="UserName" value="" accesskey="u">&nbsp;
                    </div>

                    <div class="AspNet-Login-PasswordPanel">
                        <label for="ctl00_cphRoblox_lRobloxLogin_Password" class="TextboxLabel"><em>P</em>assword:</label>
                        <input type="password" id="ctl00_cphRoblox_lRobloxLogin_Password" name="Password" value="" accesskey="p">&nbsp;
                    </div>

                    <div class="AspNet-Login-SubmitPanel">
                        <input type="submit" value="Log In" id="ctl00_cphRoblox_lRobloxLogin_LoginButton" 
                        name="ctl00$cphRoblox$lRobloxLogin$LoginButton">
                    </div>

                    <div class="AspNet-Login-PasswordRecoveryPanel">
                        <img src="/images/bubbletext.png" id="img" alt="Forgot your password?" border="0" 
                        onclick="window.location.href='ResetPasswordRequest.aspx'" 
                        style="position:absolute;margin-left:200px;cursor:pointer;">
                        <img src="/images/loginfig.png" id="img" alt="Figure" border="0" 
                        style="margin-left: 80px;position:absolute;z-index:-1;margin-top:-50px;">
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php
require_once($_SERVER['DOCUMENT_ROOT']."/dacore/foot.php");
?>
</div>
