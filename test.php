<?php
require_once'mappers/ContingentMapper.php';
require_once'models/Contingents.class.php';
$cm = new \Udaan\ContingentMapper();
$c =  $cm->getContingentObject(428);

$c->setName('1');
$c->setAcl1Email("aa");
echo $c->getAcl1Email();