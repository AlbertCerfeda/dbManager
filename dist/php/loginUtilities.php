<?php
@session_start();
function checkIfLoggedOut(){
    if (!isset($_SESSION['user']) )
        header('Location: ../dist/login.php');
}

    checkIfLoggedOut();
    if (!isset($_SESSION['logout']))
        $_SESSION['logout'] =false;

    if(!$_SESSION['logout']){
        $mysqli=@mysqli_connect($_SESSION['host'], $_SESSION['user'], $_SESSION['pwd']);
    }



    function getMysqli($ifFalse){ //If it wasn't possible to login again, it executes the ifFalse method
        global $mysqli;

        if (!$_SESSION['logout']){
            if (isset($mysqli) && $mysqli!=false ){
                echo '<script>console.log("[+] [loginUtilities.php] [getMysqli()] returned already existing mysqli handle")</script>';
                return $mysqli;
            }else{
                @session_start();
                echo '<script>console.log("[...] [loginUtilities.php] [getMysqli()] creating mysqli handle to return...")</script>';
                $mysqli =@mysqli_connect($_SESSION['host'], $_SESSION['user'], $_SESSION['pwd']);
                if (mysqli_connect_errno()) {//Credenziali errate
                    echo '<script>console.log("[-] [loginUtilities.php] [getMysqli()] failed to create mysqli handle")</script>';
                    @$ifFalse();
                    return false;
                } else {//Correct credentials
                    echo '<script>console.log("[+] [loginUtilities.php] [getMysqli()] returned mysqli handle")</script>';
                    return $mysqli;
                }
            }
        }

    }

    function closeConnection(){
        global $mysqli;
        if( mysqli_close($mysqli)){
            unset($mysqli);
            setLogout(true);
            $_SESSION=array();
            if (ini_get("session.use_cookies")) {
                $params = session_get_cookie_params();
                setcookie('PHPSESSID', '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"] );
            }

            session_destroy();
            return true;
        }else
            return false;


    }
    function setLogout(bool $bool){
        $_SESSION['logout'] = $bool;
    }
?>
