<?php
include('loginUtilities.php');

@session_start();
    if (isset($_GET['query'])){
        $result ="";
        echo sendQuery($_GET['query']);
    }
    function sendQuery($query){
        if (getMysqli(null)){
            $result=mysqli_query(getMysqli(null),$query);
            echo "<script> console.log($query);</script>";
            return $result;
        }else{
            return false;
        }
    }

?>