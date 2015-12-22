<!DOCTYPE html>
<?php
session_start();
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once "$root/Udaan2016/fms/mappers/CoordinatorMapper.php";
if(!isset($_SESSION['username'])){
header("location:index.php");
}
 include('db.php');
$clgquery=mysql_query("SELECT name FROM college");
$eventquery=mysql_query("SELECT name FROM event");

$eventMapper = new \Udaan\CoordinatorMapper();
//$submitted = false;
if (isset($_POST['submitted']))
{
    $role= $_POST['role'];
    $name = $_POST['name'];
    $eventname = $_POST['eventname'];
    $contactno = $_POST['contactno'];

    $db = \Udaan\Database::connect();
    $sth = $db->prepare("INSERT INTO coordinators(role,name,event_name,contact_no) VALUES('$role','$name','$eventname','$contactno')");

    $sth->execute();

    header('Location: coordinators.php');
}
else {
}

?>
<html><head>
    <meta charset="utf-8">
    <title>UDAAN 2016</title>
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
   <link rel="stylesheet" type="text/css" href="css/index.css" />
    <link rel="stylesheet" type="text/css" href="css/bootstrap-datetimepicker.min.css" />

                <script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>

    <!-- Le styles -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/css/main.css" rel="stylesheet">
    <link href="assets/css/font-style.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/register.css">


<script type="text/javascript" src="./jquery/jquery-1.8.3.min.js" charset="UTF-8"></script>
<script type="text/javascript" src="./bootstrap/js/bootstrap.min.js"></script>

    <script type="text/javascript" src="js/bootstrap-datetimepicker.js" charset="UTF-8"></script><script type="text/javascript" src="./bootstrap/js/locales/bootstrap-datetimepicker.fr.js" charset="UTF-8"></script>

<script src="assets/js/bootstrap.js"></script>
<script src="js/ytmenu.js"></script>


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
                <li><a href="reports.php"><i class="icon-th icon-white"></i> Reports</a></li>
              <li><a href="logout.php"><i class="icon-lock icon-white"></i> Logout</a></li>
              
            </ul>
          </div><!--/.nav-collapse -->
        </div>
    </div>
 <div class="container">
        <div class="row">
                        <div class="col-sm-offset-3 col-sm-6 col-lg-6">
                <div id="register-wraper">

                 <form action="<?PHP echo $_SERVER['PHP_SELF']; ?>" method="post">
                    <legend>Coordinator Register</legend>
                     <input type=hidden name=submitted value=1>
                     <div class="form group">
                 <div class="form-group">
                 <label for="name">Role*</label>
                 <input type="text" class="form-control" id="role" placeholder="Role" name="role">
                 </div>
                 <div class="form-group">
                 <label for="slogan">Name</label>
                 <input type="text" class="form-control" id="name" placeholder="name" name="name">
                 </div>
                         <div class="form-group">
                 <label for="category">Event Name</label>
                 <input type="text" class="form-control" id="eventname" placeholder="eventname" name="eventname">
                  </div>          <div class="form-group">
                 <label for="category">Contact No</label>
                 <input type="text" class="form-control" id="contactno" placeholder="contactno" name="contactno">
                 </div>

   				 <button type="submit" class="btn btn-primary" name="submit">Register Coordinator</button>
		         </form>
              
               </div>
              
               </form> 
             </div>  
                 
               </div>
            </div>

    </body>
</html>