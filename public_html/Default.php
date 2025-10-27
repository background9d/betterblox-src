<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/dacore/head.php');
?>
<title>
  <?=$sitename?>: <?=$descrp?>
</title>
<div id="Body">
          
    
  <div id="SplashContainer">
    <div id="SignInPane">
      
<div id="LoginViewContainer">
  
      <div id="LoginView">
        <?php if($loggedin == 'yes') { ?><h5>Logged In</h5>
  <div id="AlreadySignedIn">
          <a title="<?=$_USER['username']?>" href="/User.aspx" style="display:inline-block;height:190px;width:152px;cursor:pointer;"><img src="/renders/render_user_<?=$_USER['id']?>.png?rand=<?php echo random_int(1,999999999999999999); ?>" style="display:inline-block;width:145px;margin-top:15px;" border="0" id="img" alt="<?=$_USER['username']?>"></a>
        <?php } else { ?><h5>Member Login</h5>
        
<div class="AspNet-Login">
            <div class="AspNet-Login"><form method="POST" action="/Login/Default.aspx">
              <div class="AspNet-Login-UserPanel">
                <label for="ctl00_cphRoblox_rbxLoginView_lvLoginView_lSignIn_UserName" id="ctl00_cphRoblox_rbxLoginView_lvLoginView_lSignIn_UserNameLabel" class="Label">Character Name</label>
                <input name="UserName" type="text" id="ctl00_cphRoblox_rbxLoginView_lvLoginView_lSignIn_UserName" tabindex="1" class="Text">
              </div>
              <div class="AspNet-Login-PasswordPanel">
                <label for="ctl00_cphRoblox_rbxLoginView_lvLoginView_lSignIn_Password" id="ctl00_cphRoblox_rbxLoginView_lvLoginView_lSignIn_PasswordLabel" class="Label">Password</label>
                <input name="Password" type="password" id="ctl00_cphRoblox_rbxLoginView_lvLoginView_lSignIn_Password" tabindex="2" class="Text">
              </div>
              <div class="AspNet-Login-SubmitPanel">
                <button type="submit" name="lb" tabindex="4" type="submit" class="Button">Login</button>
              </div>
                         <div class="AspNet-Login-SubmitPanel">
                               <a tabindex="4" class="Button" href="Login/NewAge.aspx">Register</a>
                        </div>
              <div class="AspNet-Login-PasswordRecoveryPanel">
                <a id="ctl00_cphRoblox_rbxLoginView_lvLoginView_lSignIn_hlPasswordRecovery" tabindex="5" href="Login/ResetPasswordRequest.aspx">Forgot your password?</a>
              </div>
            </div> <?php } ?>
          
</div>
      </div>
    
</div>

      <br>
            
         <?php 
if($loggedin == 'yes'){
    echo '
    <div style="text-align:center; background-color:#eeeeee; border:1px solid black;">
    <br>
    <h3>'.$sitename.' News</h3>
    <a href="/Default.aspx">'.$sitename.' news added</a><br><br>
    <a href="/Default.aspx">working on renders</a><br><br>
    <a href="">Added Themes!</a><br><br>';
    
    include $_SERVER['DOCUMENT_ROOT'].'/random.php';
    
    echo '
    </div>';
}

?>

    </div>
    
            

<div id="RobloxAtAGlance">
    <h2><?=$sitename?> Virtual Playworld</h2>
  <h3><?=$sitename?> is Free!</h3>
  <ul id="ThingsToDo">
    <li id="Point1">
      <h3>Build your personal Place</h3>
      <div>Create buildings, vehicles, scenery, and traps with thousands of virtual bricks.</div>
    </li>
    <li id="Point2">
      <h3>Meet new friends online</h3>
      <div>Visit your friend's place, chat in 3D, and build together.</div>
    </li>
    <li id="Point3">
      <h3>Battle in the Brick Arenas</h3>
      <div>Play with the slingshot, rocket, or other brick battle tools.  Be careful not to get "bloxxed".</div>
    </li>
  </ul>
  <div id="Showcase" style="margin-right: 10px;">
        <iframe id="embedplayer" src="https://www.youtube.com/embed/h4UqMyldS7Q?si=trCl3PV3v8641ncT" width="400" height="326" allowfullscreen="" scrolling="off" frameborder="0" data-ruffle-polyfilled=""></iframe>
        <br><br>
      </div>
  <div id="Install">
    <div id="CompatibilityNote">Works with your<br>Windows PC!</div>
    <div id="DownloadAndPlay"><a id="ctl00_cphRoblox_RobloxAtAGlanceLoginView_RobloxAtAGlance_Anonymous_hlDownloadAndPlay" href="<?=$thing?>"><img src="/images/PlayNowGreenFader.gif" alt="FREE - Download and Play!" border="0"></a></div>
  </div>
  <div id="ForParents">
    <a id="ctl00_cphRoblox_RobloxAtAGlanceLoginView_RobloxAtAGlance_Anonymous_hlKidSafe" title="ROBLOX is kid-safe!" href="Parents.aspx" style="display:inline-block;"><img title="<?=$sitename?> is Gamer Safe!" src="/images/GamerSeal.png" border="0"></a>
  </div>
</div>
        
    
<div id="UserPlacesPane">
  <div id="UserPlaces_Content">
    <table id="ctl00_cphRoblox_CoolPlaces_CoolPlacesDataList" cellspacing="0" border="0" width="100%">
  <tr>
   <td class="UserPlace">
            <a id="ctl00_cphRoblox_DataListCoolPlace_ctl00_rbxContentImage" title="Boat warz " href="/web/20080215084506//Place.aspx?id=38591" style="display:inline-block;cursor:pointer;"><img src="https://web.archive.org/web/20080215084506im_/http://t6.roblox.com:80/b4e11c876a2391aafbdce2473638a080" border="0" id="img" alt="Boat warz "/></a>
          </td><td class="UserPlace">
            <a id="ctl00_cphRoblox_DataListCoolPlace_ctl01_rbxContentImage" title="- Farm Tycoon -" href="/web/20080215084506//Place.aspx?id=375542" style="display:inline-block;cursor:pointer;"><img src="https://web.archive.org/web/20080215084506im_/http://t0.roblox.com:80/a4b67d5c33ec300220a1fe535254a730" border="0" id="img" alt="- Farm Tycoon -"/></a>
          </td><td class="UserPlace">
            <a id="ctl00_cphRoblox_DataListCoolPlace_ctl02_rbxContentImage" title="Miners Heaven! (10000 brick warning!)" href="/web/20080215084506//Place.aspx?id=379760" style="display:inline-block;cursor:pointer;"><img src="https://web.archive.org/web/20080215084506im_/http://t6.roblox.com:80/d5d68a11a084dfe2f0258e75bc71501f" border="0" id="img" alt="Miners Heaven! (10000 brick warning!)"/></a>
          </td><td class="UserPlace">
            <a id="ctl00_cphRoblox_DataListCoolPlace_ctl03_rbxContentImage" title="✪Ultimate Paintball CTF" href="/web/20080215084506//Place.aspx?id=47828" style="display:inline-block;cursor:pointer;"><img src="https://web.archive.org/web/20080215084506im_/http://t1.roblox.com:80/Place-120x70-2c8ee77fa67d614896ece97cc8931777.Png" border="0" id="img" alt="✪Ultimate Paintball CTF"/></a>
          </td><td class="UserPlace">
            <a id="ctl00_cphRoblox_DataListCoolPlace_ctl04_rbxContentImage" title="Watch a movie or play in it V3" href="/web/20080215084506//Place.aspx?id=297627" style="display:inline-block;cursor:pointer;"><img src="https://web.archive.org/web/20080215084506im_/http://t6.roblox.com:80/347b03a378357645c2b679576d6b3c1e" border="0" id="img" alt="Watch a movie or play in it V3"/></a>
          </td>
  </tr>
</table>
  </div>
  <div id="UserPlaces_Header">
    <h3>Cool Places</h3>
    <p>Check out some of our favorite <?=$sitename?> places!</p>
  </div>
  <div id="ctl00_cphRoblox_CoolPlaces_ie6_peekaboo" style="clear: both"></div>
</div>
  </div>

        </div>
<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/dacore/foot.php");
?>