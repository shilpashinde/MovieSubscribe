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
				
				</div>
            </div>
            <div class="center">
                <div>
                <h3></h3><br />
                    <form name="pubCount" method="post" action="pubCount.php">
					<input type="text" name="pubName">
					<input type="submit" value="Submit">
					</form>
				
                </div>
            </div>
            <div class="column">
                <div>
                <h3>Account Details</h3><br />
                  
					
					
					            
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