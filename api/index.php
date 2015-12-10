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



// Autoloading the slim
\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();

// Very imp. Since we are interested with only REST API in the file, setting all of the response content type as JSON.
$app->response->headers->set('Content-Type', 'application/json');

// EventMapper object
$eventMapper = new \Udaan\EventMapper();

//Contingent Mapper object
$contingentMapper = new \Udaan\ContingentMapper();

//Registrations mapper
$registrationMapper = new \Udaan\Registrations();


// ALL of the functions that respond according to request depending upon URL requests,begin here.


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

$app->get('/noncontingents/all', function () use($app,$contingentMapper) {

});

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



$app->notFound(function () {
    $status = 404;
    $response["code"] = $status;
    $response["error"] = 1;
    $response["error_message"] = "Page or URL not found";
    print json_encode($response);
});
$app->run();