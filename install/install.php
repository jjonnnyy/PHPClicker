<?php //set up database and files for clicker
include('../mysql.php'); //include database details

if (isset($_POST['server'])){ //if mysql details submitted
	//update mysql.php file
	$file=fopen("../mysql.php", "w");
	fwrite($file, "<? \$server = '$_POST[server]'; \$username = '$_POST[username]'; \$password = '$_POST[password]'; \$dbname = '$_POST[database]'; ?>");
	fclose($file);
	//test connection save result
	include('../mysql.php');
	if(@mysql_connect($server, $username, $password) && @mysql_select_db($dbname)){
		$mysqltest = "Connected successfully!"; $connected = true;
	} else {
		$mysqltest = "Unable to connect, please check the details are correct."; }
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<title>ISE Stats Clicker</title>
	</head>
	<body>
		<h1>Welcome to the Clicker Installer</h1> 
		
		<form name="form" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>"> 
			<h2>Set up MySQL database:</h2>
			<table>
			<tr><td><label for="server">Server:</label></td><td><input type="text" name="server" value="<? echo($server); ?>" /></td></tr></p> 
			<tr><td><label for="username">Username:</label></td><td><input type="text" name="username" value="<? echo($username); ?>" /></td></tr></p> 
			<tr><td><label for="password">Password:</label></td><td><input type="password" name="password" /></td></tr></p> 
			<tr><td><label for="database">Database:</label></td><td><input type="text" name="database" value="<? echo($dbname); ?>" /></td></tr></p> 
			<tr><td></td><td><input type="submit" value="Save and Test" /></td></tr>
			</table>
		</form>		
		<?php echo ("<p>$mysqltest</p>"); 
		if ($connected) {?>
		<form name="form" method="post" action="install2.php"> 
			<p><label for="password">Choose Admin password:</label><input type="password" name="password" /></p>
			<p>Create table 'clicker' and complete setup? <input type="submit" value="Go" /></p>
		</form>	
		<?php } ?>
	</body>
</html>
