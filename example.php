<?php
				    if($_SERVER['REQUEST_METHOD'] == 'POST' && (!empty($_POST))) {
						
						// Trim all the incoming data:	
						$trimmed = array_map('trim', $_POST);
						$title = $trimmed['title'];
						$director = $trimmed['directors'];
						$publisher = $trimmed['publishers'];
						$category = $trimmed['categories'];
						//$castOne = $trimmed['castOne'];
						//$castTwo = $trimmed['castTwo'];
						$rdate = $trimmed['rdate'];
						$summary = $trimmed['fsummary'];
												
						require_once ('/includes/connect.php');
						
						$tsql = "SELECT movietitle FROM Movies.moviemaster where movietitle = '$title'";
						$para = array();
						$options = array("Scrollable" => SQLSRV_CURSOR_KEYSET);
	
						$getTitles = sqlsrv_query($conn, $tsql, $para, $options) or trigger_error("Query : $tsql\n<br /> SQL Error : ( sqlsrv_errors(), true)");
						
						if($getTitles === false) {
								echo "Something went wrong. </br>";
								die( print_r( sqlsrv_errors(), true));
							} else {
	      							if(sqlsrv_num_rows($getTitles) == 1) { //Available.
									echo "<p class='error'> $title is already present in the Database. Please enter another Movie title. </p>";
									}
								}
								
						if(sqlsrv_num_rows($getTitles) === 0) {			
						
						echo "You have selected : ";
					    echo "Title : " . $title;
						echo "Director ID: " .$director . " Publisher ID: " . $publisher;
                        echo "Category ID: " . $category;
						//echo "CastOne ID: " .$castOne . "CastTwo ID : " .$castTwo;
						
						$tsqlInsert = "INSERT INTO Movies.moviemaster(movietitle, categoryid, directorid, publisherid, releasedate, summary, mainlanguageid)
						VALUES('$title', $category, $director, $publisher, $rdate, $summary, 3)";
						
						 $insertTitleStmt = sqlsrv_query($conn, $tsqlInsert);
			
						if(!$insertTitleStmt) {
							die(print_r(sqlsrv_errors(), true));
							} else {
				                echo $title;
								echo '<p class="success"> Successfully added to the Database.\n </p>';
				
									}
						}
				 }
				 ?>
