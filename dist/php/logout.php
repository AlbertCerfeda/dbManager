<?php
    include('./loginUtilities.php');
    if(closeConnection()){
        echo '<script> console.log("CHIUSO")</script>';
        header('Location: ../login.php');
    }else{
        echo '<script> console.log("FALLITO")</script>';
        header('Location: ../index.php');
    }

?>