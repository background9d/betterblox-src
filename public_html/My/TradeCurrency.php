<?php
include $_SERVER["DOCUMENT_ROOT"].'/dacore/head.php';
?>
<?php
if (isset($_POST['submit'])) {
    $userId = htmlspecialchars($_USER['id']);

    $conversionType = htmlspecialchars($_POST['mtype']);
    $amount = htmlspecialchars($_POST['amount']);
	if(!is_numeric($amount) || $amount < 0) {
	$date = date("Y-m-d H-m-s");
	$time = time();
	$q = $db->prepare("UPDATE users SET bandate = :date, bantype = 'Warning', unbantime = :time, banreason = 'Trying to exploit Trade Currency system.' WHERE id = :id");
	$q->bindParam(':date', $date, PDO::PARAM_STR);
	$q->bindParam(':time', $time, PDO::PARAM_INT);
	$q->bindParam(':id', $_USER["id"], PDO::PARAM_INT);
	$q->execute();
	header('location: /Default.aspx');
	exit;
	}
if ($conversionType == 'rx') {
    $columnToUpdate = 'bux';
    $newAmount = $_USER['bux'] + $amount / 10;
    $columnToUpdates = 'tix';
    $newAmounts = $_USER['tix'] - $amount;
    if ($_USER['tix'] < $amount) {
        die();
    }
    if($newAmount == 0){
	die();
    }
} else {
    $columnToUpdate = 'tix';
    $newAmount = $_USER['tix'] + $amount * 10;
    $columnToUpdates = 'bux';
    $newAmounts =  $_USER['bux'] - $amount;
    if ($_USER['bux'] < $amount) {
        die();
    }
    if($newAmount == 0){
	die();
    }
}

$sql = $db->prepare("UPDATE users SET $columnToUpdate = :newAm, $columnToUpdates = :yey WHERE id = :id");
$sql->execute([
    ':newAm' => $newAmount,
    ':yey' => $newAmounts,
    ':id' => $userId
           
]);

header("location: /My/TradeCurrency.aspx");
}
?>
<title>
  <?=$sitename?>: <?=$plog?>
</title>
<div id="TradeCurrencyContainer">
  <h2>Basic Currency Exchange</h2>
  <font face="Verdana">
    <div style="margin-bottom:5px; text-align:center;"><a href="#" onclick="location.reload()">Refresh</a></div>
  </font>
  <div class="LeftColumn">
    <div id="CurrencyBidsPane">
      <div class="CurrencyBids">
        <h4>Available Tickets</h4>
    
            <div class="CurrencyBid">
                27,175 @ 3.8220:1
            </div>
        
            <div class="AlternatingCurrencyBid">
                22 @ 3.6666:1
            </div>
        
            <div class="CurrencyBid">
                43 @ 3.5833:1
            </div>
        
            <div class="AlternatingCurrencyBid">
                20,468 @ 3.4591:1
            </div>
        
            <div class="CurrencyBid">
                11,736 @ 3.4588:1
            </div>
        
            <div class="AlternatingCurrencyBid">
                201 @ 3.4067:1
            </div>
        
            <div class="CurrencyBid">
                10 @ 3.3333:1
            </div>
        
            <div class="AlternatingCurrencyBid">
                162 @ 3.24:1
            </div>
        
            <div class="CurrencyBid">
                113 @ 3.2285:1
            </div>
        
            <div class="AlternatingCurrencyBid">
                31,500 @ 3.15:1
            </div>
        
            <div class="CurrencyBid">
                1,075 @ 3.1069:1
            </div>
        
            <div class="AlternatingCurrencyBid">
                37 @ 3.0833:1
            </div>
        
            <div class="CurrencyBid">
                7,812 @ 3.0671:1
            </div>
        
            <div class="AlternatingCurrencyBid">
                92 @ 3.0666:1
            </div>
        
            <div class="CurrencyBid">
                76 @ 3.04:1
            </div>
        
            <div class="AlternatingCurrencyBid">
                380 @ 3.0158:1
            </div>
        
            <div class="CurrencyBid">
                1,187 @ 3.0050:1
            </div>
        
            <div class="AlternatingCurrencyBid">
                841 @ 3.0035:1
            </div>
        
            <div class="CurrencyBid">
                3,001 @ 3.001:1
            </div>
        
            <div class="AlternatingCurrencyBid">
                60 @ 3:1
            </div>
        
    
</div>
            </div>
        </div>
  <div class="CenterColumn">
    <div id="ctl00_cphRoblox_CurrencyTradePane">
      <div class="CurrencyTrade">
        <h4>Trade</h4>
        <form method="post" style="padding:25px;">
          <ul>
            <li>10 Tickets = 1 RLBUX</li>
            <li>1 RLBUX = 10 Tickets</li>
          </ul>
          <input id="radioRX" type="radio" name="mtype" value="rx" checked="checked"><label for="radioRX">To RLBUX</label>
          <input id="radioTX" type="radio" name="mtype" value="tx"><label for="radioTX">To Tickets</label>
          <br><br>
          <input id="amounttxt" name="amount" type="number" maxlength="9" tabindex="2" value="10" class="TradeBox" autocomplete="off" step="1">
          <br><br>
          I will get <span id="amounts">1</span> <span id="type" style="<?=$buxcolo?>"><?=$buxalt?></span>
          <script>
            $("#amounttxt").on("input", function() {
                if($("input[name=mtype]:checked").val() == "rx") {
                    $("#amounts").text(Math.floor($(this).val() / 10));
                    $("#type").css("<?=$buxcolo?>").html("<?=$buxalt?>");
                } else {
                    $("#amounts").text(Math.floor($(this).val() * 10));
                    $("#type").css("color", "goldenrod").html("TX");
                }
            });
            $("input[name=mtype]").on("change", function() {
                if($("input[name=mtype]:checked").val() == "rx") {
                    $("#amounts").text(Math.floor($("#amounttxt").val() / 10));
                    $("#type").css("<?=$buxcolo?>").html("<?=$buxalt?>");
                } else {
                    $("#amounts").text(Math.floor($("#amounttxt").val() * 10));
                    $("#type").css("color", "goldenrod").html("TX");
                }
            });
          </script>
          <br><br>
          <input type="submit" name="submit" value="Submit Trade">
        </form>
      </div>
    </div>
    <div class="TradingDashboard">
    </div>
  </div>
  <div class="RightColumn">
    <div id="CurrencyOffersPane">
      <div class="CurrencyOffers">
        <div class="CurrencyOffers">
    <h4>Available RLBUX</h4>
    
            <div class="CurrencyOffer">
                18,850 @ 1:3.9023
            </div>
        
            <div class="AlternatingCurrencyOffer">
                400 @ 1:3.9975
            </div>
        
            <div class="CurrencyOffer">
                8,144 @ 1:3.9998
            </div>
        
            <div class="AlternatingCurrencyOffer">
                50 @ 1:4
            </div>
        
            <div class="CurrencyOffer">
                15 @ 1:4
            </div>
        
            <div class="AlternatingCurrencyOffer">
                15 @ 1:4
            </div>
        
            <div class="CurrencyOffer">
                5 @ 1:4
            </div>
        
            <div class="AlternatingCurrencyOffer">
                2,000 @ 1:4
            </div>
        
            <div class="CurrencyOffer">
                3 @ 1:4
            </div>
        
            <div class="AlternatingCurrencyOffer">
                20 @ 1:4
            </div>
        
            <div class="CurrencyOffer">
                25 @ 1:4
            </div>
        
            <div class="AlternatingCurrencyOffer">
                10 @ 1:4
            </div>
        
            <div class="CurrencyOffer">
                10 @ 1:4
            </div>
        
            <div class="AlternatingCurrencyOffer">
                10 @ 1:4
            </div>
        
            <div class="CurrencyOffer">
                10 @ 1:4
            </div>
        
            <div class="AlternatingCurrencyOffer">
                5 @ 1:4
            </div>
        
            <div class="CurrencyOffer">
                20 @ 1:4
            </div>
        
            <div class="AlternatingCurrencyOffer">
                25 @ 1:4
            </div>
        
            <div class="CurrencyOffer">
                1,200 @ 1:4
            </div>
        
            <div class="AlternatingCurrencyOffer">
                10 @ 1:4
            </div>
        
    
</div>
            </div>
        </div>
  <div style="clear: both;"></div>
</div>