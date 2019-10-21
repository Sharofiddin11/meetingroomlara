<?php
    session_start();
?>
<html>
    <head>
    	<meta charset="UTF-8">
    	<title> Войти </title>

    	<link type="text/css" rel="stylesheet" href="media/layout.css" />
		
        <link type="text/css" rel="stylesheet" href="icons/style.css" />
	    <style type = "text/css">
	        #formAut {
	        	position: absolute;
	            left: 500px;
	            top: 200px;
	        }
	        #checklogin {
	        	position: absolute;
	        }
            #TopPos {
             	position: absolute;
             	left: 10px;
             }
             #ExitP {
             	position: absolute;
             	left: 1300px;
             }

            .top-menu {
              background: rgba(255,255,255,.5);
              box-shadow: 3px 0 7px rgba(0,0,0,.3);
              padding: 20px;
            }
            .top-menu:after {
              content: "";
              display: table;
              clear: both;
            }
            .navbar-logo {display: inline-block;}
            .menu-main {
              list-style: none;
              margin: 0;
              padding: 0;
              float: right;
            }
            .menu-main li {display: inline-block;}
            .menu-main a {
              text-decoration: none;
              display: block;
              position: relative;
              line-height: 61px;
              padding-left: 20px;
              font-size: 18px;
              letter-spacing: 2px;
              font-family: 'Arimo', sans-serif;
              font-weight: bold;
              color: #F73E24;
              transition:.3s linear;
            }
            .menu-main a:before {
              content: "";
              width: 9px;
              height: 9px;
              background: #F73E24;
              position: absolute;
              left: 50%;
              transform: rotate(45deg) translateX(6.5px);
              opacity: 0;
              transition: .3s linear;
            }
            .menu-main a:hover:before {opacity: 1;}
            @media (max-width: 660px) {
            .menu-main {
              float: none;
              padding-top: 20px;
            }
            .top-menu {
              text-align: center;
              padding: 20px 0 0 0;
            }
            .menu-main a {padding: 0 10px;}
            .menu-main a:before {transform: rotate(45deg) translateX(-6px);}
            }
            @media (max-width: 600px) {
            .menu-main li {display: block;}
            }
            #DocumentEndLine {
              position: absolute;
              text-align: center;
              width: 100%;
              height: 10%;
              top: 200%;
            }
	    </style>
		<style type="text/css">
            body, input, button, select {
                font-size: 14px;
            }
            
            select {
                padding: 5px;
            }
            
            .toolbar {
                margin: 10px 0px;
            }
            
            .toolbar button {
                padding: 5px 15px;
            }
            
            .icon {
                font-size: 14px;
                text-align: center;
                line-height: 14px;
                vertical-align: middle;

                cursor: pointer;
            }
            
            .toolbar-separator {
                width: 1px;
                height: 28px;
                /*content: '&nbsp;';*/
                display: inline-block;
                box-sizing: border-box;
                background-color: #ccc;
                margin-bottom: -8px;
                margin-left: 15px;
                margin-right: 15px;
            }

			.scheduler_default_corner div:nth-of-type(4) {
				display: none !important;
			}
            .scheduler_default_rowheader_inner
            {
                border-right: 1px solid #ccc;
            }
            .scheduler_default_rowheadercol2
            {
                background: White;
            }
            .scheduler_default_rowheadercol2 .scheduler_default_rowheader_inner
            {
                top: 2px;
                bottom: 2px;
                left: 2px;
                background-color: transparent;
                border-left: 5px solid #38761d; /* green */
                border-right: 0px none;
            }
            .status_dirty.scheduler_default_rowheadercol2 .scheduler_default_rowheader_inner
            {
                border-left: 5px solid #cc0000; /* red */
            }
            .status_cleanup.scheduler_default_rowheadercol2 .scheduler_default_rowheader_inner
            {
                border-left: 5px solid #e69138; /* orange */
            }

        </style>
    </head>
    <body>
       <div id="header">
                <div class="bg-help">
                    <div class="inBox">
                        <h1 id="logo">Проект бронирования митинг рум (JavaScript/PHP)</h1>
                       
                        <hr class="hidden" />
                    </div>
                </div>
            </div>
    	<div id = "formAut">
	    	<form method = "get" name = "EnterForm">
	    		<center>
	    		<input id = "LE" style = "border-radius: 20px; width: 300px; height: 50px; font-size: 30px;" type = "text" name = "LoginE" placeholder = "Логин" required>
	    	    </br>
	    	    <input id = "PE" style = "border-radius: 20px; width: 300px; height: 50px; font-size: 30px;" type = "password" name = "PasswordE" placeholder="Пароль" required>
	    	    </br>
	    	    </br>
	    	    <input style = "border-radius: 20px; width: 150px; height: 50px; font-size: 30px;" type = "submit" name = "ES" value = "Войти">
	    	</form>
	        </br>
	        <div id = "checklogin">
		    	<?php
		             if(!empty($_GET["ES"])) {
		             	$ln = $_GET["LoginE"];
		             	$pd = $_GET["PasswordE"];
						$found = -1;
		             	if($ln == 'admin' && $pd == '123') $found = 1;
		                if($found == -1) {
		                	echo "<html><head><style> p {font-size: 20px;} </style></head> <body> <p> <font color = 'red'>Неправилно введён логин или пороль! </p> </body></html>";
		                } else {
		                
		                	echo '<html> <head> <meta http-equiv="Refresh" content="0; URL=login_admin.php"> </head> <body> </body> </html>';
		                }
		             }
			    ?>
    	    </div>
        </div>
    </body>
</html>
