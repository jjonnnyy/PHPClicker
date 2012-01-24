<?php //check if first run, if so go to installer
if (is_dir('install'))
	header("Location: install/install.php");

include('mysql.php');//connect to database
mysql_connect($server, $username, $password);
mysql_select_db($dbname);

include('q.php');//load question parameters

if (isset($_COOKIE['isestats'])){//if cookie is set
	//check if ip has changed
	if($_SERVER['REMOTE_ADDR'] != $_COOKIE['isestats'])
		$ip = $_COOKIE['isestats'];
	else
		$ip = $_SERVER['REMOTE_ADDR'];
} else { $ip = $_SERVER['REMOTE_ADDR']; }

//check database for ip to stop repeat voting
$sql = "SELECT ip FROM clicker WHERE ip='".$ip."'";
$result = mysql_query($sql);
if (mysql_fetch_array($result))
	$hide=1;

//if form has been submitted, and is valid and the question is active and the it is not an old submission, processs
if(isset($_POST['option']) && !$hide && $active && ($_POST['time']>$time)){
		//upload answer to database
		$sql = "INSERT INTO  `$dbname`.`clicker` (`ip` ,`option`) VALUES ('$_SERVER[REMOTE_ADDR]', '$_POST[option]');";
		$result = mysql_query($sql);
		//set cookie
		setcookie('isestats', $_SERVER[REMOTE_ADDR]);
		echo "Thank you for voting. You voted  ".$_POST['option'].".";
		$hide=1;
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<title>ISE Statistics Clicker</title>
	</head>
	<body>
	<? if($active && !isset($hide)){ ?>
	<h1>Select your answer:</h1>
	<form method="POST" action="index.php" >
	<input type="hidden" name="time" value="<? echo(time());?>">
	<? $x=1; while ($x <= $options){?>
	<input type="radio" name="option" value="<? echo $x;?>" /><? echo $x;?><br /><? $x++; } ?>
	<p><input type="submit" name="Submit" value="Submit" /></p>
	</form><?} else { ?>
	<p>There is not currently a question.</p><?}?>
	<p><a href="index.php">Reload</a></p>
	</body>
</html>
