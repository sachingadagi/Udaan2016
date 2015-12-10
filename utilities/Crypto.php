<?php
/**
 * Created by PhpStorm.
 * User: tuxer
 * Date: 12/2/2015
 * Time: 11:57 PM
 */

namespace Udaan;


/**
 * Class Crypto
 * Class to manage hashing using BCRYPT/Blowfish. Contains functions to generate hash and compare passwords with same.
 * @package Udaan
 *
 */

class Crypto {

    // blowfish
    private static $algo = '$2a';

    // cost parameter
    private static $cost = '$10';


    /**
     * mainly for internal use
     *
     * @return string unique salt
     */
    public static function unique_salt() {
        return substr(sha1(mt_rand()), 0, 22);
    }



    /**
     * @param $password
     * @return string hashed password
     */
    public static function hash($password) {

        return crypt($password, self::$algo .
            self::$cost .
            '$' . self::unique_salt());
    }

    /**
     * this will be used to compare a password against a hash
     * @param $hash
     * @param $password
     * @return bool
     */
    public static function check_password($hash, $password) {
        $full_salt = substr($hash, 0, 29);
        $new_hash = crypt($password, $full_salt);
        return ($hash == $new_hash);
    }
}