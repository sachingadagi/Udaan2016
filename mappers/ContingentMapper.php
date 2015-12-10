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
require_once "$root/Udaan2016/fms/models/Contingents.class.php";



class ContingentMapper
{

    private $databaseHandler = null;


    function __construct()
    {
        $this->databaseHandler = Database::connect();
    }

    public function getAllColleges($PASSWORD_REQUEST="ALLOW_PASSWORD")
    {

        $allContingents = array();
        $sth = $this->databaseHandler->query("SELECT * FROM contingent_college  ");
        $sth->setFetchMode(PDO::FETCH_BOTH);

        if ($sth->rowCount() > 0) {
            while ($ob = $sth->fetch()) {
                if($PASSWORD_REQUEST == "HIDE_PASSWORD") {
                    unset($ob["password"]); #Hiding up password from bad eyes
                    unset($ob["3"]);
                }
                array_push($allContingents, $ob);
            }

            return $allContingents;

        } else {
            return FALSE;
        }
    }
    public function getContingentObject($id)
    {
        $sth = $this->databaseHandler->query("SELECT * FROM contingent_college WHERE id = {$id}");
        $sth->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Contingents');
        $sth->execute();
        return $sth->fetch();
    }

    public function createContingent($contingent)

    {
        if($contingent  instanceof \Contingents)
        {

        }
    }

    public function updateContingentProfile($contingent)
    {
        if ($contingent instanceof \Contingents) {
            try {

                #    $sth->execute((array)$event);
                $sth = $this->databaseHandler->prepare("UPDATE contingent_college SET
                cl_name = :cl_name,cl_contact= :cl_contact,acl_1_name= :acl_1_name,acl_1_contact = :acl_1_contact,acl_2_name= :acl_2_name,acl_2_contact = :acl_2_contact,cl_email=:cl_email,acl_1_email = :acl_1_email,acl_2_email = :acl_2_email
                WHERE id = :id ");
                $sth->execute(array(
                    ':cl_name' => $contingent->getClName(),
                    ':cl_contact' => $contingent->getClContact(),
                    ':acl_1_name' => $contingent->getAcl1Name(),
                    ':acl_1_contact' => $contingent->getAcl1Contact(),
                    ':acl_2_name' => $contingent->getAcl2Name(),
                    ':acl_2_contact' => $contingent->getAcl2Contact(),
                    ':cl_email' => $contingent->getClEmail(),
                    ':acl_1_email' => $contingent->getAcl1Email(),
                    ':acl_2_email' => $contingent->getAcl2Email(),
                    ':id' => $contingent->getId()

                ));

                return TRUE;

            } catch (\PDOException $PDOE) {
                echo $PDOE->getMessage();
                return FALSE;
            }catch(\Exception $e)
            {
                echo $e->getMessage();
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

}