<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Team 2 Movie Subscription Database Application</title>
<style type="text/css">

#main{margin-left:auto; margin-right:auto; width:980px; text-align:left;}

#wrapper{float:left; background:url(images/standard.gif) top left repeat-y;}

#header{height:90px; border-bottom:#ccc solid; border-width:1px;}

#footer{height:30px; border-top:#ccc solid; border-width:1px;}

.column{width:165px; float:left;}
.center{width:650px; float:left;}

.caps{width:980px; float:left; padding:0px; background-color:#FFF;}
.column div, .center div {padding:15px}

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
                <h3>USER REGISTRATION</h3><br />
                    <a href="register.php">Click here to start your <H2> FREE first-month trial! </h2> </a>
					<? 
					   include("register.php");
					   ?>
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
