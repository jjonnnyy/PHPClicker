<?
include('pass.php');
//test if password has been posted succesfully
if($_POST['password']==$adminpass){
	//if so set cookie and redirect to admin panel
	$hash = md5($adminpass);
	setcookie('clicker', $hash);
	header("Location: index.php");
//if not ask user to log in
} else {
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<title>ISE Stats Clicker</title>
	</head>
	<body>
		<h1>Login</h1> 
		<form name="form" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>"> 
			<p><label for="txtpassword">Password:</label> 
			<br /><input type="password" title="Enter your password" name="password" /></p> 
			<p><input type="submit" name="Submit" value="Login" /></p> 
		</form>	</body>
</html>
<? } ?>