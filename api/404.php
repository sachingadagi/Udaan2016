<?php
/**
 * Created by PhpStorm.
 * User: tuxer
 * Date: 12/5/2015
 * Time: 12:37 PM
 */

echo "<h1> Error 404 </h1>";
if (!array_key_exists('HTTP_MOD_REWRITE', $_SERVER))
    echo "It seems that mod rewrite is not present ot not enabled";
