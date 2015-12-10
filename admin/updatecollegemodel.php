<!DOCTYPE html>
<?php
session_start();
if(!isset($_SESSION['username'])){
header("location:index.php");
}
include('db.php');

$id = $_SESSION['colgid'];
$name= $_POST['collegename'];

//echo $name;
//$slogan = $_POST[''];
//$name = clean_string($name);
//echo $name;

$sql="UPDATE contingent_college SET name='$name' where id='$id'";
	mysql_query($sql);
	unset($_SESSION['colgid']);
//	echo $name;
//	echo HI;
header('Location: college.php');
?>
    </body>
</html>    