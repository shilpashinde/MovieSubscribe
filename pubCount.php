<?php

			if($_SERVER['REQUEST_METHOD'] == 'POST' && (!empty($_POST))) {
						
						// Trim all the incoming data:	
						$trimmed = array_map('trim', $_POST);
						$pname = $trimmed['pubName'];
						//echo $pname;
						$totalMovies = 0;
						
						$result = array();
						$pid = 0;
						$pubid = 0;
						
						require_once("/includes/connect.php");
						
						$sql = "{call USP_PubCompanyCount( ?, ?, ? )}";
						$params = array(array($pname, SQLSRV_PARAM_IN),
						                array($totalMovies, SQLSRV_PARAM_OUT),
										array($pid, SQLSRV_PARAM_OUT));
										
						$stmt = sqlsrv_query($conn, $sql, $params);
						
						if($stmt) {
						   echo "Total Movies FROM $pname  : $totalMovies";
						   //echo "  PID : $pid";
						   $pubid = $pid;
						   $movieTitle = 'abcdefghijklmnopqrstuv';
						   
						   
						$tsql = "SELECT movieid, movietitle FROM Movies.moviemaster where publisherid = '$pid'";
						$para = array();
						$options = array("Scrollable" => SQLSRV_CURSOR_KEYSET);
	
					$getTitles = sqlsrv_query($conn, $tsql, $para, $options) or trigger_error("Query : $tsql\n<br /> SQL Error : ( sqlsrv_errors(), true)");
	
					if($getTitles == false) {
								  echo "Something went wrong. </br>";
								  die( print_r( sqlsrv_errors(), true));
							} else {
								  
								  if(sqlsrv_num_rows($getTitles) > 0) { //Available.
								  echo sqlsrv_num_rows($getTitles);
								   while($row = sqlsrv_fetch_array($getTitles, SQLSRV_FETCH_ASSOC)) { 
										$mid = $row['movieid'];
										$names = $row['movietitle'];
										$names = ucwords($names);
										echo '<li>' . $names . '</li><br/>';
																			
										}
								}
						   }
						   
						   
						   
						   
						  /* do {
								while ($obj = sqlsrv_fetch_object($stmt)) {     
                                    //echo "m";						   
									//echo $obj->$movieTitle;  
									$result = $obj;
									}
							}while(sqlsrv_next_result($stmt));  
                         print_r($result);*/
						 
						 /*$movieSql = "{CALL USP_PubCompanyMovies(?, ?)}";
						 $movieParams = array(array($pubid, SQLSRV_PARAM_IN),
						                      array($movieTitle, SQLSRV_PARAM_OUT));
						 $movieStmt = sqlsrv_query($conn, $movieSql, $movieParams);
						 //$movieStmt = sqlsrv_prepare($conn, $movieSql, $params);
						 $query = sqlsrv_execute($movieStmt);
						 
						 while($obj = sqlsrv_fetch_array($movieStmt, SQLSRV_FETCH_ASSOC)) {
							$result[] = $obj;
						 }
						 
						 print_r($result);*/
						 
						 /*if($movieStmt) {
						 echo "in moviestmt";
						 $obj = sqlsrv_fetch_array($movieStmt);
						 echo $obj;
						 
						   while($obj = sqlsrv_fetch_array($movieStmt, SQLSRV_FETCH_ASSOC)) {
						      echo $obj['movieTitle'];
						   }
						 } else {
							echo "false movietitles";
						  die(print_r(sqlsrv_errors(), true));
						 }*/
						 
						 
						   
						} else {
						  echo "false";
						  die(print_r(sqlsrv_errors(), true));
						}
						
						
						
						}
						?>