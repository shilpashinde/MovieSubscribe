<?php

/*
 * new login script.
 * This page processes the login form submission.
 * Created By : Shilpa shinde
 * Date : 3/3/2014
 */


require_once ('/includes/connect.php');
		$page_title = 'Login';

function check_login($conn, $email = '', $pass = '') {
    
	
	
    $errors = array();
    if(empty($email)) {
        $errors[] = 'You forgot to enter your email address.';
    } else {
        $e = trim($email);
		
    }
    
    if(empty($pass)) {
        $errors[] = 'You forgot to enter your password.';
    } else {
        $p = trim($pass);
		
    }
    
    if(empty($errors)) {
        
		require_once ('/includes/connect.php');
				       
		$q = "SELECT userid, userfname, userlname FROM Users.usermaster WHERE (email= '$e' AND password = '$p' )"; // AND active IS NULL";	
       	
		$para = array();
		$options = array("Scrollable" => SQLSRV_CURSOR_KEYSET);
		
		$getUserData = sqlsrv_query($conn, $q, $para, $options);  
		
		if($getUserData === false) {
		    die(print_r(sqlsrv_errors(), true));
			echo "Something went wrong. ";
		} else {
		        
		
		
        if(sqlsrv_num_rows($getUserData) == 1) { //Available.
		
		   $row = sqlsrv_fetch_array($getUserData, SQLSRV_FETCH_ASSOC); 
            
			$user_id = $row['userid'];
            $fname = $row['userfname'];
            $lname = $row['userlname'];
			
			
			
            $rslt = array('user_id'=>$user_id, 'fname'=>$fname, 'lname'=>$lname);
            
            
            return array(true, $rslt);
            sqlsrv_free_stmt($q);
        
		} else {
            $errors[] = 'The email address and password do not match those on file.';
			echo 'This email address is not registered here.';
        }
		
		}
    }   //End of empty($errors)
      
	
    //return false and errors:
    return array(false, $errors);

       sqlsrv_close($conn);
}  //end of check_login function.



if($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    require_once ('/includes/connect.php');
	
  //check the login:
    list($check, $data) = check_login($conn, $_POST['email'], $_POST['pass']);
 
   
    if($check) {
        
		session_start();
        //set the session data:
        $_SESSION['user_id'] = $data['user_id'];
        //echo $_SESSION['user_id'];
        $_SESSION['fname'] = $data['fname'];
        //echo $_SESSION['fname'];
        $_SESSION['lname'] = $data['lname'];
        //echo $_SESSION['lname'];
         
        
							
			//$url = BASE_URL . '/index.php'; // Define the URL:
			//ob_end_clean(); // Delete the buffer.
			header('Location: /MovieSubscribe/loggedin.php');
			exit(); // Quit the script.
    }  else {
        $errors = $data;
		
    }
    
    
    
}  //End of main submti conditional.
//include('../includes/login_page.inc.php');

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
            <h3>Sign-In</h3>
            </div>
            <div class="column">
                <div>
                <h3>Left Column</h3><br />
                Lorem ipsum ad per iriure eripuit sensibus, quo ei propriae constituto, nec impedit veritus cu. Omnis aeque petentium eum eu. Esse error splendide in vel, natum graece iriure an his. Veniam pertinax referrentur ea eum, mea propriae salutatus temporibus ne. Mel nostrum scribentur deterruisset id, nostrud facilisi volutpat sea in, ei usu eros partiendo intellegat.
                </div>
            </div>
            <div class="center">
                <div>
                <h3></h3><br />
                    
                </div>
            </div>
            <div class="column">
                <div>
                <h3>Sign In</h3><br />
                <a href="signin.html">Log in </a>
                </div>
            </div>
            <div id="footer" class="caps">
            <h3>Footer</h3>
            </div>
        </div>
    </div>
</body>
</html>
