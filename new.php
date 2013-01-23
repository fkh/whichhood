<?php

include('functions.php');

$nabe = $_POST['neighborhood'];
$block = $_POST['block'];

$clean_nabe = pg_escape_string($nabe);
$clean_block = pg_escape_string($block);

addNeighborhoodName($clean_nabe, $clean_block);

?>