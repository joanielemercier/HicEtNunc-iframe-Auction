<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>Auction HeN</title>
  <link rel="stylesheet" href="./style.css">
</head>
<style>
  .countdown {
  position: absolute;
  top: 10px;
  left: 65px;
  //background-color: #f00;
  z-index:5;
}

.timer {
  font-family: Roboto, Arial, sans-serif;
  font-size: 30px;
}

#time_left {
  z-index:5;
  color:#bbb;
  position: absolute;
  top: 16px;
  left: 160px;
  //background-color: #f00;
  z-index:5;
  font-family: Roboto, Arial, sans-serif;
  font-size: 14px;
  width: 200px;
}


  </style>
<body>

<div class="countdown">
  <div class="timer">
    <span id="days"></span>
    <span id="hours"></span>
    <span id="minutes"></span>
    <span id="seconds"></span>
    <span id="url"></span>
    <div id="time_left">time left (last bid +5min)</div>
  </div> 
</div>

<script  src="./timer.js"></script>

<!--START CODE DISPLAY=========================================================-->
<script>
//Load Json file
var txt = `{"auction":<? include ('auction.json'); ?>}`;

//Parse Json data
var jsonData = JSON.parse(txt);
var result_list = "";
for (var i = 0; i < jsonData.auction.length; i++) {
  var counter = jsonData.auction[i];
  var str = counter.buyer;
  var buyer_alias = counter.alias;
  var date = counter.date;
  var res = str.substring(0, 6);
  var res2 = str.substring(str.length - 4, str.length);
  var buyer_short = res + " .. " + res2;

  if (buyer_alias == ""){ var buyer = buyer_short;}
  else {var buyer = buyer_alias;}
 
//get current bid

// HIGHLIGHT IF THIS IS YOU
  if (i < 1){
   var current_buyer = "<a href='https://www.hicetnunc.xyz/tz/"+str+"' target='_parent'>" + buyer + "</a>";
   var current_bid = counter.bid;
   var latest_date= counter.date;
	}
//get history
  else {
var result_list = result_list + "<li><div class='collector'><a href='https://www.hicetnunc.xyz/tz/"+str+"' target='_parent'>"+ buyer +"</a></div><div class='date'>"+ date +"</div><div class='price'>"+ counter.bid + "xtz</div> &nbsp;</li>";
  }
   
}
</script>
<!--END CODE DISPLAY==========================================================-->

<?
//START GET Variables --------------------------------------------------------------------
if(isset($_GET['b'])) {
	$input = $_GET['b'];
}
else{
	$input = 0;
	//TODO input = latest BID
}

//VARIABLE COLLECTOR
 if(isset($_GET['v'])) {
 	$col = $_GET['v'];
}
else{
	//NO WALLET ID
	$col = "";
}
//END GET Variables --------------------------------------------------------------------
?>

<!------ TODO SWITCH +2 and +5 if price >50 ? -->
<div class="container">
  <div class="offer">
     <div id="latestoffer">Latest offer:<div class="plus3"><a id="bid_link" href="#">&nbsp;+&nbsp;</A></div></div>
     <div id="latestoffer2">Collector</div><div id="latestoffer3">0 xtz</div><BR><BR>
  </div> 
 <div id="make">
  <div id="latestoffer">Make an offer:<div class="plus"><? echo "<a href='index.php?v=",$col,"&b=", $input + 100,"'>+100</a>"; ?>&nbsp;<? echo "<a href='index.php?v=",$col,"&b=", $input + 250,"'>+250</a>";?>&nbsp;<? echo "<a href='index.php?v=",$col,"&b=", $input + 500,"'>+500</a>"; ?>&nbsp;<div class="plus2"><a id="bid_link2" href="#">&nbsp;+&nbsp;</A></div></div>&nbsp;</div> 
<div id="latestoffer4"><a href="https://github.com/hicetnunc2000/hicetnunc/wiki/Edit-your-profile">Verify</a> your account first</div><div id="latestoffer5">xtz</div>
<!-- <div class="latestoffer4">Message</div> -->
<BR><div id="latestoffer6"><a id="send_link" href="VERIFY">SEND OFFER</a></div>  
</div>

<ul class="list"><li>
 <div class="collector">COLLECTOR</div>
<div class="date">DATE</div>
<div class="price">OFFER </div>
     &nbsp;
  </li>
<script>
	document.write(result_list);
</script>
</ul> 
<div class="twitter"><a href="https://twitter.com/JoanieLemercier/status/1396088965615296513">Twitter thread</a></div>
<div id="themessage"><p id="alias2"> </p><div id="amessage">Message goes here</div><div id='sure'></div><div id="error"></div></div>
</div>
<!-- END DESIGN -->

<script>
<? 
if(isset($_GET['b'])) {
    echo "OnLoad=document.getElementById('make').style.visibility = 'visible';";
}
else{
	echo "OnLoad=document.getElementById('make').style.visibility = 'hidden';";
}

if(isset($_GET['d'])) {
    echo "OnLoad=document.getElementById('themessage').style.visibility = 'visible';";
}
else{
	echo "OnLoad=document.getElementById('themessage').style.visibility = 'hidden';";
}
?> 

    function togglevis () {
      if (document.getElementById("make").style.visibility == "hidden") {
        document.getElementById("make").style.visibility = "visible";
      } else {
        document.getElementById("make").style.visibility = "hidden";
      }
    }
</script>

<?    if($_GET['d']==1){$key = gweeghkw90g34h39034;}  ?>

<!--START CODE ALIAS -->
<script>
        // Gets the autor metadata from a given wallet id
        var url, xmlhttp;
        var walletId = '<?echo $_GET['v']; ?>';
        url = "https://api.tzkt.io/v1/accounts/" + walletId + "/metadata";
        xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4) {
                if (this.status == 200) {
                    authorMetadata = JSON.parse(this.responseText);
                    console.log("Author metadata: ", authorMetadata);
					var alias2 = authorMetadata.alias;
          document.getElementById("send_link").href = "index.php?v=<?echo "$col"; ?>&b=<?echo "$input"; ?>&d=1&a=" + alias2;
					var Alias_loaded = alias2;			
                    document.getElementById("latestoffer4").innerHTML = alias2;
                }
                requestFinished = true;
                if (Alias_loaded === undefined) {
                    //alert("ALIAS DID NOT LOAD");
                    var verified = "NO";
                    document.getElementById("latestoffer6").style.visibility = "hidden";
                    var sure="You need to verify your account before placing a bid<BR> Link";     
                }
                else{var verified = "OK";}
                document.getElementById("verified").innerHTML = verified;
            }
        };
        // Execute the query
        xmlhttp.open("GET", url, true);
        xmlhttp.send();
</script>


<!-- START WRITE---------------------------------------------------------------- -->
<?
if($_GET['d']==1){
     //echo 'ARE YOU SURE ?';
     $message = "ARE YOU SURE ?<BR><BR><p style='font-size:15px;color:#939393'>You are about to place a bid on this OBJKT.<BR>By clicking YES, you commit to purchase this OBJKT if your offer is accepted. You may contact the artist via <a href='https://twitter.com/JoanieLemercier'>twitter DM</a> to arrange the swap and payment.</p><a href='index.php?v=".$col."&b=".$input."&d=".$key."&a=".$_GET['a']."'> YES </a>";
}

else if($_GET['d']=="gweeghkw90g34h39034"){
	//echo 'write';
	$jsonString = file_get_contents('auction.json');
	$content = json_decode($jsonString, TRUE);
    $last_bid =  $content[0]['bid'];
    $last_col =  $content[0]['buyer'];
    $alias = $_GET['a'];

// >> bid too low
	if ($_GET['b'] <= $last_bid ){ 
    //echo "Your offer (<b>". $_GET['b'] ."</b>) must be greater than <b>" . $last_bid ."</b>" ;
    $message = "Your offer (<b>". $_GET['b'] ." xtz</b>) must be greater than the current offer (<b>" . $last_bid ." xtz</b>)" ;
  }

	// already highest
	else if ($_GET['v'] == $last_col ){
    //echo "Your offer is already the highest";
    $message ="Your offer is already the highest";
  }

  //TODO: Add caracter control.
	else if ($_GET['v'] == "false" || $_GET['v'] == ""){
  //echo "You must synch your wallet before making an offer.";
  $message ="You must synch your wallet before making an offer.";
}
	else {
    $jsonString2 = substr($jsonString, 1);
    $data = "{\"bid\": \"" .$input. "\",\"buyer\": \"" . $col . "\",\"alias\": \"" . $alias . "\",\"date\":\"". date("Y-m-d")." ".date("H:i:s")."\"},";
    $newJsonString = "[\r".$data. $jsonString2;

// >> check bid 1 minute ago

// >> bid too high.

//todo copy old file to save it.

// If no offer before.

  file_put_contents('auction.json', $newJsonString);
  $message = "Your offer was sent successfuly<BR> <A href='index.php?v=".$_GET['v']."'>Reload the page</A> to see your bid.";
  //redirection doesn't work
  //header("location:index.php?v=".$_GET['v']);
  //header('Location:index.php');      
	}
}
?>
<!-- END WRITE ----------------------------------------- -->

<script>
document.getElementById("latestoffer2").innerHTML = current_buyer;
document.getElementById("latestoffer3").innerHTML = current_bid + " xtz";

document.getElementById('amessage').innerHTML ="<?echo "$message"; ?>";
document.getElementById('latestoffer5').innerHTML ="<?echo "$input"; ?>" + " xtz";

 if ( window.location !== window.parent.location )
    {//document.write("iFrame");
     } 
    else {
      document.write("Please view this page on HicEtNunc.<BR>");
      document.body.style.display = "none";
    }
document.getElementById("bid_link").href = "index.php?v=<?echo "$col"; ?>&b=" + current_bid;
document.getElementById("bid_link2").href = "index.php?v=<?echo "$col"; ?>";
</script>
</body>
</html>