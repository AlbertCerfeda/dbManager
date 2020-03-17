<!DOCTYPE html>
<html>
<head>
	<title>login</title>
    <link rel="stylesheet" href="common/style.css">
</head>
<body>
<?php
    @session_start();

    if(!isset($_GET['afterLogin'])){
        $_GET['afterLogin'] = 'dbView.php';
    }
    echo"<h1>Login into MySQL</h1>
    <form action='login.php' method='GET'>
    <table>
        <tr> <td>host:</td> <td><input type='text' name='host' required></td> </tr>
        <tr> <td>user:</td> <td><input type='text' name='user' required></td> </tr>
        <tr> <td>password:</td> <td><input type='password' name='pwd'></td> </tr>
        <input type='hidden' name='prev' value='".$_GET['afterLogin']."'>
        <tr> <td><input type='submit' value='Login'></td> </tr>
    </table>
    </form>";
    if (sizeof($_GET)>1){
        $conn = @mysqli_connect($_GET['host'], $_GET['user'], $_GET['pwd']);
        if (mysqli_connect_errno()){//Credenziali errate
            echo"<div id='warn'>Connessione fallita: " . mysqli_connect_error()."</div>";
        }
        else{//Credenziali corrette
            $_SESSION['conn']= $conn;
            $_SESSION['host']= $_GET['host'];
            $_SESSION['user']= $_GET['user'];
            $_SESSION['pwd']= $_GET['pwd'];
            
            echo "<script> window.location.href= './".$_GET['afterLogin']."' </script>";
        }
    }
?>
</body>
</html>