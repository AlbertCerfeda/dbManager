<!DOCTYPE html>
<html>
<head>
	<title>dbManager</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <?php 
        if(!isset($_COOKIE['functions'])){
            $_COOKIE['functions']=array();
            
            $_COOKIE['functions']
            ['ciao']= function(){
                echo "ciao";
            };
        }
        if (!isset($_COOKIE['phase'])) {
            setcookie('phase', 'login');
            $_COOKIE['phase']='login';
            unset($_GET);
        }
        if ($_COOKIE['phase']=='login' ){//Fase di login
            echo"<h1>Login into MySQL</h1>
                <form action='index.php' method='GET'>
                    host: <input type='text' name='host' required><br>
                    user: <input type='text' name='user' required><br>
                    password: <input type='password' name='pwd'><br>

                    <input type='submit' value='Login'>
                </form>";
            if (isset($_GET)){

                $conn = @mysqli_connect($_GET['host'], $_GET['user'], $_GET['pwd']);
                if (mysqli_connect_errno()){//Credenziali errate
                    echo"<div id='warn'>Connessione fallita: " . mysqli_connect_error()."</div>";
                }
                else{//Credenziali corrette
                    setcookie("phase", "dbView");
                    setcookie("conn", $conn);
                    echo '<script> window.location.reload() </script>';
                    

                }
            }
        } else if ($_COOKIE['phase']=='dbView'){
            echo "Logged in";
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            echo "<script type='text/javascript'> 
                    function logout(){
                        document.cookie = 'phase=login ; expires = Thu, 01 Jan 1970 00:00:00 GMT';
                        window.location.reload();
                    }
                </script>
                <br><input type='button' onClick='logout()' value='Logout'>";
        }
        
    ?>
    <?php
    
    ?>
</body>
</html>