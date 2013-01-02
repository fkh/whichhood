<?php

include('functions.php');

$nabe = $_POST['neighborhood'];

$clean = mysql_real_escape_string($nabe);

addNeighborhoodName($clean);

?>