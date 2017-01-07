<?php

$serverName = "STAVAN\SQLEXPRESS";
//$serverName = "(local)";
$connectionInfo = array( "Database"=>"MovieSubscription");

/* Connect using Windows Authentication. */
$conn = sqlsrv_connect( $serverName, $connectionInfo);
if( $conn === false )
{
     echo "Unable to connect.</br>";
     die( print_r( sqlsrv_errors(), true));
}
else {
	//echo "Connection established for AW.\n";
}
?>