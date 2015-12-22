<?php
/**
 * Created by PhpStorm.
 * User: tuxer
 * Date: 12/16/2015
 * Time: 1:12 PM
 */

namespace Udaan;


class OnSpotMapper {
    private $databaseHandler = null;

    function __construct()
    {
        $this->databaseHandler = Database::connect();
    }

    public function getAll()
    {
        $allColleges = array();
        $sth = $this->databaseHandler->query("SELECT * FROM onspot_noncontingent WHERE TYPE='OS'");
        #  $sth->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE,'Event');

        if ($sth->rowCount() > 0) {
            while ($ob = $sth->fetch()) {
                array_push($allColleges, $ob);
            }

            return $allColleges;

        } else {
            return FALSE;
        }
    }

    public function generateOnSpotID(){


        $chars = "1234567890";
        $registration_id = substr( str_shuffle($chars), 0 ,5);
        return $registration_id;


    }
    public function registerOnSpot($OnSpot)
    {
        if ($OnSpot instanceof Onspot) {

            $generatedID = $this->generateOnSpotID();

            $sth = $this->databaseHandler->prepare("INSERT INTO onspot_noncontingent
                (name,leader_email,leader_name,leader_contact,leader_2_name,leader_2_contact,registration_id,TYPE)
              VALUES(:name,:leader_email,:leader_name,:leader_contact,:leader_2_name,:leader_2_contact,:registration_id,:type)");

            $sth->execute(array(

                ':name' => $OnSpot->getName(),
                ':leader_name' => $OnSpot->getLeaderName(),
                ':leader_contact' => $OnSpot->getLeaderContact(),
                ':leader_email' => $OnSpot->getLeaderEmail(),

                ':leader_2_name' => $OnSpot->getLeader2Name(),

                ':leader_2_contact' => $OnSpot->getLeader2Contact(),

                ':registration_id' => $generatedID,
                ':type' => $OnSpot->getTYPE()

            ));
            return $generatedID;
        } else {
            return FALSE;
        }
    }
    public function getIDByRegistrationID ($registrationID)
    {
        $sth = $this->databaseHandler->query("SELECT id FROM onspot_noncontingent WHERE registration_id =  $registrationID");
        $sth->execute();
        $ID = $sth->fetchColumn(0);

        if ($ID)
            return $ID;
        else
            return false;
    }
}