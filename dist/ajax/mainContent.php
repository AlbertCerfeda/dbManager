<div class="container-fluid">
    <?php

    echo '<script src="/dbManager/dist/ajax/ajaxUtils.js"> </script>';
    if (!$_GET['db'] || !$_GET['table']){ //If either the table or the database are not specified, a generic main gets sent back
        echo
        '<div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="text-center mt-4">
                        <img class="mb-4 img-error" src="assets/img/no-table-selected.svg" />
                        <p class="lead">Nothing to see here!</p>
                        <a href="#"  ><i class="fas fa-arrow-left mr-1"></i>Select a table from the navigation bar</a>
                    </div>
                </div>
            </div>
        </div>';
    }else{ //If both a table and a database are specified
        echo '<h1 class="mt-4">'.$_GET['table'].'</h1>
            <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item"><a href="#">'.$_GET['db'].'</a></li>
                    <li class="breadcrumb-item active">'.$_GET['table'].'</li>
            </ol>';

        echo '
            <div id="table">
                 <script type="text/javascript">
                        $(document).ready(ajax_getTableContent("'.$_GET["db"].'","'.$_GET["table"].'","#table"));
                 </script> 
            </div>';





    }
    ?>
</div>