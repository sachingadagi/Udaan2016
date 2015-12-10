<?php
//$name=$_POST['collegename'];
//$loginID=$_POST['loginID'];

$root = realpath($_SERVER["DOCUMENT_ROOT"]);

require_once "$root/Udaan2016/fms/utilities/Database.class.php";



function createContingent($nameParam)
{
    $password = random_password();
    $name = clean_string($nameParam);
    $loginID = registration_id();
    $db = \Udaan\Database::connect();
    $sth = $db->prepare("INSERT INTO contingent_college(name,loginid,password) VALUES('$name','$loginID','$password')");
    $sth->execute();

    header('Location: college.php');
}



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

function clean_string($string) {
    $bad = array(";","<",">","$");
    return str_replace($bad,"",$string);
}

/*$name = clean_string($name);
$loginID = registration_id();*/

//$sth = $this->databaseHandler->prepare("INSERT INTO contingent_college(name,loginid,password) VALUES('$name','$loginID','$password')");

//$sth->execute();

//header('Location: college.php');
?>