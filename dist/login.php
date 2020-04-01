<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <meta name="description" content=""/>
    <meta name="author" content=""/>
    <title>Page Title - SB Admin</title>
    <link href="css/styles.css" rel="stylesheet"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js"
            crossorigin="anonymous"></script>
</head>
<body class="bg-primary">
<div id="layoutAuthentication">
    <div id="layoutAuthentication_content">
        <main>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-5">
                        <div class="card shadow-lg border-0 rounded-lg mt-5">
                            <div class="card-header"><h3 class="text-center font-weight-light my-4"><b>Login into MySQL</b></h3></div>
                            <div class="card-body">
                                <form>
                                    <?php
                                    @session_start();

                                    if (!isset($_GET['afterLogin'])) {
                                        $_GET['afterLogin'] = '/dbManager/dist/index.php';
                                    }

                                    echo "
                                            <div>
                                                <form action='login.php' method='GET'>
                                                <center>
                                                    <table>
                                                        <tr> <td>host:</td> <td><input type='text' class='form-control' name='host' required></td> </tr>
                                                        <tr> <td>user:</td> <td><input type='text' class='form-control' name='user' required></td> </tr>
                                                        <tr> <td>password:</td> <td><input type='password' class='form-control' name='pwd'></td> </tr>
                                                        <input type='hidden' name='prev' value='" . $_GET['afterLogin'] . "'>
                                                        <tr> <td colspan='2' ><button type='submit' class='btn btn-primary' style='width: 100%'>Submit</button></td> </tr>
                                                    </table>
                                    ";
                                    if (sizeof($_GET) > 1) {
                                        $conn = @mysqli_connect($_GET['host'], $_GET['user'], $_GET['pwd']);
                                        if (mysqli_connect_errno()) {//Credenziali errate
                                            echo '<div class="alert alert-danger alert-dismissible fade show" style="max-width: 60%;font-size: 14px;margin-top: 3%">
                                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                                    <strong>Connection Failed!</strong> ' . mysqli_connect_error() . '
                                                </div>';
                                        } else {//Credenziali corrette
                                            echo "<script> window.location.href= '". $_GET['afterLogin'] . "' </script>";
                                            $_SESSION['host']=$_GET['host'];
                                            $_SESSION['user']=$_GET['user'];
                                            $_SESSION['pwd']=$_GET['pwd'];

                                            include('./php/loginUtilities.php');
                                            unset($_GET);
                                            setLogout(false);

                                        }
                                    }
                                    echo "
                                                </center>
                                            </form>
                                    </div>";
                                    ?>
                                </form>
                            </div>
                            <div class="card-footer text-center">
                                <div class="small"><a href="https://github.com/AlbertCerfeda">Contact developer</a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="js/scripts.js"></script>
</body>
</html>
