<?php
	/* Created on : 3/17/2014
	/* Created By : Shilpa Shinde
	/* This script fetches movie categories and displays them. */
	
	
	if(!isset($_SESSION['user_id'])) {
		header("Location: MovieSubscribe/index.php");
		exit();
		}

		require_once ('/includes/connect.php');
	
	
	//Make sure the email address is available:
	$tsql = "SELECT categoryid, categorydescription FROM Movies.category ORDER BY categorydescription ASC";
	$para = array();
	$options = array("Scrollable" => SQLSRV_CURSOR_KEYSET);
	
	
	$getCategories = sqlsrv_query($conn, $tsql, $para, $options) or trigger_error("Query : $tsql\n<br /> SQL Error : ( sqlsrv_errors(), true)");
	
	if($getCategories === false) {
	      echo "Something went wrong. </br>";
		  die( print_r( sqlsrv_errors(), true));
	} else {
	      
		  if(sqlsrv_num_rows($getCategories) >= 1) { //Available.
		
		   while($row = sqlsrv_fetch_array($getCategories, SQLSRV_FETCH_ASSOC)) { 
		   		$categories = $row['categorydescription'];
				$categories = ucwords($categories);
				//echo nl2br("$categories\n");
								
				echo '<a href="catmovies.php?cid=' . $row['categoryid'] .'">' . $categories . '</a>';
				echo str_repeat('&nbsp;', 3);
				}
		}
	}

?>