<?php
include('db.php');
	$colg=$_GET['event'];
$sql="DELETE FROM contingent_college where id='$colg'";
	mysql_query($sql);
	header('Location: college.php');
?>