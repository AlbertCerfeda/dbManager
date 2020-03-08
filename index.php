<?php 
    	session_start();
    	 function drawStatusbar(/*$conn,$phase*/){
        	echo "global working";
    	};
    	
    	if (!isset($_COOKIE['phase']) || !isset($_SESSION['conn'])) {
    		setcookie('phase', 'login', time() + (86400 * 30), "/");
    		
    		echo "COOKIE['phase'] is not set. Setting...<br>";
        }
?>
<!DOCTYPE html>
<html>
<head>
	<title>dbManager</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <?php
    	@session_start();
        //Fase di login
        echo "phase: ". $_COOKIE['phase'];
        switch ($_COOKIE['phase']) {

        	case 'login':
        		echo"<h1>Login into MySQL</h1>
             	<form action='index.php' method='GET'>
                	host: <input type='text' name='host' required><br>
                	user: <input type='text' name='user' required><br>
                	password: <input type='password' name='pwd'><br>

                	<input type='submit' value='Login'>
            	</form>";
        		if (sizeof($_GET)>0){
            		$conn = @mysqli_connect($_GET['host'], $_GET['user'], $_GET['pwd']);
            		if (mysqli_connect_errno()){//Credenziali errate
                		echo"<div id='warn'>Connessione fallita: " . mysqli_connect_error()."</div>";
            		}
            		else{//Credenziali corrette
                		$_SESSION['conn']= $conn;
                		setcookie('phase','dbView');
                		echo "<script> window.location.href= './index.php' </script>";
            		}
        		}
        	break;

        	case 'dbView':
        		echo "<script type='text/javascript'> 
                    function logout(){
                        document.cookie = 'phase=login ; expires = Thu, 01 Jan 1970 00:00:00 GMT';
                        window.location.href= './index.php';
                    }
                </script>
                <br><input type='button' onClick='logout()' value='Logout'>";
                drawStatusbar();
        	break;
        }
        
        /*} else if ($_COOKIE['phase']=='dbView'){
            $_SESSION['functions']['topStatusBar']($_SESSION['conn'],$_COOKIE['phase']);
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            echo "<script type='text/javascript'> 
                    function logout(){
                        document.cookie = 'phase=login ; expires = Thu, 01 Jan 1970 00:00:00 GMT';
                        window.location.href= './index.php';
                    }
                </script>
                <br><input type='button' onClick='logout()' value='Logout'>";
        }*/
        
    ?>
</body>
</html>