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

    public function eventExistsByID($eventID)
    {
        $sth = $this->dbh->query("SELECT * from  event WHERE id = $eventID ");
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

    public function registerEventForContingent($cid, $eid, $teamsize, $equipments)
    {
        try {

                $sth = $this->dbh->prepare("INSERT INTO registered_events_contingent (contingent_id,event_id,equipments_needed,number_of_participants,regdate)
            values (:contingent_id,:event_id,:equipments_needed,:number_of_participants,NOW())");
                $sth->execute(array(
                    ':contingent_id' => $cid,
                    ':event_id' => $eid,
                    ':equipments_needed' => $equipments,
                    ':number_of_participants' =>  $teamsize

                ));



        }catch (\PDOException $pdoe)
        {
            echo $pdoe->getMessage();
        }
        return true;
    }

    public function UnregisterEventForContingent($contingentID, $eid)
    {
        try {

            $sth = $this->dbh->prepare("DELETE FROM registered_events_contingent WHERE contingent_id = :contingent_id AND event_id = :event_id ");

            $sth->execute(array(
                ':contingent_id' => $contingentID,
                ':event_id' => $eid
            ));



        }catch (\PDOException $pdoe)
        {
            echo $pdoe->getMessage();
            return false;
        }
        return true;
    }

    public function updateEventForContingent($contingentID, $eid, $teamsize, $equipments)
    {
        try {

        $sth = $this->dbh->prepare("UPDATE  registered_events_contingent SET  equipments_needed = :equipments_needed,number_of_participants=:number_of_participants
                                WHERE contingent_id = :contingent_id AND event_id= :event_id");

        $sth->execute(array(
            ':contingent_id' => $contingentID,
            ':event_id' => $eid,
            ':equipments_needed' => $equipments,
            ':number_of_participants' =>  $teamsize

        ));



    }catch (\PDOException $pdoe)
        {
            echo $pdoe->getMessage();
            return false;
        }
        return true;
    }
}