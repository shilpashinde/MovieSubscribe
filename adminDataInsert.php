<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>SignIn to Movie Subscription</title>
<style type="text/css">

#main{margin-left:auto; margin-right:auto; width:980px; text-align:left;}

#wrapper{float:left; background:url(images/standard.gif) top left repeat-y;}

#header{height:90px; border-bottom:#ccc solid; border-width:1px;}

#footer{height:30px; border-top:#ccc solid; border-width:1px;}

.column{width:165px; float:left;}
.center{width:650px; float: left;}
.centerAlign {width:80%; margin-left:auto; margin-right:auto; text-align:center;}

.caps{width:980px; float:left; padding:0px; background-color:#FFF;}
.column div, .center div {padding:15px}
.bold { color: deeppink; size:44px; word-spacing: 20px; font-weight:bold;}
.error{color: red; size:24px; }
.success{color: blue; size:24px; }

/*NOT IMPORTANT LAYOUT CSS*/
body {background-color:#CCCCCC; text-align:center;}
.center h3 {display:block; border-bottom:#666 solid; border-width:1px;}
h3 {margin:0px;}


</style>
</head>
<body>
    <div id="main">
        <div id="wrapper">
            <div id="header" class="centerAlign caps">
            <h3>Admin Panel</h3><br />
			<div class="centerAlign bold">
                    
			</div>
			</h3>
            </div>
            <div class="column">
                <div>
                 
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
						
						/*echo "You have selected : ";
					    echo "Title : " . $title;
						echo "Director ID: " .$director . " Publisher ID: " . $publisher;
                        echo "Category ID: " . $category;*/
						//echo "CastOne ID: " .$castOne . "CastTwo ID : " .$castTwo;
						
						$tsqlInsert = "INSERT INTO Movies.moviemaster(movietitle, categoryid, directorid, publisherid, releasedate, summary, mainlanguageid)
						VALUES('$title', $category, $director, $publisher, '$rdate', '$summary', 3)";
						
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

				

				</div>
            </div>
            <div class="center">
                <div>
                		<?php
					
						require_once ('/includes/connect.php');
	
						$directors = array();
						$categories = array();
						$publishers = array();
						$casts = array();
						
						$dno = 0;
						$catno = 0;
						$pno =0;
						$castsno = 0;
						
						
						//run query for categories:
						$tsql2 = "SELECT categoryid, categorydescription FROM Movies.category ORDER BY categorydescription";
						$para2 = array();
						$options2 = array("Scrollable" => SQLSRV_CURSOR_KEYSET);

						$getCategories = sqlsrv_query($conn, $tsql2, $para2, $options2) or trigger_error("Query : $tsql2\n<br /> SQL Error : ( sqlsrv_errors(), true)");
	
						if($getCategories === false) {
								echo "Something went wrong. </br>";
								die( print_r( sqlsrv_errors(), true));
							} else {
	      
								if(sqlsrv_num_rows($getCategories) > 0) { //Available.
		                          
								  $catno = sqlsrv_num_rows($getCategories);
								  $ct = 0;
								  
								  
								while($row = sqlsrv_fetch_array($getCategories, SQLSRV_FETCH_ASSOC)) { 
								        
										$catid = $row['categoryid'];
										$catname = $row['categorydescription'];
																			
										$categories[$ct] = (array($catid, $catname));
										$ct++;
									}
							}
						}
						
						sqlsrv_free_stmt( $getCategories);
						
												
						
						//run query for directors:
						$tsql = "SELECT directorid, firstname, lastname FROM Movies.director ORDER BY firstname";
						$para = array();
						$options = array("Scrollable" => SQLSRV_CURSOR_KEYSET);

						$getDirectors = sqlsrv_query($conn, $tsql, $para, $options) or trigger_error("Query : $tsql\n<br /> SQL Error : ( sqlsrv_errors(), true)");
	
						if($getDirectors === false) {
								echo "Something went wrong. </br>";
								die( print_r( sqlsrv_errors(), true));
							} else {
	      
								if(sqlsrv_num_rows($getDirectors) > 0) { //Available.
		                          
								  $dno = sqlsrv_num_rows($getDirectors);
								  $i = 0;
								  
								while($row = sqlsrv_fetch_array($getDirectors, SQLSRV_FETCH_ASSOC)) { 
								        
										$did = $row['directorid'];
										$fname = $row['firstname'];
										$lname = $row['lastname'];
										$dname = $fname . " " . $lname;
										//echo "id : $did" . "name : $dname";
										$directors[$i] = (array($did, $dname));
										$i++;
									}
							}
						}
						sqlsrv_free_stmt( $getDirectors);
						
						//run query for publishers:
						$tsql1 = "SELECT publisherid, fname, lname FROM Movies.publisher ORDER BY fname";
						$para1 = array();
						$options1 = array("Scrollable" => SQLSRV_CURSOR_KEYSET);

						$getPublishers = sqlsrv_query($conn, $tsql1, $para1, $options1) or trigger_error("Query : $tsql1\n<br /> SQL Error : ( sqlsrv_errors(), true)");
	
						if($getPublishers === false) {
								echo "Something went wrong. </br>";
								die( print_r( sqlsrv_errors(), true));
							} else {
	      
								if(sqlsrv_num_rows($getPublishers) > 0) { //Available.
		                          
								  $pno = sqlsrv_num_rows($getPublishers);
								  $p = 0;
								  
								while($row = sqlsrv_fetch_array($getPublishers, SQLSRV_FETCH_ASSOC)) { 
								        
										$pid = $row['publisherid'];
										$pfname = $row['fname'];
										$plname = $row['lname'];
										$pname = $pfname . " " . $plname;
										//echo "id : $did" . "name : $dname";
										$publishers[$p] = (array($pid, $pname));
										$p++;
									}
							}
						}
						sqlsrv_free_stmt( $getPublishers);

						//run query for casts:
						$tsql4 = "SELECT castid, cfname, clname FROM Movies.cast ORDER BY cfname";
						$para4 = array();
						$options4 = array("Scrollable" => SQLSRV_CURSOR_KEYSET);

						$getCasts = sqlsrv_query($conn, $tsql4, $para4, $options4) or trigger_error("Query : $tsql4\n<br /> SQL Error : ( sqlsrv_errors(), true)");
	
						if($getCasts === false) {
								echo "Something went wrong. </br>";
								die( print_r( sqlsrv_errors(), true));
							} else {
	      
								if(sqlsrv_num_rows($getCasts) > 0) { //Available.
		                          
								  $csno = sqlsrv_num_rows($getCasts);
								  $cs = 0;
								  
								  
								while($row4 = sqlsrv_fetch_array($getCasts, SQLSRV_FETCH_ASSOC)) { 
								        
										$csid = $row4['castid'];
										$csfname = $row4['cfname'];
										$cslname = $row4['clname'];
										$csname = $csfname . " " . $cslname;
										//echo "id : $did" . "name : $dname";
										$casts[$cs] = (array($csid, $csname));
										$cs++;
									}
							}
						}
							
						sqlsrv_free_stmt( $getCasts);

							
					?>
					
					
					<form name="adminInput" action="adminDataInsert.php" method="post">
					
					Movie Title: <input type="text" name="title"><br />
					
					
					Category: <select name="categories">
								
								<?php
							   
							   for($ck=0; $ck<$catno; $ck++) {
							   		echo "<option value=" .$categories[$ck][0] .  ">" .$categories[$ck][1]. "</option>";
								}
							   
							?>
							</select>
								<br />
					
					Director: <select name="directors">
					
					         <?php
							   
							   for($k=0; $k<$dno; $k++) {
							   		echo "<option value=" .$directors[$k][0] .  ">" .$directors[$k][1]. "</option>";
								}
							   
							?>
							  
							  </select>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;		  
					Publisher: <select name="publishers">
					           <?php
							   for($l=0; $l<$pno; $l++) {
					           echo "<option value= " . $publishers[$l][0] . ">" .$publishers[$l][1] . "</option>";
							   }
							   ?>
							   </select>
							   <br />
							   
					<!--Movie Cast1:<select name="castOne">-->
					            <?php
								/*for($cst=0; $cst<$csno; $cst++) {
					            echo "<option value= " . $casts[$cst][0] . ">" .$casts[$cst][1] . "</option>";
								}*/
								?>
								<!--</select>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								Movie Cast2:<select name="castTwo">-->
					            <?php
					            /*for($cst=0; $cst<$csno; $cst++) {
					            echo "<option value= " . $casts[$cst][0] . ">" .$casts[$cst][1] . "</option>";
								}*/
								?>
								<!--</select>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					Movie Cast3:<select name="castThree">-->
					            <?php
					            /*for($cst=0; $cst<$csno; $cst++) {
					            echo "<option value= " . $casts[$cst][0] . ">" .$casts[$cst][1] . "</option>";
								}*/
								?>
								<!--</select>-->
					<br /> 
					Release Date:<input type="text" name="rdate">
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					Summary:<input type="textarea" name="fsummary">
					<br />
					<input type="submit" id="submit" value="Save Data">
					</form>
				
                </div>
            </div>
            <div class="column">
                <div>
                <h3></h3><br />
                
					            
				<br />
				
                </div>
            </div>
            <div id="footer" class="caps">
            <h3>S</h3>
            </div>
        </div>
    </div>
</body>
</html>