<?php
/**
 * Created by PhpStorm.
 * User: tuxer
 * Date: 12/3/2015
 * Time: 8:04 PM
 */
// Requiring necessary stuff
require_once '/../libs/Slim/Slim.php';
require '../models/Event.class.php';
require_once '../models/Contingents.class.php';
require_once '../mappers/EventMapper.php';
require_once '../mappers/ContingentMapper.php';
require_once '../mappers/Registrations.php';
require_once '../models/NonContingents.class.php';
require_once '../mappers/NonContingentMapper.php';
require_once '../mappers/OnSpotMapper.php';
require_once '../models/Onspot.class.php';
require_once '../mappers/coordinatorMapper.php';

header('Access-Control-Allow-Origin: *');
// Autoloading the slim
\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();

// Very imp. Since we are interested with only REST API in the file, setting all of the response content type as JSON.
$app->response->headers->set('Content-Type', 'application/json');

// EventMapper object
$eventMapper = new \Udaan\EventMapper();

//Contingent Mapper object
$contingentMapper = new \Udaan\ContingentMapper();

//Contingent Mapper object
$NonContingentMapper = new \Udaan\NonContingentMapper();


//Registrations mapper
$registrationMapper = new \Udaan\Registrations();

// Onspot Mapper
$onSpotMapper = new \Udaan\OnSpotMapper();

//Coordinator Mapper
$coordinatorMapper = new \Udaan\CoordinatorMapper();

// ALL of the functions that respond according to request depending upon URL requests,begin here.

# ========================== EVENTS ===================================

/**
 * @api {get} /events/all Requesting all events
 * @apiName Get All Events
 * @apiGroup Event
 *
 *
 * @apiSuccess {jsonObject} Events JSONObject containing event info & meta info. http://www.jsoneditoronline.org/?id=a1d0eb703336fa4f5eb93a72813c5a06
 *
 * @apiSuccessExample Success-Response:
 *     HTTP/1.1 200 OK
 *
 *
 *
 */
$app->get('/events/all', function () use($app,$eventMapper) {

    $allEvents = $eventMapper->getAllEvents();

    $response = array();

    if($allEvents) {

        $status = 200;
        $response["error"] = 0;
        $response["code"] = $status;
        $response["events"] = array();
        $response["total_events"] =sizeof($allEvents);
        array_push($response["events"], $allEvents);
        $app->response->setStatus(200);
    }else{

        $status = 204;
        $response["error"] = 0;
        $response["total_events"] = 0;
        $response["message"] = "Oops, Events not found";
        //$app->response->setStatus(204);

    }
    print json_encode($response);

});

/**
 * @api {get} /event/:id Get Event information .
 * @apiName GetUser
 * @apiGroup Event
 *
 * @apiParam {Number} id Event unique ID.
 *
 * @apiSuccess {jsonObject} Events JSONObject containing event info & meta info. http://www.jsoneditoronline.org/?id=ad9ceb16c8f68d2892b1abd60cf824d9
 *
 * @apiSuccessExample Success-Response:
 *     HTTP/1.1 200 OK
 *
 *
 * @apiError EventNotFound Event with given ID not found http://www.jsoneditoronline.org/?id=ad9ceb16c8f68d2892b1abd60cb8dd0a
 *
 * @apiErrorExample Error-Response:
 *   {
 * "code":204,
 * "error":1,
 * "message":"Oops, Event by id 20 not found"
 * }
 */

$app->get('/event/:id', function ($id) use($app,$eventMapper) {

    $response = array();

    if(!is_numeric($id))
    {
        $status = 204;
        $response["code"] = 204;
        $response["error"]= 1;
        $response["error_message"] = "Oops, Invalid ID. ID should be numeric";
    }
    else
    {
        $Event = $eventMapper->getEvent($id);

        if ($Event) {

            $status = 200;
            $response["code"] = $status;
            $response["events"] = $Event;
            $response["error"]= 0;
            $app->response->setStatus(200);

        } else {

            $status = 204;
            $response["code"] = 204;
            $response["error"] = 1;
            $response["message"] = "Oops, Event by id {$id} not found";
            //$app->response->setStatus(204);
        }
    }
    print json_encode($response);
});


$app->post('/event',function() use ($app,$eventMapper){
    $response = array();

    verifyRequiredParams(array('name'));

    $event = new Event();
    $event->setName($app->request()->post('name'));
    $event->setDetails($app->request()->post('details'));
    $event->setSlogan($app->request()->post('slogan'));
    $event->setCategory($app->request()->post('type'));
    $event->setRules($app->request()->post('rules'));
    $event->setStartDate($app->request()->post('start_date'));
    $event->setEndDate($app->request()->post('end_date'));
    $event->setStartTime($app->request()->post('start_time'));
    $event->setEndTime($app->request()->post('end_time'));
    $event->setGroupSize($app->request()->post('group_size'));


    # --Getting the post vars and typecasting to int. Blehhh. Can't help, its PHP xD
    $feeHome = $app->request()->post('fee_home');
    settype($feeHome,"integer");
    $feeRemote = $app->request()->post('fee_remote');
    settype($feeRemote,"integer");
    #--

    $event->setFeeHome($feeHome);
    $event->setFeeRemote($feeRemote);
    $event->setLocation($app->request()->post('location'));
    $event->setEventHeadName($app->request()->post('event_head_name'));
    $event->setEventHeadContact($app->request()->post('event_head_contact'));
    $event->setAward($app->request()->post('award'));
    $event->setEquipmentProvided($app->request()->post('equipment_provided'));

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


        $event->setLogo($file_name);

        if(!move_uploaded_file($file_tmp, \Udaan\Config::getLogoDirectory() . $file_name)) {
            //echo "Success";
            $response["file moved"] = 0;
            $response["file_errors"] = $file_errors;

        }
    }
    else
    {


    }

    if($eventMapper->createEvent($event))
    {
        $status = 201;
        $response["error"] = 0;
        $response["code"] = $status;
        $response["message"] = "Event Created successfully.";
    }
    print json_encode($response);

});



$app->put('/event/:id',function($id) use ($app,$eventMapper){
    verifyRequiredParams(array('id','logo'));

    $event = new Event();
    $event->setId($id);
    $event->setName($app->request()->put('name'));
    $event->setDetails($app->request()->put('details'));
    $event->setSlogan($app->request()->put('slogan'));
    $event->setCategory($app->request()->put('type'));
    $event->setRules($app->request()->put('rules'));
    $event->setStartDate($app->request()->put('start_date'));
    $event->setEndDate($app->request()->put('end_date'));
    $event->setStartTime($app->request()->put('start_time'));
    $event->setEndTime($app->request()->put('end_time'));
    $event->setGroupSize($app->request()->put('group_size'));
    $event->setLogo($app->request()->put('logo'));

    # --Getting the put vars and typecasting to int. Blehhh. Can't help, its PHP xD
    $feeHome = $app->request()->put('fee_home');
    settype($feeHome,"integer");
    $feeRemote = $app->request()->put('fee_remote');
    settype($feeRemote,"integer");
    #--

    $event->setFeeHome($feeHome);
    $event->setFeeRemote($feeRemote);
    $event->setLocation($app->request()->put('location'));
    $event->setEventHeadName($app->request()->put('event_head_name'));
    $event->setEventHeadContact($app->request()->put('event_head_contact'));
    $event->setAward($app->request()->put('award'));
    $event->setEquipmentProvided($app->request()->put('equipments_provided'));

    if($eventMapper->updateEvent($event))
    {
        $status = 200;
        $response["code"] = $status;
        $response["message"] = "Event {$event->getId() } updated successfully.";
    }else
    {
        $status = 200;
        $response["code"] = $status;
        $response["message"] = "Some error occured while updating event {$event->getId()}.";
    }
    print (json_encode($response));



});


# ================================= END OF EVENTS ====================================
/////////////////////////////////////////////////// Vaibhav Coordinator Part

$app->get('/coordinators/all', function() use($app,$coordinatorMapper) {

    $allCoordinators = $coordinatorMapper->getAllCoordinators();

    $response = array();

    if($allCoordinators) {

        $status = 200;
        $response["error"] = 0;
        $response["code"] = $status;
        $response["coordinators"] = array();
        $response["total_coordinators"] =sizeof($allCoordinators);
        array_push($response["coordinators"], $allCoordinators);
        $app->response->setStatus(200);
    }else{

        $status = 204;
        $response["error"] = 0;
        $response["total_coordinators"] = 0;
        $response["message"] = "Oops, Coordinators not found";
        //$app->response->setStatus(204);

    }
    print json_encode($response);

});

$app->get('/coordinator/:id', function ($id) use($app,$coordinatorMapper) {

    $response = array();

    if(!is_numeric($id))
    {
        $status = 204;
        $response["code"] = 204;
        $response["error"]= 1;
        $response["error_message"] = "Oops, Invalid ID. ID should be numeric";
    }
    else
    {
        $Coordinator = $coordinatorMapper->getCoordinator($id);

        if ($Coordinator) {

            $status = 200;
            $response["code"] = $status;
            $response["coordinators"] = $Coordinator;
            $response["error"]= 0;
            $app->response->setStatus(200);

        } else {

            $status = 204;
            $response["code"] = 204;
            $response["error"] = 1;
            $response["message"] = "Oops, Coordinator by id {$id} not found";
            //$app->response->setStatus(204);
        }
    }
    print json_encode($response);
});


$app->post('/coordinator',function() use ($app,$coordinatorMapper){
    $response = array();

    verifyRequiredParams(array('name'));

    $coordinator = new Coordinator();
    $coordinator->setRole($app->request()->post('role'));
    $coordinator->setName($app->request()->post('name'));
    $coordinator->setEventName($app->request()->post('event_name'));
    $coordinator->setContactNo($app->request()->post('contact_no'));

    if($coordinatorMapper->createCoordinator($coordinator))
    {
        $status = 201;
        $response["error"] = 0;
        $response["code"] = $status;
        $response["message"] = "Coordinator Created successfully.";
    }
    print json_encode($response);

});

$app->put('/coordinator/:id',function($id) use ($app,$coordinatorMapper){
    //verifyRequiredParams(array('id','logo'));

    $coordinator = new Coordinator();
    $coordinator->setId($id);
    $coordinator->setRole($app->request()->put('role'));
    $coordinator->setName($app->request()->put('name'));
    $coordinator->setEventName($app->request()->put('event_name'));
    $coordinator->setContactNo($app->request()->put('contact_no'));
    if($coordinatorMapper->updateCoordinator($coordinator))
    {
        $status = 200;
        $response["code"] = $status;
        $response["message"] = "Coordinator {$coordinator->getId() } updated successfully.";
    }else
    {
        $status = 200;
        $response["code"] = $status;
        $response["message"] = "Some error occured while updating coordinator {$coordinator->getId()}.";
    }
    print (json_encode($response));



});



////////////////////////////////////////////////end Vaibhav;

function verifyRequiredParams($required_fields) {
    $error = false;
    $error_fields = "";
    $request_params = array();
    $request_params = $_REQUEST;
    // Handling PUT request params
    if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
        $app = \Slim\Slim::getInstance();
        parse_str($app->request()->getBody(), $request_params);
    }
    foreach ($required_fields as $field) {
        if (!isset($request_params[$field]) || strlen(trim($request_params[$field])) <= 0) {
            $error = true;
            $error_fields .= $field . ', ';
        }
    }

    if ($error) {
        // Required field(s) are missing or empty
        // echo error json and stop the app
        $response = array();
        $app = \Slim\Slim::getInstance();
        $response["error"] = 1;
        $response["error_message"] = 'Required field(s) ' . substr($error_fields, 0, -2) . ' is missing or empty';
       print json_encode($response);
        $app->stop();
    }
}


# ========================== CONTINGENTS ===================================
/**
 * @api {get} /contingents/all Requesting all contingents
 * @apiName Get All Contingents
 * @apiGroup Contingent
 *
 *
 * @apiSuccess {jsonObject} Contingents JSONObject containing contingents info & meta info. http://www.jsoneditoronline.org/?id=a1d0eb703336fa4f5eb93a72813c5a06
 *
 * @apiSuccessExample Success-Response:
 *     HTTP/1.1 200 OK
 *
 */
$app->get('/contingents/all', function () use($app,$contingentMapper) {
    $contingents = $contingentMapper->getAllColleges("HIDE_PASSWORD");
    $response = array();
    if($contingents) {

        $status = 200;
        $response["code"] = $status;
        $response["contingents"] = $contingents;
        $response["total_contingents"] = sizeof($contingents);
        $app->response->setStatus(200);

    }else{


        $response["error"] = 0;
        $response["message"] = "Oops, contingents not found";
        $response["total_contingents"] = 0;

    }
    print json_encode($response);
});

$app->put('/contingent/updateprofile/:id', function ($id) use($app,$contingentMapper) {
    $response = array();
    if(is_numeric($id))
    {
        verifyRequiredParams(array('cl_name','cl_contact','acl_1_name','acl_1_contact','acl_2_name','acl_2_contact'));

        $contingent = $contingentMapper->getContingentObject($id);

        $contingent->setAcl1Name($app->request->put('acl_1_name'));
        $contingent->setAcl1Contact($app->request->put('acl_1_contact'));
        $contingent->setAcl2Name($app->request->put('acl_2_name'));
        $contingent->setAcl2Contact($app->request->put('acl_2_contact'));
        $contingent->setClName($app->request->put('cl_name'));
        $contingent->setClContact($app->request->put('cl_contact') );
        $contingent->setClEmail($app->request->put('cl_email') );
        $contingent->setAcl1Email($app->request->put('acl_1_contact') );
        $contingent->setAcl2Email($app->request->put('acl_2_email') );



        if($contingentMapper->updateContingentProfile($contingent))
        {

            $status = 200;
            $response["code"] = $status;
            $response["message"] = "Contingent {$contingent->getId() } updated successfully.";
        }
        else
        {
            $status = 200;
            $response["code"] = $status;

            $response["error"] = 1;
            $response["error_message"] = "Some error occured while updating contingent {$contingent->getId()}.";
        }

    }else{
        $response["error"] = 1;
        $response["error_message"] = "Invalid ID,Expecting numeric ID";
    }

    print (json_encode($response));
});

$app->get('/registrations/contingents/eventname/:eventname', function ($eventName) use($app,$registrationMapper) {
    $response = array();
    if($registrationMapper->eventExists($eventName))
    {
        $contingents = $registrationMapper->getContingentsForEventByEventName($eventName);
        if($contingents) {

            $response["error"] = 0;
            $response["contingents"] = $contingents;
            $response["total_contingents"] = sizeof($contingents);

        }
        else{
            $response["error"] = 0;
            $response["message"] = "No contingent found for the event {$eventName}";
            $response["total_contingents"] = 0;
        }
    }
    else
    {
        $response["error"] = 1;
        $response["error_message"]="Event with name {$eventName} does not exist";

    }
    print (json_encode($response));

});

$app->post('/contingent/register/event', function () use($app,$registrationMapper,$eventMapper,$contingentMapper){

    $response =  array();
    verifyRequiredParams(array('contingentLoginID','eventID','teamsize','equipments'));

    $cid =$app->request->post('contingentLoginID');
    $eid= $app->request->post('eventID');
    $teamsize = $app->request->post('teamsize');
    $equipments = $app->request->post('equipments');

    if(!$registrationMapper->eventExistsByID($eid))
    {
        $response["error"] = 1 ;
        $response["error_message"] = "No event by id {$eid} exists";
    }
    else
    {
        if(!$contingentMapper -> contingentExists($cid))
        {
            $response["error"] = 1 ;
            $response["error_message"] = "No contingent by id {$cid} exists";
        }
        else
        {
            $contingentID = null;
            $contingent = $contingentMapper->getContingentByLoginId($cid);
            if($contingent instanceof Contingents)  $contingentID =  $contingent->getId();
            else $contingentID = $contingent["id"];
            if($registrationMapper->registerEventForContingent($contingentID,$eid,$teamsize,$equipments))
            {
                $response["error"] = 0;
                $response["message"] = "Successfully registered event";
            }
            else
            {
                $response["error"] = 1;
                $response["message"] = "Error.";
            }

        }
    }

    print json_encode($response);


});

$app->post('/contingent/update/event', function () use($app,$registrationMapper,$eventMapper,$contingentMapper){

    $response =  array();

    verifyRequiredParams(array('contingentLoginID','eventID','teamsize','equipments'));
    $cid =$app->request->post('contingentLoginID');
    $eid= $app->request->post('eventID');
    $teamsize = $app->request->post('teamsize');
    $equipments = $app->request->post('equipments');

    if(!$registrationMapper->eventExistsByID($eid))
    {
        $response["error"] = 1 ;
        $response["error_message"] = "No event by id {$eid} exists";
    }
    else
    {
        if(!$contingentMapper -> contingentExists($cid))
        {
            $response["error"] = 1 ;
            $response["error_message"] = "No contingent by id {$cid} exists";
        }
        else
        {
            $contingentID = null;
            $contingent = $contingentMapper->getContingentByLoginId($cid);
            if($contingent instanceof Contingents)  $contingentID =  $contingent->getId();
            else $contingentID = $contingent["id"];
            if($registrationMapper->updateEventForContingent($contingentID,$eid,$teamsize,$equipments))
            {
                $response["error"] = 0;
                $response["message"] = "Successfully updated registered event";
            }
            else
            {
                $response["error"] = 1;
                $response["message"] = "Error.";
            }

        }
    }

    print json_encode($response);


});

#Trying same stuff here^ using PUT
$app->put('/contingent/update/event', function () use($app,$registrationMapper,$eventMapper,$contingentMapper){

    $response =  array();

    verifyRequiredParams(array('contingentLoginID','eventID','teamsize','equipments'));
    $cid =$app->request->put('contingentLoginID');
    $eid= $app->request->put('eventID');
    $teamsize = $app->request->put('teamsize');
    $equipments = $app->request->put('equipments');

    if(!$registrationMapper->eventExistsByID($eid))
    {
        $response["error"] = 1 ;
        $response["error_message"] = "No event by id {$eid} exists";
    }
    else
    {
        if(!$contingentMapper -> contingentExists($cid))
        {
            $response["error"] = 1 ;
            $response["error_message"] = "No contingent by id {$cid} exists";
        }
        else
        {
            $contingentID = null;
            $contingent = $contingentMapper->getContingentByLoginId($cid);
            if($contingent instanceof Contingents)  $contingentID =  $contingent->getId();
            else $contingentID = $contingent["id"];
            if($registrationMapper->updateEventForContingent($contingentID,$eid,$teamsize,$equipments))
            {
                $response["error"] = 0;
                $response["message"] = "Successfully updated registered event";
            }
            else
            {
                $response["error"] = 1;
                $response["message"] = "Error.";
            }

        }
    }

    print json_encode($response);


});

$app->delete('/contingent/register/event/:event/?loginid=:contingentloginid', function ($event,$contingentloginid) use($app,$registrationMapper,$eventMapper,$contingentMapper){

    $response =  array();
   # verifyRequiredParams(array('contingentLoginID','eventID'));

   # $cid =$app->request->delete('contingentLoginID');
  # $eid= $app->request->delete('eventID');

    $eid = $event;
    $contingent =$contingentloginid;
    if(!$registrationMapper->eventExistsByID($eid))
    {
        $response["error"] = 1 ;
        $response["error_message"] = "No event by id {$eid} exists";
    }
    else
    {
        if(!$contingentMapper -> contingentExists($contingentloginid))
        {
            $response["error"] = 1 ;
            $response["error_message"] = "No contingent by id {$contingentloginid} exists";
        }
        else
        {
            $contingentID = null;
            $contingent = $contingentMapper->getContingentByLoginId($contingentloginid);
            if($contingent instanceof Contingents)  $contingentID =  $contingent->getId();
            else $contingentID = $contingent["id"];


            if($registrationMapper->UnregisterEventForContingent($contingentID,$eid))
            {
                $response["error"] = 0;
                $response["message"] = "Successfully unregistered event";
            }
            else
            {
                $response["error"] = 1;
                $response["message"] = "Error.";
            }

        }
    }

    print json_encode($response);


});
# =============================END OF CONTINGENTS================================================


# ==========================  NON- CONTINGENTS ===================================
$app->get('/noncontingents/all', function () use($app,$contingentMapper) {

});

$app->post('/noncontingents/register', function () use($app,$NonContingentMapper,$registrationMapper) {
    $response = array();

    verifyRequiredParams(array('name','leader_email','leader_contact','leader_name'));


    # PART 1 : Register NoNContingent and generate the ID
    $nonContingent = new \Udaan\NonContingents();

    $nonContingent->setName($app->request()->post('name'));
    $nonContingent->setLeaderName($app->request()->post('leader_name'));
    $nonContingent->setLeaderEmail($app->request()->post('leader_email'));
    $nonContingent->setLeaderContact($app->request()->post('leader_contact'));

    #Optional parameters
    $nonContingent->setLeader2Contact($app->request()->post('leader_2_contact'));
    $nonContingent->setLeader2Email($app->request()->post('leader_2_email'));
    $nonContingent->setLeader2Name($app->request()->post('leader_2_name'));
    $nonContingent->setTYPE("NC");



    $NCGenratedID = $NonContingentMapper->registerNonContingent($nonContingent);

    # PART 2 : Register the events for the given noncontingent
    if($NCGenratedID)
    {
        $status = 201;
        $response["error"] = 0;
        $response["code"] = $status;
        $response["message"] = "NonContingent Created successfully.";

        $eventIdArray = $app->request->post('eventid');
        $equipmentArray = $app->request->post('equipments');
        $teamsizeArray = $app->request->post('teamsize');

        $eventRegDataHolder = array();

        for ( $i =  0 ; $i <  sizeof($eventIdArray) ; $i++ )
        {
            if ( isset($eventIdArray[$i])  && $eventIdArray[$i]!="" && isset ( $teamsizeArray[$i] ) && $teamsizeArray[$i]!="" )
            {
                $eventReg["EVENT_ID"] = $eventIdArray[$i];
                $eventReg["EQUIPMENTS_NEEDED"] = $equipmentArray[$i];
                $eventReg["TEAM_SIZE"] = $teamsizeArray[$i];
                $eventRegDataHolder[] = $eventReg;
            }
        }

        $id =  $NonContingentMapper ->getIDByRegistrationID($NCGenratedID);
        if($registrationMapper->registerEventsForNonContingent($id,$eventRegDataHolder))
        {
            $response["message"].= "Successfully registered for the events";
        }
    }
    else
    {
        $response["error"] = 1;

        $response["error_message"] = "Problem";
    }

    print json_encode($response);


});


# ==========================  END OF NON CONTINGENTS===============================================


#=============================== ONSPOT =================================

$app->post('/onspot/register', function () use($app,$onSpotMapper,$registrationMapper) {
    $response = array();

    verifyRequiredParams(array('name','leader_email','leader_contact','leader_name'));


    # PART 1 : Register NoNContingent and generate the ID
    $onspot = new \Udaan\Onspot();

    $onspot->setName($app->request()->post('name'));
    $onspot->setLeaderName($app->request()->post('leader_name'));
    $onspot->setLeaderEmail($app->request()->post('leader_email'));
    $onspot->setLeaderContact($app->request()->post('leader_contact'));

    #Optional parameters
    $onspot->setLeader2Contact($app->request()->post('leader_2_contact'));
    $onspot->setLeader2Email($app->request()->post('leader_2_email'));
    $onspot->setLeader2Name($app->request()->post('leader_2_name'));
    $onspot->setTYPE("OS");



    $OSGeneratedID = $onSpotMapper->registerOnSpot($onspot);

    # PART 2 : Register the events for the given Onspot
    if($OSGeneratedID)
    {
        $status = 201;
        $response["error"] = 0;
        $response["code"] = $status;
        $response["message"] = "Onspot entry created successfully.";

        $eventIdArray = $app->request->post('eventid');
        $teamsizeArray = $app->request->post('teamsize');

        $eventRegDataHolder = array();

        for ( $i =  0 ; $i <  sizeof($eventIdArray) ; $i++ )
        {
            if ( isset($eventIdArray[$i])  && $eventIdArray[$i]!="" && isset ( $teamsizeArray[$i] ) && $teamsizeArray[$i]!="" )
            {
                $eventReg["EVENT_ID"] = $eventIdArray[$i];
                $eventReg["TEAM_SIZE"] = $teamsizeArray[$i];
                $eventRegDataHolder[] = $eventReg;
            }
        }

        $id =  $onSpotMapper ->getIDByRegistrationID($OSGeneratedID);
        if($registrationMapper->registerEventsForOnSpot($id,$eventRegDataHolder))
        {
            $response["message"].= "Successfully registered for the events";
        }
    }
    else
    {
        $response["error"] = 1;

        $response["error_message"] = "Problem";
    }

    print json_encode($response);


});

# ==========================  ON THE SPOT ===================================


#============================================================================

# ========================== REGISTRATIONS===========================================================

$app->get('/registrations/all', function () use($app,$contingentMapper) {

});

/**
 * @api {get} /registrations/contingents/event/:event Get Registrations of contingents for given event.
 * @apiName GetRegistrationsOfContingentForEvent
 * @apiGroup Registration
 *
 * @apiParam {String } String Event name.
 *
 * @apiSuccess {jsonObject} registrations  All registrations
 *
 * @apiSuccessExample Success-Response:
 * HTTP/1.1 200 No registrations for event
 *{"error":0,"message":"No contingent found for the event 1","total_contingents":0}
 * @apiError Event The event of with given name was not found.
 *
 * @apiErrorExample Error-Response:
 *     HTTP/1.1 200 Not Found
 *
 *    {
 *        "error":1,
 *        "error_message":"Event with name missionsql not found"
 *      }
 *
 *
 */
$app->get('/registrations/contingents/event/:event', function ($event) use($app,$registrationMapper) {
        $response = array();
        if(is_numeric($event))
        {
            $contingents = $registrationMapper->getContingentsForEventByEventId($event);
            if($contingents) {

                $response["error"] = 0;
                $response["contingents"] = $contingents;
                $response["total_contingents"] = sizeof($contingents);

            }
            else{
                $response["error"] = 0;
                $response["message"] = "No contingent found for the event {$event}";
                $response["total_contingents"] = 0;
            }
        }
        else
        {  // Not Numeric i.e by Name
            if ($registrationMapper->eventExists($event)) {

                $contingents = $registrationMapper->getContingentsForEventByEventName($event);
                if ($contingents) {

                    $response["error"] = 0;
                    $response["contingents"] = $contingents;
                    $response["total_contingents"] = sizeof($contingents);

                } else {
                    $response["error"] = 0;
                    $response["message"] = "No contingent found for the event {$event}";
                    $response["total_contingents"] = 0;
                }
            }
            else{
                $response["error"] = 1;
                $response["error_message"] = "Event with name {$event} not found";
            }
        }

        print (json_encode($response));

});




# =================================== END OF REGISTRATIONS ===========================================================

$app->get('/events/contingents/:id', function($id) use($app,$contingentMapper) {

    $registered_events = $contingentMapper->getRegisteredEvents($id);
    $unregistered_events = $contingentMapper->getUnregisteredEvents($id);

    $response = array();
    if($registered_events || $unregistered_events)
    {
        $status = 200;
        $response["error"] = 0;
        $response["code"] = $status;
        $response["registered_events"] = array();
        $response["unregistered_events"] = array();
        $response["total_events"] =sizeof($registered_events)+sizeof($unregistered_events);
        array_push($response["registered_events"], $registered_events);
        array_push($response["unregistered_events"], $unregistered_events);
        $app->response->setStatus(200);
    }
    else
    {
        $status = 204;
        $response["error"] = 0;
        $response["total_events"] = 0;
        $response["message"] = "Oops, Events not found";
    }
    print (json_encode($response));

});

$app->post('/login',function() use ($app,$contingentMapper)
{    
    $response = array(); 
    $loginid = $app->request()->post('loginid');
    $password = $app->request()->post('password');
    $contingent = $contingentMapper->getContingentByLoginId($loginid);
    
    if($contingent instanceof Contingents)
    {
        if($password == $contingent->getPassword())
        {
            $status = 200;
            $response["code"] = $status;
            $response["error"] = 04;
            $response["message"] = "Contingent {$contingent->getId() } logged in successfully.";
            $response["id"] = $contingent->getId();
        }
        else
        {
            $status = 200;
            $response["code"] = $status;
            $response["error"] = 1;
            $response["error_message"] = "Incorrect Password";
        }    
    }
    else
    {
        $response["error"] = 1;
        $response["error_message"] = "Loginid does not exist"; 
    }
    print (json_encode($response));    

});



$app->put('/contingent/updateprofile/:id', function ($id) use($app,$contingentMapper) {
    $response = array();
    if(is_numeric($id))
    {
    verifyRequiredParams(array('cl_name','cl_contact','acl_1_name','acl_1_contact','acl_2_name','acl_2_contact'));

    $contingent = $contingentMapper->getContingentObject($id);

    $contingent->setAcl1Name($app->request->put('acl_1_name'));
    $contingent->setAcl1Contact($app->request->put('acl_1_contact'));
    $contingent->setAcl2Name($app->request->put('acl_2_name'));
    $contingent->setAcl2Contact($app->request->put('acl_2_contact'));
    $contingent->setClName($app->request->put('cl_name'));
    $contingent->setClContact($app->request->put('cl_contact') );
    $contingent->setClEmail($app->request->put('cl_email') );
    $contingent->setAcl1Email($app->request->put('acl_1_contact') );
    $contingent->setAcl2Email($app->request->put('acl_2_email') );
    $contingent->setIsFirstLogin('no');

    if($contingentMapper->updateContingentProfile($contingent))
    {

            $status = 200;
            $response["code"] = $status;
            $response["message"] = "Contingent {$contingent->getId() } updated successfully.";
    }
    else
    {
            $status = 200;
            $response["code"] = $status;

            $response["error"] = 1;
            $response["error_message"] = "Some error occured while updating contingent {$contingent->getId()}.";
    }

    }else{
        $response["error"] = 1;
        $response["error_message"] = "Invalid ID,Expecting numeric ID";
    }

      print (json_encode($response));
});

$app->post('/contingent/firstlogin', function () use($app,$contingentMapper) {
    $response = array();
    $id = $app->request()->post('id');
    if(is_numeric($id))
    {
    
        $contingent = $contingentMapper->getContingentObject($id);


        if($contingent instanceof Contingents)
        {

                $status = 200;
                $response["code"] = $status;
                $response["is_first_login"] = $contingent->getIsFirstLogin();
        }
        
    }
    else
    {
        $response["error"] = 1;
        $response["error_message"] = "Invalid ID,Expecting numeric ID";
    }

      print (json_encode($response));
});


$app->put('/event/:id',function($id) use ($app,$eventMapper){
    verifyRequiredParams(array('id','logo'));

    $event = new Event();
    $event->setId($id);
    $event->setName($app->request()->put('name'));
    $event->setDetails($app->request()->put('details'));
    $event->setSlogan($app->request()->put('slogan'));
    $event->setCategory($app->request()->put('type'));
    $event->setRules($app->request()->put('rules'));
    $event->setStartDate($app->request()->put('start_date'));
    $event->setEndDate($app->request()->put('end_date'));
    $event->setStartTime($app->request()->put('start_time'));
    $event->setEndTime($app->request()->put('end_time'));
    $event->setGroupSize($app->request()->put('group_size'));
    $event->setLogo($app->request()->put('logo'));

    # --Getting the put vars and typecasting to int. Blehhh. Can't help, its PHP xD
    $feeHome = $app->request()->put('fee_home');
    settype($feeHome,"integer");
    $feeRemote = $app->request()->put('fee_remote');
    settype($feeRemote,"integer");
    #--

    $event->setFeeHome($feeHome);
    $event->setFeeRemote($feeRemote);
    $event->setLocation($app->request()->put('location'));
    $event->setEventHeadName($app->request()->put('event_head_name'));
    $event->setEventHeadContact($app->request()->put('event_head_contact'));
    $event->setAward($app->request()->put('award'));
    $event->setEquipmentProvided($app->request()->put('equipments_provided'));

    if($eventMapper->updateEvent($event))
    {
        $status = 200;
        $response["code"] = $status;
        $response["message"] = "Event {$event->getId() } updated successfully.";
    }else
    {
        $status = 200;
        $response["code"] = $status;
        $response["message"] = "Some error occured while updating event {$event->getId()}.";
    }
    print (json_encode($response));



});

# ============================= ANALYSIS & VISUALIZATION =================

$app->get('/count/registrations/events',function() use ($app,$registrationMapper){



    $response = array();
    $result = $registrationMapper->getCountOfRegistrationAllEvents();
    if($result)
    {
        $response["result"] = $result;
        $response["error"] = 0;
    }
    else
    {

        $response["error"] = 1;
    }
    print (json_encode($response));



});


# =======================================================================


$app->notFound(function () {
    $status = 404;
    $response["code"] = $status;
    $response["error"] = 1;
    $response["error_message"] = "Page or URL not found";
    print json_encode($response);
});
$app->run();