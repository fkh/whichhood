<?php

include('functions.php');

$nabe = $_POST['neighborhood'];
$block = $_POST['block'];

$clean_nabe = mysql_real_escape_string($nabe);
$clean_block = mysql_real_escape_string($block);


addNeighborhoodName($clean_nabe, $clean_block);

?>