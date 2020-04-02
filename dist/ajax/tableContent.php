<?php
@session_start();
include('../php/sendQuery.php');
if ($_GET['db'] && $_GET['table']) {
    getMysqli(function () {
        echo
            '<div class="alert alert-danger alert-dismissible fade show" style="max-width: 100%;font-size: 14px;margin-top: 3%;">' .
            '<button type="button" class="close" data-dismiss="alert">&times;</button>' .
            'Couldnt connect to the database<br>Try to <strong> <u><i onclick="logout()"> login</i></u></strong> again ' . mysqli_connect_error() .
            '</div>';
        exit();
    });

    echo
        '<div class="card mb-4">
            <div class="card-header"><i class="fas fa-table mr-1"></i>' . $_GET['table'] . '</div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                ';

    sendQuery("USE ".$_GET['db']);
    $result=  sendQuery("DESCRIBE ".$_GET['table']);

    ////////////////////////////////////////
    ////Printing Columns in Table
    if(@mysqli_num_rows($result)!=0){
        $fields=array();
        while($row = mysqli_fetch_array($result, MYSQLI_NUM)){
            $fields[sizeof($fields)]=$row[0];
        }
    }

    echo'<thead><tr> ';
    foreach ($fields as $value){
        echo '<th>'.$value.'</th>';
    }
    echo '</tr> </thead>';

    echo'<tfoot><tr> ';
    foreach ($fields as $value){
        echo '<th>'.$value.'</th>';
    }
    echo '</tr> </tfoot>';
    ////////////////////////////////////////
    //Printing all records inside the table
    $result=  sendQuery("SELECT * FROM ".$_GET['table']);

    $records=array();
    if(@mysqli_num_rows($result)!=0){
        while($row = mysqli_fetch_array($result, MYSQLI_NUM)){//Iterates every record
            $nRecords=sizeof($records);
            $records[$nRecords]=array();//Creates the array where all the records fields are stored
            foreach ($row as $value){//Puts every field of the record inside the matrix
                $records[$nRecords][sizeof($records[$nRecords])]=$value;
            }
        }
    }
    echo'<tbody>';
    foreach ($records as $currRecord){
        echo '<tr>';
        foreach ($currRecord as $field){
            echo '<td>'.$field.'</td>';
        }
        echo '</tr>';
    }
    echo '</tbody>';


     echo           '</table>'.
                '</div>'.
            '</div>'.
        '</div>'.
    '</div>
    <script> 
        $(document).ready(function() {
            $("#dataTable").DataTable( {
                "paging":   true,
                "ordering": true,
                "info":     false
            });
        } );
    </script>';
}
?>