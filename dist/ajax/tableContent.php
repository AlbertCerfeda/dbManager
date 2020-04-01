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
                                <thead>
                                <tr>';

    echo'<th>Name</th>'.
                                '<th>Prova</th>'.
                                '<th>Prova</th>'.
                                '<th>Prova</th>'.
                                '<th>Prova Prova</th>'.
                                '<th>Prova</th>'.
                            '</tr>'.
                        '</thead>'.
                        '<tfoot>'.
                            '<tr>'.
                                '<th>Name</th>'.
                                '<th>Position</th>'.
                                '<th>Office</th>'.
                                '<th>Age</th>'.
                                '<th>Start date</th>'.
                                '<th>Salary</th>'.
                            '</tr>'.
                        '</tfoot>'.
                        '<tbody>'.
                            '<tr>'.
                                '<td><input type="text" required readonly></td>'.
                                '<td><input type="text" required readonly></td>'.
                                '<td>EDIMBRA</td>'.
                                '<td>61</td>'.
                                '<td>2011/04/25</td>'.
                                '<td>$320,800</td>'.
                            '</tr>'.
                        '</tbody>'.
                    '</table>'.
                '</div>'.
            '</div>'.
        '</div>'.
    '</div>'.
'';
}
?>