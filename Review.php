<?php
	/* Created on : 3/26/2014
	/* Created By : shilpa shinde
	/* This script collect review and comments about a movie from a user, and insert them into database. */
	
	
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
               
		
<?php

require_once ('/includes/connect.php');


//begin validation movie id:
					$mid = FALSE;
					if(isset($_GET['mid']) && filter_var($_GET['mid'], FILTER_VALIDATE_INT, array('min_range' => 1)) ) {
							$mid = $_GET['mid'];
							//echo $mid;
							}
			?>		
				 
<form  action="Review.php" method="post">';
<label for="rating">Rating*</label><br/>
<Input type = "Radio" Name ="rating" value= "1" >1
<Input type = "Radio" Name ="rating" value= "2" >2
<Input type = "Radio" Name ="rating" value= "3" >3
<Input type = "Radio" Name ="rating" value= "4" >4
<Input type = "Radio" Name ="rating" value= "5" >5<br/>
  <label for="comment" >Comment </label><br/>
  <textarea name = "comm" rows="4" cols="50"></textarea><br/>
  <input type="hidden" name="mid" id="mid" value=<?php echo $mid; ?>> 
<input type="submit" name="Submit" value="Submit" />

</form>
		<?php		
                if($_SERVER['REQUEST_METHOD'] == 'POST') {				
				$userid = $_SESSION['user_id'];
				$rating= @$_POST['rating'];
				$mid = $_POST['mid'];
				
				if($_POST['comm'] === null) {
						$comment = "";
				}
				
				$comment= @$_POST['comm'];
				
                  echo 'userid : ' .$userid . 'mid : ' . $mid . 'rating : ' .$rating . '$comm :' . $comment;
				  
				$query = "INSERT INTO Movies.MovieRating(userid, movieid, rating, comments) 
							VALUES ($userid, $mid ,$rating,'$comment')";
				$st = sqlsrv_query( $conn, $query);

					if(!$st) {
								die(print_r(sqlsrv_errors(), true));
								} else {
									echo '<p class="success"> Successfully added your comments/ratings. Thank you.\n </p>';
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