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


class CoordinatorMapper
{

    private $databaseHandler = null;


    function __construct()
    {
        $this->databaseHandler = Database::connect();
    }

    public function getAllCoordinators()
    {
        $allCoordinators = array();
        $sth = $this->databaseHandler->query("SELECT * FROM COORDINATORS WHERE is_deleted= 0 ");
        $sth->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Coordinator');

        if ($sth->rowCount() > 0) {
            while ($ob = $sth->fetch()) {
                array_push($allCoordinators, $ob);
            }

            return $allCoordinators;

        } else {
            return FALSE;
        }
    }
    public function getCoordinatorObject($id)
    {
        $sth = $this->databaseHandler->query("SELECT * FROM COORDINATORS WHERE id = {$id}");
        $sth->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Coordinator');
        $sth->execute();
        return $sth->fetch(); // Returns the coordinator object
    }

    public function getCoordinator($id)
    {
        $coordinator = array();
        $sth = $this->databaseHandler->query("SELECT * FROM COORDINATORS WHERE id = {$id}");
        $sth->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Coordinator');

        if ($sth->rowCount() > 0) {
            while ($ob = $sth->fetch()) {

                array_push($coordinator, $ob);

            }
            return $coordinator;
        } else {
            return FALSE;
        }
    }

    public function updateCoordinator($coordinator)
    {
        if ($coordinator instanceof \Coordinator) {
            try {
                $sth = $this->databaseHandler->prepare("UPDATE COORDINATORS SET
  	          role = :role ,name = :name ,event_name = :event_name ,contact_no = :contact_no WHERE id = :id");
   
   $sth->execute(array(

					':id' => $coordinator->getId(),
                    ':role' => $coordinator->getRole(),
                    ':name' => $coordinator->getName(),
                    ':event_name' => $coordinator->getEventName(),
                    ':contact_no' => $coordinator->getContactNo()

                ));

                return TRUE;

            } catch (\PDOException $PDOE) {

                return FALSE;
            }

        } else {
            return FALSE;
        }


    }

    public function deleteCoordinator($id)
    {
        $sth = $this->databaseHandler->prepare("DELETE FROM COORDINATORS WHERE id = {$id}");

        $sth->execute();

        header('Location: coordinators.php');

    }

    public function createCoordinator($coordinator)
    {
        if ($coordinator instanceof \Coordinator) {
            try {

                $sth = $this->databaseHandler->prepare("INSERT INTO COORDINATORS
                (id,role,name,event_name,contact_no)
              VALUES(:id,:role,:name,:event_name,:contact_no)");


                $sth->execute(array(

                    ':id' => $coordinator->getId(),
                    ':role' => $coordinator->getRole(),
                    ':name' => $coordinator->getName(),
                    ':event_name' => $coordinator->getEventName(),
                    ':contact_no' => $coordinator->getContactNo()

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