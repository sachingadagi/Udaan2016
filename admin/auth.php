<?php
	session_start();
    $root = realpath($_SERVER["DOCUMENT_ROOT"]);
    require_once "$root/Udaan2016/fms/utilities/Crypto.php";
	include('db.php');
	$username=$_POST['username'];


	$password=($_POST['password']);
	$query=mysql_query("SELECT * FROM appuser WHERE username='$username' AND password='$password'");
	$num=mysql_num_rows($query);
	if($num==1){
        $_SESSION['username']=$username;
        $_SESSION['is_logged_in'] = true;

        header("location:events.php");
		}
	else{
		echo "Wrong Username or Password";
		} 
		
?>