<!doctype html>
<?php
session_start();
if(!isset($_SESSION['username'])){
    header("location:index.php");
}
include('db.model.php');
//$query=mysql_query("SELECT * FROM contingent_college");
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once "$root/Udaan2016/fms/utilities/Database.class.php";
require_once "$root/Udaan2016/fms/mappers/OnSpotMapper.php";
$OS = new \Udaan\OnSpotMapper();

$result = ($OS->getAll());

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
            <a class="navbar-brand" href="index.php"><img src="assets/img/logo30.png" alt=""> ADMIN PANEL</a>
        </div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li><a href="college.php"><i class="icon-calendar icon-white"></i> Contingent</a></li>
                <li><a href="noncontingent.php"><i class="icon-calendar icon-white"></i> Non Contingent</a></li>
                <li><a href="onspot.php"><i class="icon-calendar icon-white"></i> OnSpot</a></li>
                <li><a href="events.php"><i class="icon-th icon-white"></i> Events</a></li>
                <li><a href="reports.php"><i class="icon-th icon-white"></i> Reports</a></li>
                <li><a href="coordinators.php"><i class="icon-th icon-white"></i> Coordinator</a></li>
                <li><a href="logout.php"><i class="icon-lock icon-white"></i> Logout</a></li>

            </ul>
        </div><!--/.nav-collapse -->
    </div>
</div>

<div class="container">

    <!-- CONTENT -->
    <div class="row">


        <h4><strong>On Spot Registrations</strong></h4>
        <br>



        <table class="display" id="dt1">
            <thead>
            <tr>
                <th>Name</th>
                <th>Leader Name</th>
                <th>Contact</th>


            </tr>
            </thead>
            <tbody>
            <?php
            foreach($result as $row) {

                echo "<td>$row[1]</td>";            //slogan
                echo "<td>$row[3]</td>";            //timing
                echo "<td>$row[4]</td>";
                // echo '<td><a href="updatecollege.php?event='.$row[1].'">'.'Update'.'</a></td>';            //winnercontact

                // echo '<td><a href="deletecollege.php?event='.$row[0].'">'.'Delete'.'</a></td>';
                //groupsize
                echo "</tr>";
            }
            ?>
            </tbody>
        </table><!--/END SECOND TABLE -->

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