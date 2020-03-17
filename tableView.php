<!DOCTYPE html>
<html>
<head>
	<title>Tables</title>
    <link rel="stylesheet" href="common/style.css">
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
	require('./common/JSfunc.php');

	@session_start();

	$conn = @mysqli_connect($_SESSION['host'], $_SESSION['user'], $_SESSION['pwd']);
	if (mysqli_connect_errno()){//Credenziali errate
		echo"<script> logout(); </script>";
	}
	else{//Credenziali corrette
		if(!isset($_GET['db'])){
			echo "<script> 
				window.location.href= './dbView.php';
			</script>";
		}else{
			echo "<h1> Tables </h1>";
			mysqli_query($conn, "USE ".$_GET['db']);
			$result = mysqli_query($conn, "SHOW TABLES");
			
			if(@mysqli_num_rows($result)!=0){

				while($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
					echo '<button type="button" data-toggle="collapse" data-target="#'.$row[0].'TABLE">'.$row[0].'</button> <br>';
					echo '<div id="'.$row[0].'TABLE" class="collapse">
					<p>Rinchiudimi</p>
					</div>';
				}
			}
		}
		
	}
	echo "<br><input type='button' onClick="."'logout(".'"tableView.php"'.")' value='Logout'>";
?>
</body>
</html>