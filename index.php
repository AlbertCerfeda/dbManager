<?php 
    	session_start();
    	 function drawStatusbar(/*$conn,$phase*/){
        	
    	};
    	echo '<script> function setCookie(cname, cvalue, exdays) {
			var d = new Date();
			d.setTime(d.getTime() + (exdays*24*60*60*1000));
			var expires = "expires="+ d.toUTCString();
			document.cookie = cname + "=" + cvalue + ";" + expires;
		  } 
		  function logout(){
			setCookie("phase","login",0);
			window.location.href= "./index.php";
			} </script>';

		//TODO: Fix this fucking issue
    	if (!isset($_COOKIE['phase']) || !isset($_SESSION['conn'])) {
    		echo "<script> setCookie('phase','login',2); </script>";
    		
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
        echo "phase: ". $_COOKIE['phase']."<br><br>";
        switch ($_COOKIE['phase']) {

        	case 'login':
        		echo"<h1>Login into MySQL</h1>
				 <form action='index.php' method='GET'>
					<table>
					 	<tr> <td>host:</td> <td><input type='text' name='host' required></td> </tr>
					 	<tr> <td>user:</td> <td><input type='text' name='user' required></td> </tr>
						<tr> <td>password:</td> <td><input type='password' name='pwd'></td> </tr>
						<tr> <td><input type='submit' value='Login'></td> </tr>
					</table>
            	</form>";
        		if (sizeof($_GET)>0){
            		$conn = @mysqli_connect($_GET['host'], $_GET['user'], $_GET['pwd']);
            		if (mysqli_connect_errno()){//Credenziali errate
                		echo"<div id='warn'>Connessione fallita: " . mysqli_connect_error()."</div>";
            		}
            		else{//Credenziali corrette
						$_SESSION['conn']= $conn;
						$_SESSION['host']= $_GET['host'];
						$_SESSION['user']= $_GET['user'];
						$_SESSION['pwd']= $_GET['pwd'];
						
                		setcookie('phase','dbView');
                		echo "<script> window.location.href= './index.php' </script>";
            		}
        		}
			break;
			
			case 'dbView':
				$conn = @mysqli_connect($_SESSION['host'], $_SESSION['user'], $_SESSION['pwd']);
				if (mysqli_connect_errno()){//Credenziali errate
					echo"<script> logout(); </script>";
				}
				else{//Credenziali corrette
					$result = mysqli_query($conn, "SHOW DATABASES");
					if(@mysqli_num_rows($result)!=0){
						echo "<script> function tableView(tableName){
							setCookie('phase','tableView',2);
							window.location.href= './index.php?table=' + tableName;
						} </script>";
						while($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
							echo "<input type='button' onClick='tableView(this.value)' value='".$row[0]."'><br>";
						}
					}
				}

        		echo "<br><input type='button' onClick='logout()' value='Logout'>";
			break;
			
			case 'tableView':
				echo "<br><input type='button' onClick='logout()' value='Logout'>";
			break;
        }
        
    ?>
</body>
</html>