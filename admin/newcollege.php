<?php
include('db.php');
$name=$_POST['collegename'];
$loginID=$_POST['loginID'];
$password=random_password();
function random_password( $length = 8 ) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789@";
    $password = substr( str_shuffle( $chars ), 0, $length );
    return $password;
}

function registration_id( $length = 5) {

	$chars = "1234567890"; 
	$registration_id = substr( str_shuffle($chars), 0 ,  $length);
	return $registration_id;
}
//echo $password;
function clean_string($string) {
      $bad = array(";","<",">","$");
      return str_replace($bad,"",$string);
}
$name = clean_string($name);
$loginID = registration_id();
$sql="INSERT INTO contingent_college(name,loginid,password) VALUES('$name','$loginID','$password')";
	mysql_query($sql);
	header('Location: college.php');
?>