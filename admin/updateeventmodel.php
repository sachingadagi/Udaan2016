<!DOCTYPE html>
<?php
session_start();
if(!isset($_SESSION['username'])){
header("location:index.php");
}
include('db.php');


$name= $_POST['name'];
$slogan = $_POST['slogan'];
$category = $_POST['category'];
$timing = $_POST['timing'];
$groupsize = $_POST['groupsize'];
$homefee = $_POST['homefee'];
$remotefee = $_POST['remotefee'];
$firstprice = $_POST['firstprice'];
$location = $_POST['location'];
$equipments = $_POST['equipments'];
//echo $name;
//$slogan = $_POST[''];
//$name = clean_string($name);
//echo $name;

$sql="UPDATE events SET name='$name',slogan='$slogan',category='$category',timing='$timing',groupSize=$groupsize,feeHome=$homefee,feeRemote=$remotefee,firstPrize='$firstprice',location='$location',equipments_provided='$equipments' where name='$name'";
	mysql_query($sql);
header('Location: events.php');
?>
    </body>
</html>    