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

}