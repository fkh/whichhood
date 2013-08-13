<?php

include('functions.php');

$nabe = $_POST['neighborhood'];
$block = $_POST['block'];

// neighborhood names are better as title case...
// this would be better done in javascript so we can use the neighborhood names
// in the browser, e.g. to show users what they did.
$title_case_nabe = ucwords($nabe);

$clean_nabe = pg_escape_string($title_case_nabe);
$clean_block = pg_escape_string($block);

addNeighborhoodName($clean_nabe, $clean_block);

?>