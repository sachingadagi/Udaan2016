<?php
/**
 * Created by PhpStorm.
 * User: Sarvesh
 * Date: 12/6/2015
 * Time: 8:23 AM
 */


namespace Udaan;

use PDO;
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once "$root/Udaan2016/fms/utilities/Database.class.php";



class NonContingentMapper
{

    private $databaseHandler = null;

    function __construct()
    {
        $this->databaseHandler = Database::connect();
    }

    public function getAll()
    {
        $allColleges = array();
        $sth = $this->databaseHandler->query("SELECT * FROM onspot_noncontingent");
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

    public function generateNonContingentID(){


            $chars = "1234567890";
            $registration_id = substr( str_shuffle($chars), 0 ,5);
            return $registration_id;


    }
    public function registerNonContingent($NonContingent)
    {
        if ($NonContingent instanceof NonContingents) {

            $generatedID = $this->generateNonContingentID();

            $sth = $this->databaseHandler->prepare("INSERT INTO onspot_noncontingent
                (name,leader_email,leader_name,leader_contact,leader_2_name,leader_2_contact,registration_id,TYPE)
              VALUES(:name,:leader_email,:leader_name,:leader_contact,:leader_2_name,:leader_2_contact,:registration_id,:type)");

            $sth->execute(array(

                ':name' => $NonContingent->getName(),
                ':leader_name' => $NonContingent->getLeaderName(),
                ':leader_contact' => $NonContingent->getLeaderContact(),
                ':leader_email' => $NonContingent->getLeaderEmail(),

                ':leader_2_name' => $NonContingent->getLeader2Name(),

                ':leader_2_contact' => $NonContingent->getLeader2Contact(),

                ':registration_id' => $generatedID,
                ':type' => $NonContingent->getTYPE()

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