<? //test if user is logged in
include('pass.php');
$test = md5($adminpass);
if ((!isset($_COOKIE["clicker"])) || ($_COOKIE["clicker"]!=$test)){
	header("Location: login.php");
} else if ($_COOKIE["clicker"]==$test) {

include('../mysql.php');
mysql_connect($server, $username, $password);
mysql_select_db($dbname);

//if starting new question
if($_POST[action]=='start'){
	//clear database
	$sql = "TRUNCATE TABLE  `clicker`";
	mysql_query($sql);
	//write q.php
	$file=fopen("../q.php", "w");
	fwrite($file, "<? \$options = $_POST[numOptions]; \$active = 1; \$time=".time()."; ?>");
	fclose($file);
}
//if ending a question
if($_POST[action]=='stop'){
	//write q.php
	include('../q.php');
	$file=fopen("../q.php", "w");
	fwrite($file, "<? \$options = $options; \$active = 0; \$time=0; ?>");
	fclose($file);
}

include('../q.php');

// get currenturl
$currenturl = $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
// remove "/admin/.."
$splitar = explode("/admin/",$currenturl);
$clickerurl = $splitar[0];
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<title>ISE Statistics Clicker</title>
		<script src="http://www.tag.cx/qr-codes/tag-cx-qrcode.js" type="text/javascript"></script>	
	</head>
	<body>
	<h1>Admin Panel</h1>
	<?
	//if there is no active question allow to start new question
	if(!$active){
	?>
	<form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
	<input type="hidden" name="action" value="start">
	<p>New Question: Number of Options <input type="text" name="numOptions" value="4" /> <input type="submit" value="Start" /></p>
	</form>
	<h2>Result of previous question:</h2>
	<?
	for ($i = 1; $i<=$options; $i++) //initialise data
		$data[$i]=0;

	//pull data and formulate result
	$sql = "SELECT * from clicker";
	$result = mysql_query($sql);
	while ($row = mysql_fetch_array($result))
		$data[$row[option]]++; //count result
		
	//formulate data string
	for ($i = 1; $i<=$options; $i++){
		$dataStr = $dataStr.$data[$i];		//format "2,4,17,5,6"
		if($i != $options)
			$dataStr = $dataStr.",";
		}
	
	$ymax = max($data);
	
	//compile image url
	$graph = 	"http://chart.apis.google.com/chart?cht=bvg&chs=640x460
				&chxs=0,676767,13,0,l,676767|1,676767,15,0,l,676767
				&chxt=x,y&chbh=a,5&chco=4D89F9
				&chxr=0,1,$options|1,0,$ymax&chds=0,$ymax
				&chd=t:$dataStr";
	?>
	<img src="<? echo $graph; ?>"/>
	<? } else { ?>
	<form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
	<input type="hidden" name="action" value="stop">
	<p>End Question : <input type="submit" value="Stop" /></p>
	</form>
	<script type="text/javascript">generateQRCODE("qr","250", "http://<? echo $clickerurl;?>");</script>
	<? } ?>
	</body>
</html>
<?}?>
