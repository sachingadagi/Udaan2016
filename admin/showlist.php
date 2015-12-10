<!DOCTYPE html>
<?php
session_start();
if(!isset($_SESSION['username'])){
    header("location:index.php");
}
include('db.php');
function clean_string($string) {
    $bad = array(";","<",">","$","*");
    return str_replace($bad,"",$string);
}
if(!isset($_GET['mode']) && !isset($_POST['mode'])) {
    echo "There were error(s) found with the form you submitted. ";
    die();
}

$mode=1;
if(isset($_GET['mode'])){
    $mode=$_GET['mode'];
}else{
    $mode=$_POST['mode'];
}
$query;
if(!isset($_POST['collegeid']) && !isset($_POST['eventid'])) {
    echo "NO";
    if($mode==0)
        $query=mysql_query("SELECT * FROM registration");
    elseif($mode==1)
        $query=mysql_query("SELECT * FROM registration WHERE paid=1");
    else
        $query=mysql_query("SELECT * FROM registration WHERE paid=0");

} elseif(isset($_POST['collegeid'])) {
    $clg=$_POST['collegeid'];
    echo $clg ;
    if($mode==0)

        $query=mysql_query("SELECT * FROM registered_events_contingent WHERE contingent_id='$clg'");

    elseif($mode==1)
        $query=mysql_query("SELECT * FROM registration WHERE paid=1 AND collegename='$clg'");
    else
        $query=mysql_query("SELECT * FROM registration WHERE paid=0 AND collegename='$clg'");

}elseif(isset($_POST['eventid'])){
    $event=$_POST['eventid'];
    echo "POST";
    if($mode==0)
        $query=mysql_query("SELECT * FROM registered_events_contingent WHERE event_id='$event'");
    elseif($mode==1)
        $query=mysql_query("SELECT * FROM registered_events_onspot_noncontingent WHERE event_id='$event'");
    else
        $query=mysql_query("SELECT * FROM registration WHERE paid=0 AND eventname='$event'");

}
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
    <table class="table table-striped table-bordered table-hover" id="dt1">
        <col width="50">
        <col width="30">
        <col width="30">
        <col width="30">
        <thead>
        <tr>
            <th>Registration ID</th>
            <th>Partcipant Name</th>
            <th>Event Name</th>
            <th>Total Number of Participents</th>
            <th>Amount Paid</th>
            <th>Registration Date</th>
        </tr>
        </thead>
        <tbody>
        <?php
        while ($row = mysql_fetch_array($query)) {
            echo "<tr>";
            echo '<td><a href="showregistration.php?regid='.$row[0].'">'.$row[0].'</a></td>';
            //echo "<td>$row[1]</td>";
            if ($mode == 0) {
                $college_query = mysql_query("SELECT name from contingent_college where id='$row[1]'");
                $collegename = mysql_fetch_array($college_query);
            }
            elseif ($mode == 1)
            {
                $NC_query = mysql_query("SELECT name from onspot_noncontingent where id='$row[1]'");
                $collegename = mysql_fetch_array($NC_query);

            }
            $event_query=mysql_query("SELECT name FROM event WHERE id='$row[2]'");
            $eventname = mysql_fetch_array($event_query);
            echo "<td>$collegename[0]</td>";
            echo "<td>$eventname[0]</td>";
            echo "<td></td>";
            echo "<td>$row[3]</td>";
            echo "<td>$row[4]</td>";
            echo "</tr>";
        }
        ?>
        </tbody>
    </table>

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