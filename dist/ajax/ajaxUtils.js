function ajax_getMainContent($db,$table,$destination){
    console.log("[AJAX][mainContent.php -> "+$destination+"] Sending AJAX to get main's data...");
    $($destination).prepend('<center>\n' +
        '        <div class="spinner-border text-info" role="status">\n' +
        '            <span class="sr-only">Getting mains content...</span>\n' +
        '        </div>\n' +
        '        </center>');

    $.ajax({
        url: 'ajax/mainContent.php',
        type: 'GET',
        data: {
            db: $db,
            table: $table
        },
        success: function (data) {
            console.log("[AJAX][main] Success!");
            $($destination).html(data);
            return true;
        },
        error: function () {
            console.log("[AJAX][main] Failed!");
            $($destination).html('<div class="alert alert-danger alert-dismissible fade show" style="max-width: 100%;font-size: 14px;margin-top: 3%;">'+
                '<button type="button" class="close" data-dismiss="alert">&times;</button>' +
                'Couldnt contact the server <br><strong> Try again later</strong> '+
                '</div>'
            );
            return false;
        }
    });
}

function ajax_getNavbarContent($destination){
    console.log("[AJAX][navbarContent.php -> "+$destination+"] Sending AJAX to get the sidenav data...");
    $($destination).prepend('<center>\n' +
        '        <div class="spinner-border text-info" role="status">\n' +
        '            <span class="sr-only">Getting navbar content...</span>\n' +
        '        </div>\n' +
        '        </center>');
    $.ajax({
        url: 'ajax/navbarContent.php',
        type: 'GET',
        dataType: 'html',
        success: function (data) {
            console.log("[AJAX][sidenav] Success!");
            $($destination).html(data);
            return true;
        },
        error: function () {
            console.log("[AJAX][sidenav] Failed!");
            $($destination).html('<div class="alert alert-danger alert-dismissible fade show" style="max-width: 100%;font-size: 14px;margin-top: 3%;">'+
                '<button type="button" class="close" data-dismiss="alert">&times;</button>' +
                'Couldnt contact the server <br><strong> Try again later</strong> '+
                '</div>'
            );
            return false;
        }
    });
}

function ajax_getTableContent($db,$table,$destination){
    console.log("[AJAX][tableContent.php -> "+$destination+"] Sending AJAX to get table's data...");
    $($destination).prepend('<center>\n' +
        '        <div class="spinner-border text-info" role="status">\n' +
        '            <span class="sr-only">Getting tables content...</span>\n' +
        '        </div>\n' +
        '        </center>');
    $.ajax({
        url: '/dbManager/dist/ajax/tableContent.php',
        type: 'GET',
        data: {
            db: $db,
            table: $table
        },
        success: function (data) {
            console.log("[AJAX][tableContent.php] Success!");
            $($destination).html(data);
            return true;
        },
        error: function () {
            console.log("[AJAX][tableContent.php] Failed!");
            $($destination).html('<div class="alert alert-danger alert-dismissible fade show" style="max-width: 100%;font-size: 14px;margin-top: 3%;">'+
                '<button type="button" class="close" data-dismiss="alert">&times;</button>' +
                'Couldnt contact the server <br><strong> Try again later</strong> '+
                '</div>'
            );
            return false;
        }
    });
}