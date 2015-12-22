<!DOCTYPE html>
<?php
session_start();
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once "$root/Udaan2016/fms/mappers/EventMapper.php";
if(!isset($_SESSION['username'])){
header("location:index.php");
}
 include('db.php');
$clgquery=mysql_query("SELECT name FROM college");
$eventquery=mysql_query("SELECT name FROM event");
require_once "$root/Udaan2016/fms/Config.php";
$eventMapper = new \Udaan\EventMapper();
//$submitted = false;
if (isset($_POST['submitted']))
{
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

    $file_name = "default.jpg";
    if(isset($_FILES['image']))
    {
        $file_errors = array();
        $file_name = $_FILES['image']['name'];
        $file_size = $_FILES['image']['size'];
        $file_tmp = $_FILES['image']['tmp_name'];
        $file_type = $_FILES['image']['type'];

        $value = explode(".", $file_name);
        $file_ext = strtolower(array_pop($value));


        $allowed_extensions= array("jpeg", "jpg", "png");

        if (in_array($file_ext, $allowed_extensions) === false) {
            $file_errors[] = "extension not allowed, please choose a JPEG or PNG file.";
        }

        # Checking for file size
        if ($file_size > 2097152) {
            $file_errors[] = 'File size must be less than 2 MB';
        }
        
        if(move_uploaded_file($file_tmp, \Udaan\Config::getLogoDirectory() . $file_name))
        {
            echo "successfully moved file";

        }
        else

        {
            echo "failed moving file";
        }

    }
    $sth = $db->prepare("INSERT INTO event(name,details,slogan,category,rules,start_date,end_date,start_time,end_time,group_size,fee_home,fee_remote,location,event_head_name,event_head_contact,equipments_provided,award,logo) VALUES('$name','$details','$slogan','$category','$rule','$startdate','$enddate','$starttime','$endtime','$groupsize','$homefee','$remotefee','$location','$headname','$headcontact','$equipments','$firstprice','$file_name')");

    $sth->execute();
    

    header('Location: events.php');
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

                 <form action="<?PHP echo $_SERVER['PHP_SELF']; ?>" method="post"  enctype="multipart/form-data">
                    <legend>Event Register</legend>
                     <input type=hidden name=submitted value=1>
                     <div class="form group">
                 <div class="form-group">
                 <label for="name">Name*</label>
                 <input type="text" class="form-control" id="name" placeholder="Name" name="name">
                 </div>
                 <div class="form-group">
                 <label for="slogan">Slogan</label>
                 <input type="text" class="form-control" id="slogan" placeholder="slogan" name="slogan">
                 </div>
                  <div class="form-group">
                 <label for="category">Details</label>
                 <input type="text" class="form-control" id="details" placeholder="details" name="details">
                     </div>
                      <div class="form-group">
                 <label for="Rules">Rules</label>
                 <input type="text" class="form-control" id="rules" placeholder="details" name="rules">
                 </div>                 
                 <div class="form-group">
                 <label for="category">Category</label>
                 <input type="text" class="form-control" id="category" placeholder="category" name="category">
                 </div>
                 <div class="form-group">
                 <label for="timing">Start Date</label>
                 <input type="text" class="form-control" id="startdate" placeholder="YYYY-MM-DD" name="startdate">
                 </div>
                 <div class="form-group">
                 
                 <label for="timing">End Date</label>
                 <input type="text" class="form-control" id="enddate" placeholder="YYYY-MM-DD" name="enddate">
                 </div>
                 <div class="form-group">
                 
                 <label for="timing">Start Time</label>
                 <input type="text" class="form-control" id="starttime" placeholder="HH-MM-SS" name="starttime">
                 </div>
                 <div class="form-group">
                 
                 <label for="timing">End Time</label>
                 <input type="text" class="form-control" id="endtime" placeholder="HH-MM-SS" name="endtime">
                 </div>
                 
                 
                 
                 <div class="form-group">
                 <label for="groupsize">Groupsize</label>
                 <input type="text" class="form-control" id="groupsize" placeholder="groupsize" name="groupsize">
                 </div>
                 <div class="form-group">
                 <label for="homefee">homefee</label>
                 <input type="text" class="form-control" id="homefee" placeholder="homefee" name="homefee">
                 </div>
                 
                 <div class="form-group">
                 <label for="remotefee">RemoteFee</label>
                 <input type="text" class="form-control" id="remotefee" placeholder="remotefee" name="remotefee">
                 </div>                   
                 <div class="form-group">
                 <label for="remotefee">Event Head</label>
                 <input type="text" class="form-control" id="head" placeholder="Event Head name" name="head">
                 </div>                   
                    <div class="form-group">
                 <label for="remotefee">Head Contact</label>
                 <input type="text" class="form-control" id="contact" placeholder="Head Contact #" name="contact">
                 </div>                   

                 <div class="form-group">
                 <label for="firstprice">Award</label>
                 <input type="text" class="form-control" id="firstprice" placeholder="firstprice" name="firstprice">
                 </div> 

                 <div class="form-group">
                 <label for="location">location</label>
                 <input type="text" class="form-control" id="location" placeholder="location" name="location">
                 </div> 
                 
                 <div class="form-group">
                 <label for="equipments">equipments</label>
                 <input type="text" class="form-control" id="equipments" placeholder="equipments" name="equipments">
                 </div> 
                 
                  <div class="form-group">
                 <label for="equipments">Image</label>
                 <input type="file" class="form-control" id="name"  name="image">
                 </div> 
                 
   				 <button type="submit" class="btn btn-primary" name="submit">Register Event</button>
		         </form>
              
               </div>
              
               </form> 
             </div>  
                 
               </div>
            </div>

    <!-- Custom script @Sachin -->
    <script>
         start_date= null;


        $('#starttime').datetimepicker({

            format: 'hh:ii:ss',
            autoclose: true,
            startView: 1,
            maxView: 1
        });
        $('#endtime').datetimepicker({

            format: 'hh:ii:ss',
            autoclose: true,
            startView: 1,
            maxView: 1
        });


         $('#startdate').datetimepicker({
             format: 'yyyy-mm-dd',
             autoclose: true,
             minView: 2,
             maxView: 4
         });

         $('#enddate').datetimepicker({
             format: 'yyyy-mm-dd',
             autoclose: true,
             minView: 2,
             maxView: 4
         });



    </script>
    <!-- -->
    </body>
</html>