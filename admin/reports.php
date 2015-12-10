<?php
/**
 * Created by PhpStorm.
 * User: Sarvesh
 * Date: 12/6/2015
 * Time: 9:12 AM
 */
?>
<!DOCTYPE html>
<?php
session_start();
if(!isset($_SESSION['username'])){
    header("location:index.php");
}
include('db.php');

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
    <!-- DATA TABLE CSS -->
    <link href="assets/css/table.css" rel="stylesheet">



    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>

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

    <!-- Google Fonts call. Font Used Open Sans -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type="text/css">

    <!-- DataTables Initialization -->
    <script type="text/javascript" src="assets/js/datatables/jquery.dataTables.js"></script>
    <script type="text/javascript" charset="utf-8">
        $(document).ready(function() {
            $('#dt1').dataTable();
        } );
    </script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="stylesheet" type="text/css" href="css/index.css" />

    <script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>

    <!-- Le styles -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/css/main.css" rel="stylesheet">
    <link href="assets/css/font-style.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/register.css">


    <script type="text/javascript" src="./jquery/jquery-1.8.3.min.js" charset="UTF-8"></script>
    <script type="text/javascript" src="./bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="./bootstrap/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
    <script type="text/javascript" src="./bootstrap/js/locales/bootstrap-datetimepicker.fr.js" charset="UTF-8"></script>


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

            <form action="showlist.php" method="post">
        <legend>Search by Contingent</legend>
                <div class="form-group">
                    <legend>Select Contingent</legend>
        <select name="collegeid" id="collegeid" style=" width:80%;margin-top:25px; margin-left:15px;" >
            <?php
            $clgquery=mysql_query("SELECT id,name FROM contingent_college");
            while ($row = mysql_fetch_array($clgquery)) {
                echo '<option value="'.$row[0].'">'.$row[1].'</option>';
            }
            ?>
        </select>
        <legend>Select Mode</legend>
        <select name="mode" style="width=80%">
            <option value="0" >All Registrations</option>
        </select>
                </div>
                <legend></legend>
        <button type="submit" class="btn btn-primary" style="width:80%">Search</button>
    </form><br><br>

                </div>
            </div>
        </div>

        <div class="col-sm-offset-3 col-sm-6 col-lg-6">
            <div id="register-wraper">


        <form action="showlist.php" method="post">
        <legend>Search by Event</legend>
            <legend>Select Event</legend>
        <select name="eventid" id="eventid" style="width:80%">
            <?php
            $eventquery=mysql_query('SELECT id,name FROM event WHERE name<>"none"');
            while ($row = mysql_fetch_array($eventquery)) {
                echo '<option value="'.$row[0].'">'.$row[1].'</option>';
            }
            ?>
        </select>
        <legend>Mode</legend>
        <select name="mode" style="width:80%">
            <option value="0" >Contingent Registrations</option>
            <option value="1">Non Contingent/Onspot Registrations</option>
        </select>
        <legend></legend>
        <button type="submit" class="btn btn-primary" style="width:80%">Search</button>
    </form> <br><br>
</div>

</div><!--/span12 -->
</div><!-- /row -->
</div> <!-- /container -->
<br>

<!-- Le javascript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script type="text/javascript" src="assets/js/bootstrap.js"></script>
<script type="text/javascript" src="assets/js/admin.js"></script>


</body></html>