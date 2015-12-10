<!DOCTYPE html>
<?php
session_start();


if(!isset($_SESSION['username'])){
header("location:index.php");
}
include('db.php');
$root = realpath($_SERVER["DOCUMENT_ROOT"]);

require_once "$root/Udaan2016/fms/mappers/ContingentMapper.php";
require_once "$root/Udaan2016/fms/admin/helpers/allFunctions.php"; 

$ContingentMapper = new \Udaan\ContingentMapper();
//$submitted = false;
if (isset($_POST['submitted']))
{
    //$ContingentMapper->insertCollege();
    $name=$_POST['collegename'];
    createContingent($name);

}
else {
}

?>
<html><head>
    <meta charset="utf-8">
    <title>UDAAN 2016 ADMIN</title>
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
                <li><a href="reports.php"><i class="icon-th icon-white"></i> Reports</a></li>
              <li><a href="logout.php"><i class="icon-lock icon-white"></i> Logout</a></li>
              
            </ul>
          </div><!--/.nav-collapse -->
        </div>
    </div>

    <div class="container">
        <div class="row">
                        <div class="col-sm-6 col-lg-6">
                <div id="register-wraper">
                    <form action="<?PHP echo $_SERVER['PHP_SELF']; ?>" method="post">

               <div class="modal-body">
                   <input type=hidden name=submitted value=1>

                  
                                   <div class="form-group">
                            <label for="clgname">College Name</label>
                            <input type="text" class="form-control" id="clgname" placeholder="College Name" name="collegename">
                          
                          </div>
                    <button type="submit" class="btn btn-success">Submit </button>
          <a href="#" class="btn" data-dismiss="modal">Close</a>  
        </div>  
                </form> 
              
               </div>
              
               </form> 
             </div>  
                 
               </div>
            </div>
 <script src="assets/js/bootstrap.js"></script>

        <script src="js/ytmenu.js"></script>
    </body>
</html>