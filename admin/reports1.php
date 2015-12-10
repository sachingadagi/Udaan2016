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
<html lang="en">
<head>
    <title>Fest Management System</title>
    <meta charset="UTF-8" />
    <link rel="stylesheet" type="text/css" href="css/index.css" />
    <link rel="stylesheet" type="text/css" href="css/font-awesome.min.css" />
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/main.js"></script>
    <script src="js/modernizr.custom.js"></script>
</head>
<body>
<div id="header">
</div>

<div class="container">
    <div class="content">
        <nav class="dr-menu">
            <div class="dr-trigger"><span id="dr-icon" class="fa fa-bars"></span><a class="dr-label">Menu</a></div>
            <ul>
                <li><a id="dr-icon" class="fa fa-compass"  href="home.php">Dashboard</a></li>
                <li><a id="dr-icon" class="fa fa-check-square-o" href="college.php">College's</a></li>
                <!-- <li><a id="dr-icon" class="fa fa-bar-chart-o" href="reporting.php">Reporting</a></li>
                 --><li><a id="dr-icon" class="fa fa-pencil" href="events.php">Events</a></li>
                <!-- <li><a id="dr-icon" class="fa fa-phone" href="contact.php">Contact Us</a></li>
                 --><li><a id="dr-icon" class="fa fa-power-off" href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </div><!-- content -->
                <form action="showlist.php?mode=0" method="post">
                    <button type="submit" class="btn btn-primary" style="float:left; width:10%; margin-top:20px; margin-left:10px;">Show All Registrations</button>
                </form>
                <form action="showlist.php?mode=1" method="post">
                    <button type="submit" class="btn btn-primary" style="float:left; width:10%; margin-top:20px; margin-left:10px;">Show Paid Registrations</button>
                </form>
                <form action="showlist.php?mode=2" method="post">
                    <button type="submit" class="btn btn-primary" style="float:left; width:10%; margin-top:20px; margin-left:10px;">Show Online Registrations</button>
                </form>
            </div><br/><br/><br/><br/><br/>
            <div>
                <h5>Custom Search</h5>
                <form action="showlist.php" method="post">
                    <label for="college"  style="float:left; width:10%;margin-top:25px; margin-left:15px;">Search by College</label>
                    <select name="collegeid" id="collegeid" style="float:left; width:20%;margin-top:25px; margin-left:15px;" >
                        <?php
                        $clgquery=mysql_query("SELECT id FROM contingent_college");
                        while ($row = mysql_fetch_array($clgquery)) {
                                echo '<option value="'.$row[0].'">'.$row[0].'</option>';
                        }
                        ?>
                    </select>
                    <label for="mode" style="float:left; width:5%;margin-top:25px; margin-left:15px;">Mode</label>
                    <select name="mode" style="float:left; width:20%;margin-top:25px; margin-left:15px;">
                        <option value="0" >All Registrations</option>
                    </select>
                    <button type="submit" class="btn btn-primary" style="float:left; width:10%; margin-top:20px; margin-left:10px;">Search</button>
                </form> <br><br><br>
                <form action="showlist.php" method="post">
                    <label for="event"  style="float:left; width:10%;margin-top:25px; margin-left:15px;">Search by Event</label>
                    <select name="eventid" id="eventid" style="float:left; width:20%;margin-top:25px; margin-left:15px;">
                        <?php
                        $eventquery=mysql_query('SELECT id FROM event WHERE name<>"none"');
                        while ($row = mysql_fetch_array($eventquery)) {
                            echo '<option value="'.$row[0].'">'.$row[0].'</option>';
                        }
                        ?>
                    </select>
                    <label for="mode" style="float:left; width:5%;margin-top:25px; margin-left:15px;">Mode</label>
                    <select name="mode" style="float:left; width:20%;margin-top:25px; margin-left:15px;">
                        <option value="0" >Contingent Registrations</option>
                        <option value="1">Non Contingent/Onspot Registrations</option>
                        </select>

                    <button type="submit" class="btn btn-primary" style="float:left; width:10%; margin-top:20px; margin-left:10px;">Search</button>
                </form> <br><br>
            </div>

        </div>
    </div>
</div>

<div id="footer"> <p id="leftContent">Fest Management System</p>
</div>
<script src="js/ytmenu.js"></script>
</body>
</html>