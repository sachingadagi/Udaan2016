<?php
/**
 * Created by PhpStorm.
 * User: tuxer
 * Date: 12/8/2015
 * Time: 12:44 PM
 */

namespace Udaan;
use PDO;
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once "$root/Udaan2016/fms/models/Contingents.class.php";

class Registrations {

    protected $dbh = null;
    function __construct()
    {

        $this->dbh = Database::connect();
    }

    public function getContingentsForEventByEventId($eventid)
    {
        $allContingents = array();
        $sth = $this->dbh->query("SELECT rec.contingent_id,cc.name FROM `registered_events_contingent` rec INNER JOIN `contingent_college` cc ON rec.contingent_id = cc.id WHERE event_id = $eventid");
        $sth->setFetchMode(PDO::FETCH_ASSOC);

        if ($sth->rowCount() > 0) {
            while ($ob = $sth->fetch()) {
                array_push($allContingents, $ob);
            }

            return $allContingents;

        } else {
            return FALSE;
        }
    }
    public function getContingentsForEventByEventName($eventName)
    {
        $allContingents = array();
        $sth = $this->dbh->query("SELECT rec.contingent_id,cc.name FROM `registered_events_contingent` rec INNER JOIN `contingent_college` cc ON rec.contingent_id = cc.id WHERE event_id = (SELECT id from event WHERE name = '$eventName')");
        $sth->setFetchMode(PDO::FETCH_ASSOC);

        if ($sth->rowCount() > 0) {
            while ($ob = $sth->fetch()) {
                array_push($allContingents, $ob);
            }

            return $allContingents;

        } else {
            return FALSE;
        }
    }

    public function eventExists($eventName)
    {
        $sth = $this->dbh->query("SELECT * from  event WHERE name = '$eventName'");
        $sth->setFetchMode(PDO::FETCH_ASSOC);

        if ($sth->rowCount() > 0) {
            return true;
            }
        else{
            return false;
        }
    }


    public  function  registerEventsForNonContingent($NCID,$eventRegistrationData)
    {


        try {


            for ($i = 0; $i < sizeof($eventRegistrationData); $i++) {
                $sth = $this->dbh->prepare("INSERT INTO registered_events_onspot_noncontingent (onspot_NC_id,event_id,equipments_needed,number_of_participants,regdate)
            values (:onspot_NC_id,:event_id,:equipments_needed,:number_of_participants,NOW())");
                $sth->execute(array(
                    ':onspot_NC_id' => $NCID,
                    ':event_id' => $eventRegistrationData[$i]["EVENT_ID"],
                    ':equipments_needed' => $eventRegistrationData[$i]["EQUIPMENTS_NEEDED"],
                    ':number_of_participants' =>  $eventRegistrationData[$i]["TEAM_SIZE"]

                ));


            }


        }catch (\PDOException $pdoe)
        {
            echo $pdoe->getMessage();
        }
        return true;
    }


    public  function  registerEventsForOnSpot($OSID,$eventRegistrationData)
    {


        try {


            for ($i = 0; $i < sizeof($eventRegistrationData); $i++) {
                $sth = $this->dbh->prepare("INSERT INTO registered_events_onspot_noncontingent (onspot_NC_id,event_id,equipments_needed,number_of_participants,regdate)
            values (:onspot_NC_id,:event_id,:equipments_needed,:number_of_participants,NOW())");
                $sth->execute(array(
                    ':onspot_NC_id' => $OSID,
                    ':event_id' => $eventRegistrationData[$i]["EVENT_ID"],
                    ':equipments_needed' => "",
                    ':number_of_participants' =>  $eventRegistrationData[$i]["TEAM_SIZE"]

                ));


            }


        }catch (\PDOException $pdoe)
        {
            echo $pdoe->getMessage();
        }
        return true;
    }
}