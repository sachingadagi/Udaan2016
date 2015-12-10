<?php
/**
 * Created by PhpStorm.
 * User: tuxer
 * Date: 12/2/2015
 * Time: 11:07 PM
 */
/** test php file  */
session_start();
if((isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'] == true))
{
    header("location:events.php");
}
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once "$root/Udaan2016/fms/utilities/Database.class.php";

require_once "$root/Udaan2016/fms/models/Event.class.php";

use Udaan\Database;

$dbhandler = Database::connect();
# connect to the database



try {

}
catch(PDOException $pdoe)
{
    echo $pdoe->getMessage();
}


?>
<html>
	<head>
		<title>UDAAN-A BIOSCOPE 2016</title>
		<link type="text/css" rel="stylesheet" href="css/login.css"/>
	</head>
	<body>

		<form id="login" action="auth.php" method="POST">
			<h1>Log In</h1>
			<fieldset id="inputs">
			<input id="username" type="text" placeholder="Username" name="username" autofocus required>   
			<input id="password" type="password" placeholder="Password" name="password" required>
			</fieldset>
			<fieldset id="actions">
			<input type="submit" id="submit" value="Log in">
			
			</fieldset>
		</form>
		
	</body>
</html>