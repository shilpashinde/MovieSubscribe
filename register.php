<?php #Script 1.0 - register.php
// This is the registration page for the site.


//$page_title = 'Register';

//error_reporting(E_ALL);



if (isset($_POST['submitted']) && (!empty($_POST))) { // Handle the form.
    
	// Trim all the incoming data:	
	$trimmed = array_map('trim', $_POST);
	
	$useremail = $trimmed['email'];
	$userfname = $trimmed['fname'];
	$userlname = $trimmed['lname'];
	$userpwd = $trimmed['password1'];
	
	if($useremail != "" && $userfname != "" && $userpwd != "") {
	
	require_once ('/includes/connect.php');
	
	
	//Make sure the email address is available:
	$tsql = "SELECT userid FROM Users.usermaster WHERE email = '$useremail'";
	$para = array();
	$options = array("Scrollable" => SQLSRV_CURSOR_KEYSET);
	
	
	$getUsers = sqlsrv_query($conn, $tsql, $para, $options) or trigger_error("Query : $tsql\n<br /> SQL Error : ( sqlsrv_errors(), true)");
	
	/*if($getUsers === false) {
	      echo "Something went wrong. </br>";
     die( print_r( sqlsrv_errors(), true));
	} */
	
	echo(sqlsrv_num_rows($getUsers));
	
	if(sqlsrv_num_rows($getUsers) == 0) { //Available.
	   
		
		 $insertUserSQL = "INSERT INTO Users.usermaster(email, trail_start_date, 
		               password, userfname, userlname) VALUES (?, GETUTCDATE(), ?, ?, ?)";
		 
		 $params = array($useremail, $userpwd, $userfname, $userlname); 
		 
		 $insertUserStmt = sqlsrv_query($conn, $insertUserSQL, $params);
			
			if(!$insertUserStmt) {
					die(print_r(sqlsrv_errors(), true));
				} else {
				
				echo '<p class="success"> Thank you for registering to Movie Subscription.\n </p>';
				
				}
		
		/*if(sqlsrv_execute($insertUserStmt) === true) {
			echo "Thank you registering at Movie Subscription.";
		
			exit();  //stop the page.
		} else {
		    print_r(sqlsrv_errors(), true);
			echo "Something went wrong. Your registration cannot complete at this time.";
		
			}*/
		
		
	} else {
	 
	    echo '<p class="error"> This email address is already registered. Please use Sign-in button to browse. </p>';
	
	}
	
	} else {
	 
	   echo '<p class="error"> Username, email and password are required fields. Please enter correct values. </p>';
	
	}

		
} // End of the main Submit conditional.
?>

<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Register to Sonal's Movie Subscription Site</title>
<style type="text/css">

#main{margin-left:auto; margin-right:auto; width:980px; text-align:left;}

#wrapper{float:left; background:url(images/standard.gif) top left repeat-y;}

#header{height:90px; border-bottom:#ccc solid; border-width:1px;}

#footer{height:30px; border-top:#ccc solid; border-width:1px;}

.column{width:165px; float:left;}
.center{width:650px; float:left;}

.caps{width:980px; float:left; padding:0px; background-color:#FFF;}
.column div, .center div {padding:15px}

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
            <div id="header" class="caps">
            <h3>&nbsp;&nbsp;&nbsp; &nbsp; &nbsp; Welcome to Team 2 NpuMovieSubScription System!</h3>
            </div>
            <div class="column">
                <div>
                <h3>Enjoy</h3><br />
                  We hope you'll enjoy every moment here!
                </div>
            </div>
            <div class="center">
                <div>
                <h3>USE THIS FORM TO REGISTER HERE!</h3><br />
                    
					<div id="formDisplay">	
					<form action="register.php" method="post">
	<fieldset>
	<p><b>First Name:</b> <input type="text" name="fname" size="20" maxlength="20" value="<?php if (isset($trimmed['fname'])) echo $trimmed['fname']; ?>" /></p>
	
	<p><b>Last Name:</b> <input type="text" name="lname" size="20" maxlength="40" value="<?php if (isset($trimmed['lname'])) echo $trimmed['lname']; ?>" /></p>
	
	<p><b>Email Address:</b> <input type="text" name="email" size="30" maxlength="80" value="<?php if (isset($trimmed['email'])) echo $trimmed['email']; ?>" /> </p>
		
	<p><b>Password:</b> <input type="password" name="password1" size="20" maxlength="20" /> <small>Use only letters, numbers, and the underscore. Must be between 4 and 20 characters long.</small></p>
	
	<!--<p><b>Confirm Password:</b> <input type="password" name="password2" size="20" maxlength="20" /></p>-->
	</fieldset>
		
	<div align="center"><input type="submit" name="submit" value="Register" /></div>
	<input type="hidden" name="submitted" value="TRUE" />

</form>
					
					
					</div>
					
                </div>
            </div>
            <div class="column">
                <div>
                <h3> Register user sign-in</h3><br />
                    <h3> </h3><br />
					<?php 
						include("signin.html");
						?>
                </div>
            </div>
            <div id="footer" class="caps">
            <h3>&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; By Sonal </h3>
            </div>
        </div>
    </div>
</body>
</html>




<?php 
//Add link for forgot password:

//echo '<a href="forgot_password.php">Forgot Password?Click here.</a>';


?>
