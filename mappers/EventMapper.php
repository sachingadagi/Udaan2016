<?php
/**
 * Created by PhpStorm.
 * User: tuxer
 * Date: 12/5/2015
 * Time: 12:41 AM
 */

namespace Udaan;

use PDO;

$root = realpath($_SERVER["DOCUMENT_ROOT"]);

require_once "$root/Udaan2016/fms/utilities/Database.class.php";
require_once "$root/Udaan2016/fms/utilities/JSONifyErrors.php";

use Udaan\Database;
use JSONifyErrors;


class EventMapper
{

    private $databaseHandler = null;


    function __construct()
    {
        $this->databaseHandler = Database::connect();
    }

    public function getAllEvents()
    {
        $allEvents = array();
        $sth = $this->databaseHandler->query("SELECT * FROM EVENT WHERE is_deleted= 0 ");
        $sth->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Event');

        if ($sth->rowCount() > 0) {
            while ($ob = $sth->fetch()) {
                #Strict type checking
                #if ($ob instanceof \Event)
                #$ob->setLogo( $this->logo = \Udaan\Config::getLogoDirectory().$ob->getLogo());
                array_push($allEvents, $ob);
            }

            return $allEvents;

        } else {
            return FALSE;
        }
    }
    public function getEventObject($id)
    {
        $sth = $this->databaseHandler->query("SELECT * FROM EVENT WHERE id = {$id}");
        $sth->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Event');
        $sth->execute();
        return $sth->fetch(); // Returns the event object
    }

    public function getEvent($id)
    {
        $event = array();
        $sth = $this->databaseHandler->query("SELECT * FROM EVENT WHERE id = {$id}");
        $sth->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Event');

        if ($sth->rowCount() > 0) {
            while ($ob = $sth->fetch()) {

                #Important
                #if($ob instanceof \Event)
                #$ob->setLogo( $this->logo = \Udaan\Config::getLogoDirectory().$ob->getLogo());

                array_push($event, $ob);

            }
            return $event;
        } else {
            return FALSE;
        }
    }

    public function getEventsByDay($day)
    {

    }

    public function insertEvent()
    {
    }

    public function updateEvent($event)
    {
        if ($event instanceof \Event) {
            try {
                #$sth = $this->databaseHandler->prepare("INSERT INTO EVENT(id,name,details,slogan,logo,type,rules,start_date,end_date,start_time,end_time,group_size,fee_home,fee_remote,location,event_head_name,event_head_contact,equipments_provided,award,is_deleted) VALUES(:id,:name,:details,:slogan,:type,:rules,:start_date,:end_date,:start_time,:end_time,:group_size,:fee_home,:logo,:fee_remote,:location,:event_head_name,:event_head_contact,:equipments_provided,:award,:is_deleted)");
                /*$sth = $this->databaseHandler->prepare("UPDATE  EVENT SET
  	name = :name ,details = :details,slogan = :slogan,logo=:logo,type=:logo,rules=:rules,start_date=:start_date,end_date=:end_date,start_time=:start_time,end_time=:end_time,
  	group_size=:group_size,fee_home=:fee_home,fee_remote=:fee_remote,location=:location,event_head_name=:event_head_name,event_head_contact=:event_head_contact,
  	equipments_provided=:equipments_provided,award=:award WHERE id = :id");*/
                #    $sth->execute((array)$event);
                $sth = $this->databaseHandler->prepare("UPDATE  EVENT SET
  	          name = :name ,slogan = :slogan ,details = :details,logo=:logo,type=:type,rules=:rules,group_size = :group_size,fee_home=:fee_home,
  	          fee_remote = :fee_remote ,location = :location , event_head_name = :event_head_name,event_head_contact = :event_head_contact,equipments_provided = :equipments_provided,
  	          start_date = :start_date , start_time = :start_time, end_date = :end_date , end_time = :end_time ,award = :award WHERE id = :id");
                $sth->execute(array(
                    ':id' => $event->getId(),
                    ':name' => $event->getName(),
                    ':details' => $event->getDetails(),
                    ':slogan' => $event->getSlogan(),
                    ':logo' => $event->getLogo(),
                    ':type' => $event->getType(),
                    ':rules' => $event->getRules(),
                    ':start_date' => $event->getStartDate(),
                    ':end_date' => $event->getEndDate(),
                    ':start_time' => $event->getStartTime(),
                    ':end_time' => $event->getEndTime(),
                    ':group_size' => $event->getGroupSize(),
                    ':fee_home' => $event->getFeeHome(),
                    ':fee_remote' => $event->getFeeRemote(),
                    ':location' => $event->getLocation(),
                    ':event_head_name' => $event->getEventHeadName(),
                    ':event_head_contact' => $event->getEventHeadContact(),
                    ':equipments_provided' => $event->getEquipmentsProvided(),
                    ':award' => $event->getAward()

                ));

                return TRUE;

            } catch (\PDOException $PDOE) {



                return FALSE;
            }

        } else {
            return FALSE;
        }


    }

    public function deleteEvent($id)
    {
        $sth = $this->databaseHandler->prepare("DELETE FROM EVENT WHERE id = {$id}");

        $sth->execute();

        header('Location: events.php');

    }

    public function createEvent($event)
    {
        if ($event instanceof \Event) {
            try {

                $sth = $this->databaseHandler->prepare("INSERT INTO EVENT
                (name,details,slogan,logo,category,rules,start_date,end_date,start_time,end_time,
                group_size,fee_home,fee_remote,location,event_head_name,event_head_contact,
                equipments_provided,award)
              VALUES(:name,:details,:slogan,:logo,:category,:rules,:start_date,:end_date,:start_time,:end_time,
                :group_size,:fee_home,:fee_remote,:location,:event_head_name,:event_head_contact,
                :equipments_provided,:award)");


                $sth->execute(array(

                    ':name' => $event->getName(),
                    ':details' => $event->getDetails(),
                    ':slogan' => $event->getSlogan(),
                    ':logo' => $event->getLogo(),
                    ':category' => $event->getCategory(),
                    ':rules' => $event->getRules(),
                    ':start_date' => $event->getStartDate(),
                    ':end_date' => $event->getEndDate(),
                    ':start_time' => $event->getStartTime(),
                    ':end_time' => $event->getEndTime(),
                    ':group_size' => $event->getGroupSize(),
                    ':fee_home' => $event->getFeeHome(),
                    ':fee_remote' => $event->getFeeRemote(),
                    ':location' => $event->getLocation(),
                    ':event_head_name' => $event->getEventHeadName(),
                    ':event_head_contact' => $event->getEventHeadContact(),
                    ':equipments_provided' => $event->getEquipmentProvided(),
                    ':award' => $event->getAward()

                ));

                return TRUE;

            } catch (\PDOException $PDOE) {
                $je = new JSONifyErrors($PDOE);

                $je->prepareJSON();
                print ($PDOE->getMessage());
            } catch (\Exception $e) {
                return FALSE;
            }

        } else {
            return FALSE;
        }

    }

}