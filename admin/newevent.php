<!DOCTYPE html>
<?php
session_start();
if(!isset($_SESSION['username'])){
header("location:index.php");
}
include('db.php');

$name= $_POST['name'];
$slogan = $_POST['slogan'];
$details = $_POST['details'];
$category = $_POST['category'];
$starttime = $_POST['starttime'];
$endtime   = $_POST['endtime'];
$startdate   = $_POST['startdate'];
$enddate   = $_POST['enddate'];

$groupsize = $_POST['groupsize'];
$homefee = $_POST['homefee'];
$remotefee = $_POST['remotefee'];
$firstprice = $_POST['firstprice'];
$location = $_POST['location'];
$equipments = $_POST['equipments'];
$headname = $_POST['head'];
$headcontact = $_POST['contact'];
//$slogan = $_POST[''];
//$name = clean_string($name);
//echo $name;

$sql="INSERT INTO events(name,details,slogan,rules,category,start_date,end_date,start_time,end_time,group_size,fee_Home,fee_Remote,award,location,equipments_provided) VALUES('$name','$slogan','$category',,$groupsize,$homefee,$remotefee,'$firstprice','$location','$equipments')";
	mysql_query($sql);
	header('Location: events.php');
	
?>
    </body>
</html>    