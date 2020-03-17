<!DOCTYPE html>
<html>
<head>
	<title>Database List</title>
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
		$result = mysqli_query($conn, "SHOW DATABASES");
		if(@mysqli_num_rows($result)!=0){
			echo "<script> function dbView(dbName){
					window.location.href= './tableView.php?db=' + dbName;
				} </script>";
			while($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
				echo "<input type='button' onClick='dbView(this.value)' value='".$row[0]."'><br>";
			}
		}
	}

	echo "<br><input type='button' onClick='logout(dbView.php)' value='Logout'>";
?>
</body>
</html>