<?php
	/* Created on : 3/24/2014
	/* Created By : Sonal Macwan
	/* This script fetches movie details and displays them. */
	
	
	session_start();
	
	//show this page only if the user is logged in:
	if(!isset($_SESSION['user_id'])) {
		header("Location: index.php");
		exit();
		}
?>


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
            <h3>Movie Categories</h3><br />
			<div class="centerAlign bold">
                    <?php
					    include("categories.php");
						?>
			</div>
			</h3>
            </div>
            <div class="column">
                <div>
                 </div>
				 </div>
		<div class="center">
                <div>
                <h3></h3><br />

	<?php
	
	//begin validation movie id:
	$mid = FALSE;
	if(isset($_GET['mid']) && filter_var($_GET['mid'], FILTER_VALIDATE_INT, array('min_range' => 1)) ) {
	   $mid = $_GET['mid'];
	}
	
	
	require_once ('/includes/connect.php');
	
	
	//run query against received category movieid:
	$tsql = "SELECT mm.movieid, mm.movietitle, mm.summary
			,md.firstname + ' ' + md.lastname  As DirectorFullName
			,mp.fname+ ' ' + mp.lname As Publisher
			FROM Movies.moviemaster mm
			
			INNER JOIN Movies.director md
			on md.directorid=mm.directorid
			INNER JOIN Movies.publisher mp  on mp.publisherid=mm.publisherid WHERE movieid = '$mid'";
	
	
	//$tsql = "SELECT movietitle, summary FROM Movies.moviemaster where movieid = '$mid'";
	$para = array();
	$options = array("Scrollable" => SQLSRV_CURSOR_KEYSET);
	
	
	$getTitles = sqlsrv_query($conn, $tsql, $para, $options) or print_r(sqlsrv_errors(), true);
	//trigger_error("Query : $tsql\n<br /> SQL Error : "(  echo sqlsrv_errors(), true));
	
	if($getTitles === false) {
	      echo "Something went wrong. </br>";
		  die( print_r( sqlsrv_errors(), true));
	} else {
	      
		  if(sqlsrv_num_rows($getTitles) > 0) { //Available.
		
		   while($row = sqlsrv_fetch_array($getTitles, SQLSRV_FETCH_ASSOC)) { 
		        $mid = $row['movieid'];
		   		$names = $row['movietitle'];
				$msummary = $row['summary'];
				$names = ucwords($names);
				$dirc = $row['DirectorFullName'];
				$pubs = $row['Publisher'];
				echo '<p class="bold"><a href="watchMovie.php?mid=' . $mid .'"> Watch ' . $names . '</a></p>';
				//echo '<p class="bold">' . $names . '</p>';
				echo '<p> Director : ' . ucwords($dirc) . '&nbsp;&nbsp;&nbsp;&nbsp; Publisher :' . ucwords($pubs) . '</p>';
				echo '<p>'. $msummary. '</p>';
				//echo str_repeat('&nbsp;', 5);
				
				
				}
		}
	}

?>

</div>
            </div>
            <div class="column">
                <div>
                <h3>Account Details</h3><br />
                 Welcome 
					
					<?php 
						echo "<p class='bold'> {$_SESSION['fname']} </p>";
					?>
					            
				<br />
				<a href="logout.php">LOG OUT</a>
                </div>
            </div>
            <div id="footer" class="caps">
            <h3>S</h3>
            </div>
        </div>
    </div>
</body>
</html>