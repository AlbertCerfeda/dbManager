<?php
@session_start();
include('../php/sendQuery.php');

getMysqli(function () {
    echo
        '<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseError" aria-expanded="false" aria-controls="collapseError">' .
        '<div class="alert alert-danger alert-dismissible fade show" style="max-width: 100%;font-size: 14px;margin-top: 3%;">' .
        '<button type="button" class="close" data-dismiss="alert">&times;</button>' .
        'Couldnt connect to the database<br>Try to <strong> <u><i onclick="logout()"> login</i></u></strong> again ' . mysqli_connect_error() .
        '</div>' .
        '</a>';
    exit();
});

$dbList = sendQuery("SHOW DATABASES;");
if(@mysqli_num_rows($dbList)!=0){
    while($db = mysqli_fetch_array($dbList, MYSQLI_NUM)) { //Iterates every database;
        echo
        '<a class="nav-link collapsed" data-db="'.$db[0].'" href="#" data-toggle="collapse" data-target="#collapse'.$db[0].'" aria-expanded="false" aria-controls="collapse'.$db[0].'">'.
            '<div class="sb-nav-link-icon"><i class="fas fa-database"></i></div>'.
            $db[0].
            '<div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>'.
        '</a>';

        //$mysqli =@mysqli_connect($_SESSION['host'], $_SESSION['user'], $_SESSION['pwd']);
        sendQuery("USE ".$db[0]);
        $tableList = sendQuery("SHOW TABLES");

        //$GLOBALS['$mysqli'] =@mysqli_connect($_SESSION['host'], $_SESSION['user'], $_SESSION['pwd']);
        //sendQuery("USE dbcrud");
        //$tableList = sendQuery("SHOW TABLES");
        echo
        '<div class="collapse" id="collapse'.$db[0].'" aria-labelledby="heading'.$db[0].'" data-parent="#sidenavAccordion">'.
            '<nav class="sb-sidenav-menu-nested nav">';
        if(@mysqli_num_rows($tableList)!=0){

            while($table = mysqli_fetch_array($tableList, MYSQLI_NUM)) {//Iterates every table
                echo
                '<a data-table="'.$table[0].'" data-db="'.$db[0].'" class="nav-link tableLink" href="#">'.
                    '<div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>'.$table[0].'</a>';
            }

        }else{
            echo
                '<a class="nav-link disabled" href="#">'.
            '<div class="sb-nav-link-icon"><i class="fas fa-exclamation"></i><i>Empty database</i></div></a>';
        }
        echo
            '</nav>'.
        '</div>';
    }
    echo '<script>
    $(" .tableLink ").click(function(){
        ajax_getMainContent( $(this).attr("data-db") , $(this).attr("data-table"),"#main");
    });
    </script>';
}

?>