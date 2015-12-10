<?php
include('db.php');
	$event=$_GET['event'];
#$sql="DELETE FROM event where id='$event'";
$sql="UPDATE event set is_deleted = 1  where id='$event'"; // Safe Delete
	mysql_query($sql);
	header('Location: events.php');
?>