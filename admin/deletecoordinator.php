<?php
include('db.php');
	$coordinator=$_GET['coordinator'];
#$sql="DELETE FROM coordinator where id='$coordinator'";
$sql="UPDATE coordinators set is_deleted = 1  where id='$coordinator'"; // Safe Delete
	mysql_query($sql);
	header('Location: coordinators.php');
?>