<?php
include('../mysql.php'); //connect to database
mysql_connect($server, $username, $password);
mysql_select_db($dbname);

//create table clicker
$sql = "CREATE TABLE  `$dbname`.`clicker` (
`ip` VARCHAR( 15 ) NOT NULL ,
`option` INT NOT NULL
) ENGINE = MYISAM ;";

if(!mysql_query($sql))
	die("Table could not be created ".mysql_error()." <a href=\"install.php\">Back</a>");

//create admin password file
$file=fopen("../admin/pass.php", "w");
fwrite($file, "<? \$adminpass='$_POST[password]'; ?>");
fclose($file);
	
//delete install files
unlink('install.php');
unlink('install2.php');
rmdir('../install');

echo "Installation complete! Direct students to WWW.YOURWEBSITE.COM/DIRECTORY, control from /DIRECTORY/ADMIN";
?>
