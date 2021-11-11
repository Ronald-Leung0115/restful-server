<?php
$server = "localhost";
$dbuser = "root";
$dbpassword = "";
$dbname = "bbq";

// connect database
$conn = new mysqli($server, $dbuser, $dbpassword, $dbname);
if ($conn->connect_error) {
	die ("database connection failed");
}
$sql = "DROP TABLE IF EXISTS bbq";
if (!$result=$conn->query($sql)){
	die('failed to drop table');
}
// create table
$sql = "CREATE TABLE bbq (district_en TEXT, district_cn TEXT, name_en TEXT, name_cn TEXT, address_en TEXT, address_cn TEXT, gihs TEXT, facilities_en TEXT, facilities_b5 TEXT, opening_hours_en TEXT, opening_hours_cn TEXT, phone TEXT, remarks_en TEXT, remarks_cn TEXT, longitude TEXT, latitude TEXT)";

if (!$result=$conn->query($sql)) {
	die ("failed to create table");
}

// process JSON
$decodedJson = file_get_contents('https://api.data.gov.hk/v1/historical-archive/get-file?url=http%3A%2F%2Fwww.lcsd.gov.hk%2Fdatagovhk%2Ffacility%2Ffacility-bbqs.json&time=20211107-0922');
$bbqs = json_decode($decodedJson, true);
foreach ($bbqs as $bbq) {
	$district_en = $bbq['District_en'];
	$district_cn = $bbq['District_cn'];
	$name_en = $bbq['Name_en'];
	$name_cn = $bbq['Name_cn'];
	$address_en = $bbq['Address_en'];
	$address_cn = $bbq['Address_cn'];
	$gihs = $bbq['GIHS'];
	$facilities_en = $bbq['Facilities_en'];
	$facilities_b5 = $bbq['Facilities_b5'];	
	$ancillary_facilities_en = $bbq['Ancillary_facilities_en'];
	$ancillary_facilities_cn = $bbq['Ancillary_facilities_cn'];
	$opening_hours_en = $bbq['Opening_hours_en'];
	$opening_hours_cn = $bbq['Opening_hour s_cn'];
	$phone = $bbq['Phone'];
	$remarks_en = $bbq['Remarks_en'];
	$remarks_cn = $bbq['Remarks_cn'];
	$longitude = $bbq['Longitude'];
	$latitude = $bbq['Latitude'];
	$name_en = str_replace("'", "", $name_en);
	$sql = "INSERT INTO bbq VALUES ('$district_en', '$district_cn', '$name_en', '$name_cn', '$address_en', '$address_cn', '$gihs', '$facilities_en', '$facilities_b5', '$opening_hours_en', '$opening_hours_cn', '$phone', '$remarks_en', '$remarks_cn', '$longitude', '$latitude')";
	if (!$result=$conn->query($sql)) {
		die ("insertion failed");
	}
	
}