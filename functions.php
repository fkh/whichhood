<?php

getNeighborhoods();

function carto($query, $geojson) {
  
  // run any cartodb query
  
  $api_key = '74921862200323be9009bcf748adfdee8f5e0a57';
  $carto_root = 'http://fkh.cartodb.com/api/v2/sql?';
  
  if ($geojson == TRUE) {
    $format = "format=GeoJSON&";
  }
  
  $sql_query = urlencode($query);

  $carto_url = $carto_root . $format . "q=" . $sql_query . "&api_key=" . $api_key ;

  // doing the curl...
  $ch = curl_init();
  
  curl_setopt($ch, CURLOPT_URL, $carto_url);
  curl_setopt($ch, CURLOPT_HEADER, FALSE);
  curl_setopt($ch, CURLOPT_VERBOSE, FALSE);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
  
  //print $carto_url;
  
  $carto_result = curl_exec($ch);
  
  // close cURL resource, and free up system resources
  curl_close($ch);

  return $carto_result;
  
}

// get the random point to seed the map, called by point.php
function getRandomPoint() {
  
  //prevent query caching by fetching a random point
  $cartodbid = rand(1,8408);
  $get_random_point = "SELECT * FROM bkblocks WHERE cartodb_id = {$cartodbid} limit 1";
  $result = carto($get_random_point, TRUE);
	return $result;
	
}

// get a bounded point
function getRandomBoundedPoint() {
  
  $get_random_point = "SELECT * FROM bkblocks WHERE ";
 // $get_random_point .= "bkblocks.the_geom && ST_MakeEnvelope(" . 10.9351, 49.3866, 11.201, 49.5138, 4326);cartodb_id = " . $cartodbid . " limit 1";
  $result = carto($get_random_point, TRUE);
	return $result;
	
}


// construct a url to insert a point into the db

function addNeighborhoodName($name, $block) {

  $timestamp = time();
  
  $sql = "INSERT INTO NAMES (neighborhood, block, timestamp) VALUES ('{$name}', '{$block}', {$timestamp})";
  
  carto($sql, FALSE);
  
}


function countNames() {

	$db = dbConnect();
	
	$rs = $db->Execute('select count(*) as "count" from names;'); 
	
	while ($row = $rs->FetchNextObject()) {
		$count = $row->COUNT;
	}	
	
	$totalCount = array(names => $count);

	return $totalCount;
}

//returns a list of neighborhood names, where more than one marker has been named.
function getNeighborhoods() { 	

	$sql = 'select count(*) as "Number", names.neighborhood from names group by names.neighborhood having count(*) > 1 order by names.neighborhood ASC';

	$names = carto($sql, FALSE);

	return $names;
  
	//SELECT bkblocks.the_geom_webmercator, names.neighborhood FROM bkblocks, names where bkblocks.ID = names.block and names.neighborhood like '%Park Slope%' 
	
}


function getMarkers($focus) {
	//return all the markers for a particular place name;

			
	$db = dbConnect();

	
	$sql = "SELECT * FROM \"blocks\", \"names\" where \"blocks\".\"ID\" = \"names\".\"block\" and \"names\".\"neighborhood\" = '\\'" . $focus . "\\'';";
	
	$rs = $db->Execute($sql);
	
	$markers = array();
	
	while ($row = $rs->FetchNextObject()) {
			
		$location = array("x" => $row->X, "y" => $row->Y);
		array_push($markers, $location);
		
	}

	return $markers;
}


function stats(){
	//count total number of nabes and total blocks...
	
	
}



?>
