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
	<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"> </script>
<!-- Popper JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"> </script>
<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"> </script>
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
						echo "<script> function dbView(dbName){
							setCookie('phase','tableView',2);
							window.location.href= './index.php?db=' + dbName;
						} </script>";
						while($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
							echo "<input type='button' onClick='dbView(this.value)' value='".$row[0]."'><br>";
						}
					}
				}

        		echo "<br><input type='button' onClick='logout()' value='Logout'>";
			break;
			
			case 'tableView':
				$conn = @mysqli_connect($_SESSION['host'], $_SESSION['user'], $_SESSION['pwd']);
				if (mysqli_connect_errno()){//Credenziali errate
					echo"<script> logout(); </script>";
				}
				else{//Credenziali corrette
					if(!isset($_GET['db'])){
						echo "<script> 
							setCookie('phase','dbView',2);
							window.location.href= './index.php?';
						</script>";
					}else{
						echo "<h1> Tables </h1>";
						mysqli_query($conn, "USE ".$_GET['db']);
						$result = mysqli_query($conn, "SHOW TABLES");
						
						if(@mysqli_num_rows($result)!=0){
							echo "<script> function tableView(tableName){
							setCookie('phase','tableView',2);
							window.location.href= './index.php?db=' + tableName;
							} </script>";
							while($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
								echo '<button type="button" data-toggle="collapse" data-target="#'.$row[0].'TABLE">'.$row[0].'</button> <br>';
								echo '<div id="'.$row[0].'TABLE" class="collapse">
								<p>Rinchiudimi</p>
								</div>';
							}
						}
					}
					
				}
				echo "<br><input type='button' onClick='logout()' value='Logout'>";
			break;
        }
        
    ?>
</body>
</html>