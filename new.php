<?php

include "konnect.php";

print_r($_POST);

if ($_POST['id'] > '0') { 

	$db = dbConnect();
	//$db->Connect('names');
	
	$safenabe = $db->qstr($_POST['neighborhood']);
	
	$record["block"] = $_POST['id']; 
    $record["neighborhood"] = $safenabe; 
    $record["timestamp"] = time(); 
    $insertSQL = $db->AutoExecute('names', $record, 'INSERT'); 
    
	// return $insertSQL;
}

?>