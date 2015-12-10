<?php
/**
 * Created by PhpStorm.
 * User: tuxer
 * Date: 12/2/2015
 * Time: 11:09 PM
 *
 * About :
 *      A Configuration class that will store all the constants related to the project
 */

namespace Udaan;


final class Config {


    public static  $CONTINGENT_ACCOUNT_CREATED = 1000;

    public static function getBaseURL()
    {
        $root = realpath($_SERVER["DOCUMENT_ROOT"]);
        $root = $root."/Udaan2016/fms/";
        return str_replace('\\','/',$root) ;
    }

    public static function getLogoDirectory()
    {
        $root = realpath($_SERVER["DOCUMENT_ROOT"]);
        return str_replace('\\','/',"$root/Udaan2016/fms/eventlogos/");
    }

}