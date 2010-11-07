<?php
include('db/adodb.inc.php');

function dbConnect() {


$server = '127.0.0.1';
$database = "";


//user details
$dbuser = '';
$dbpass = '';
$driver = 'postgres8';

$db = ADONewConnection($driver); # eg. 'mysql' or 'oci8' 
$db->debug = false;
$db->Connect($server, $dbuser, $dbpass, $database);

return $db;

}
?>