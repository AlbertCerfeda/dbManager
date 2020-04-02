<?php
@session_start();
include('../php/sendQuery.php');
function isColumnPK($db,$table,$columnName){
    /*
     select tab.table_schema as database_name,
        sta.index_name as pk_name,
        sta.column_name as 'columns',
        tab.table_name
    from information_schema.tables as tab
    inner join information_schema.statistics as sta
        on sta.table_schema = tab.table_schema
        and sta.table_name = tab.table_name
        and sta.index_name = 'primary'
    where tab.table_schema = 'dbfarmacia'
        and tab.table_type = 'BASE TABLE'
        and tab.table_name = 'cassetto'
        and sta.column_name = 'COD';
     */
    sendQuery("USE ".$_GET['db']);
    $result=sendQuery(
        "select tab.table_schema as database_name,
        sta.index_name as pk_name,
        sta.column_name as 'columns',
        tab.table_name
    from information_schema.tables as tab
    inner join information_schema.statistics as sta
        on sta.table_schema = tab.table_schema
        and sta.table_name = tab.table_name
        and sta.index_name = 'primary'
    where tab.table_schema = '".$db."'
        and tab.table_type = 'BASE TABLE'
        and tab.table_name = '".$table."'
        and sta.column_name = '".$columnName."';"
    );

    if(@mysqli_num_rows($result)!=0)
        return true;
    else
        return false;
}
function isColumnFK($db,$table,$columnName){
    /*
     SELECT
        TABLE_NAME,COLUMN_NAME,CONSTRAINT_NAME, REFERENCED_TABLE_NAME,REFERENCED_COLUMN_NAME
        FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE
    WHERE
        TABLE_NAME ='scultura_materiale' AND
        COLUMN_NAME ='CODICE_scultura' AND
        TABLE_SCHEMA ='dbcrud' AND
        REFERENCED_TABLE_NAME IS NOT NULL;
     */
    $query="SELECT TABLE_NAME,COLUMN_NAME,CONSTRAINT_NAME, REFERENCED_TABLE_NAME,REFERENCED_COLUMN_NAME ".
        "FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE ".
        "WHERE ".
        "TABLE_NAME ='".$table."' AND ".
        "COLUMN_NAME ='".$columnName."' AND ".
        "TABLE_SCHEMA ='".$db."' AND ".
        "REFERENCED_TABLE_NAME IS NOT NULL; ";
    $result=sendQuery($query);

    echo '<script> console.log("'.$query.'")</script>';
    if(@mysqli_num_rows($result)!=0)
        return true;
    else
        return false;
}
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
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">';

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
        echo '<th>'.$value.'<p style="width: 100%; margin: 0;display: inline-block"> ';
        if (isColumnPK($_GET['db'],$_GET['table'],$value)){
            echo "<span class='badge badge-primary'>PRIMARY</span>";
        }
        if (isColumnFK($_GET['db'],$_GET['table'],$value)){
            echo "<span class='badge badge-info'>FOREIGN</span>";
        }
        //TODO: Other controls here
        echo '</p></th>';
    }
    echo '</tr> </thead>';

    echo'<tfoot><tr> ';
    foreach ($fields as $value){
        echo '<th>'.$value.'<p style="width: 100%; margin: 0;display: inline-block"> ';
        if (isColumnPK($_GET['db'],$_GET['table'],$value)){
            echo "<span class='badge badge-primary'>PRIMARY</span>";
        }
        if (isColumnFK($_GET['db'],$_GET['table'],$value)){
            echo "<span class='badge badge-info'>FOREIGN</span>";
        }
        //TODO: Other controls here
        echo '</p></th>';
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


     echo '          </table>
                 </div>
             </div>
         </div>
     </div>
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