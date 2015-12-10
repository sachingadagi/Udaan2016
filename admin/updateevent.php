<!DOCTYPE html>
<?php
/*session_start();
if(!isset($_SESSION['username'])){
header("location:index.php");
}*/
include('db.php');
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once "$root/Udaan2016/fms/utilities/Database.class.php";
require_once "$root/Udaan2016/fms/mappers/EventMapper.php";

$eventMapper = new \Udaan\EventMapper();
$event = null;
$result = null;

//$event = $_GET['event'];
if(isset($_GET['event']) && $_GET['event']!="") {

    $event = $_GET['event'];
    $_SESSION['eventid'] =  $event;



}

if($event!=null && isset($event))$result = ($eventMapper->getEvent($_SESSION['eventid']));

//echo $event;
//$clgquery=mysql_query("SELECT name FROM college");
//$eventquery=mysql_query("SELECT * from event where id='$event'");
//$row = mysql_fetch_array($eventquery);






if (isset($_POST['updated']))
{
    #$eventMapper->updateEvent();
    $eventid = $_POST['event'];

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
    $rule = $_POST['rules'];
    $db = \Udaan\Database::connect();

    $sth = $db->prepare("UPDATE event SET name='$name',slogan='$slogan',category='$category',details='$details',start_time='$starttime',end_time='$endtime',start_date='$startdate',end_date='$enddate',group_size='$groupsize',fee_home='$homefee',fee_remote='$remotefee',award='$firstprice',location='$location',equipments_provided='$equipments',rules='$rule',event_head_name='$headname',event_head_contact='$headcontact' where id='$eventid' ");

    $sth->execute();
    header('Location: events.php');
}
else {
}

//var_dump($result);

?>
<html><head>
    <meta charset="utf-8">
    <title>UDAAN 2016</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/css/main.css" rel="stylesheet">
    <link href="assets/css/font-style.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/register.css">

    <script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>

    <style type="text/css">
      body {
        padding-top: 60px;
      }
    </style>

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="assets/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="assets/ico/apple-touch-icon-57-precomposed.png">

    <!-- Google Fonts call. Font Used Open Sans & Raleway -->
    <link href="http://fonts.googleapis.com/css?family=Raleway:400,300" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type="text/css">
    </head>
  <body>

    <!-- NAVIGATION MENU -->

   
    <div class="navbar-nav navbar-inverse navbar-fixed-top">
        <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.html"><img src="assets/img/logo30.png" alt=""> ADMIN PANEL</a>
        </div> 
          <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li><a href="college.php"><i class="icon-calendar icon-white"></i> Contingent</a></li>
                <li><a href="noncontingent.php"><i class="icon-calendar icon-white"></i> Non Contingent/OnSpot</a></li>
                <li><a href="events.php"><i class="icon-th icon-white"></i> Events</a></li>
              <li><a href="logout.php"><i class="icon-lock icon-white"></i> Logout</a></li>
              
            </ul>
          </div><!--/.nav-collapse -->
        </div>
    </div>
     <div class="container">
        <div class="row">
                        <div class="col-sm-offset-3 col-sm-6 col-lg-6">
                <div id="register-wraper">
                    <?php
                foreach ($result as $row )
                {
                    //echo $row[1];
                   ?>

                    <form action="<?PHP echo $_SERVER['PHP_SELF']; ?>" method="post">
                        <legend>UPDATE EVENT</legend>
                        <input type=hidden name=updated value=1>

                        <div class="form group">
                            <div class="form-group">
                                <input type="hidden" name ="event" value ="<?php echo $_SESSION['eventid'];?>"
                                <label for="name">Name*</label>
                                <input type="text" class="form-control" id="name" placeholder="Name" name="name" value="<?php echo $row[1] ?>">
                            </div>
                            <div class="form-group">
                                <label for="slogan">Slogan</label>
                                <input type="text" class="form-control" id="slogan" placeholder="slogan" name="slogan" value="<?php echo $row[3] ?>">
                            </div>
                            <div class="form-group">
                                <label for="category">Details</label>
                                <input type="text" class="form-control" id="details" placeholder="details"
                                       name="details" value="<?php echo $row[2] ?>">
                            </div>
                            <div class="form-group">
                                <label for="Rules">Rules</label>
                                <input type="text" class="form-control" id="rules" placeholder="details" name="rules" value="<?php echo $row[5] ?>">
                            </div>
                            <div class="form-group">
                                <label for="category">Category</label>
                                <input type="text" class="form-control" id="category" placeholder="category"
                                       name="category" value="<?php echo $row[4] ?>">
                            </div>
                            <div class="form-group">
                                <label for="timing">Start Date</label>
                                <input type="text" class="form-control" id="startdate" placeholder="YYYY-MM-DD"
                                       name="startdate" value="<?php echo $row[6] ?>">
                            </div>
                            <div class="form-group">

                                <label for="timing">End Date</label>
                                <input type="text" class="form-control" id="enddate" placeholder="YYYY-MM-DD"
                                       name="enddate" value="<?php echo $row[7] ?>">
                            </div>
                            <div class="form-group">

                                <label for="timing">Start Time</label>
                                <input type="text" class="form-control" id="starttime" placeholder="HH-MM-SS"
                                       name="starttime" value="<?php echo $row[8] ?>">
                            </div>
                            <div class="form-group">

                                <label for="timing">End Time</label>
                                <input type="text" class="form-control" id="endtime" placeholder="HH-MM-SS"
                                       name="endtime" value="<?php echo $row[9] ?>">
                            </div>


                            <div class="form-group">
                                <label for="groupsize">Groupsize</label>
                                <input type="text" class="form-control" id="groupsize" placeholder="groupsize"
                                       name="groupsize" value="<?php echo $row[10] ?>">
                            </div>
                            <div class="form-group">
                                <label for="homefee">homefee</label>
                                <input type="text" class="form-control" id="homefee" placeholder="homefee"
                                       name="homefee" value="<?php echo $row[11] ?>">
                            </div>

                            <div class="form-group">
                                <label for="remotefee">RemoteFee</label>
                                <input type="text" class="form-control" id="remotefee" placeholder="remotefee"
                                       name="remotefee" value="<?php echo $row[12] ?>">
                            </div>
                            <div class="form-group">
                                <label for="remotefee">Event Head</label>
                                <input type="text" class="form-control" id="head" placeholder="Event Head name"
                                       name="head" value="<?php echo $row[14] ?>">
                            </div>
                            <div class="form-group">
                                <label for="remotefee">Head Contact</label>
                                <input type="text" class="form-control" id="contact" placeholder="Head Contact #"
                                       name="contact" value="<?php echo $row[15] ?>">
                            </div>

                            <div class="form-group">
                                <label for="firstprice">Award</label>
                                <input type="text" class="form-control" id="firstprice" placeholder="firstprice"
                                       name="firstprice" value="<?php echo $row[17] ?>">
                            </div>

                            <div class="form-group">
                                <label for="location">location</label>
                                <input type="text" class="form-control" id="location" placeholder="location"
                                       name="location" value="<?php echo $row[13] ?>">
                            </div>

                            <div class="form-group">
                                <label for="equipments">equipments</label>
                                <input type="text" class="form-control" id="equipments" placeholder="equipments"
                                       name="equipments" value="<?php echo $row[16] ?>">
                            </div>


                            <button type="submit" class="btn btn-primary" name="submit">Update Event</button>
                    </form>
                <?php
                    }
                    ?>
                </div>

                        </div>
                 
               </div>
            </div>
 <script src="assets/js/bootstrap.js"></script>

        <script src="js/ytmenu.js"></script>
    </body>
</html>