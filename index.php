<?php
session_start();
if (isset($_SESSION['name']) && $_SERVER['PHP_SELF']=='/raadClient/index.php'){
// if (isset($_SESSION['nameclient']) && $_SERVER['PHP_SELF']=='/index.php'){
    
    echo '<script>
        location.replace(\'home.php\');
    </script>';
} 
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
        <meta name="author" content="Coderthemes">

        <!-- App Favicon -->
        <link rel="shortcut icon" href="assets/images/favicon.png">

        <!-- App title -->
        <title>Raad Co-Shared office</title>

        <!-- App CSS -->
        <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/core.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/components.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/icons.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/pages.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/menu.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/responsive.css" rel="stylesheet" type="text/css" />

        <!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->

        <script src="assets/js/modernizr.min.js"></script>
        
    </head>
    <body>
        <?php

        include_once('functions.php');
$conn = connect_db();

if(isset($_REQUEST['submit'])){
    $email = $_REQUEST['email'];
    $password = $_REQUEST['pass'];
$email_search = "SELECT * FROM company_with_raad where email = '$email' ";
$query = mysqli_query($conn,$email_search);

$emai_count = mysqli_num_rows($query);

if($emai_count){
    $email_pass = mysqli_fetch_assoc($query);
    $db_pass =  $email_pass['pass']; 

    if($db_pass==$password){

        $_SESSION['nameclient'] = $email_pass['owner_name'];
        $_SESSION['id'] = $email_pass['owner_id'];
        $_SESSION['e_mail'] = $email_pass['email'];
        $_SESSION['room_id'] = $email_pass['room_id'];
        // $_SESSION['office_id'] = $email_pass['office_id'];
        echo'
        <script type="text/javascript">
        window.location.href ="home.php";
        </script>';
    }else{
    echo '<script>
    alert("Password is incorrect")
    </script>';
    }
}else{
echo '<script>
    alert("E-mail is incorrect")
    </script>';
}

}
?>

        <div class="account-pages"></div>
        <div class="clearfix"></div>
        <div class="wrapper-page">
            <div class="text-center">
                <a href="index.html" ><img class="logo m-t-15" width="70%" src="assets/images/logo.png"></a>
                <h5 class="text-muted m-t-5 font-600">Co-Shared Office</h5>
            </div>
            <div class="m-t-40 card-box">
                <div class="text-center">
                    <h4 class="text-uppercase font-bold m-b-0">Sign In</h4>
                </div>
                <div class="panel-body">
                    <form class="form-horizontal m-t-20" action="index.php" method="post">

                        <div class="form-group ">
                            <div class="col-xs-12">
                                <input class="form-control" name="email" type="text" required="" placeholder="Username">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-xs-12">
                                <input class="form-control" name="pass" type="password" required="" placeholder="Password">
                            </div>
                        </div>

                        <!-- <div class="form-group ">
                            <div class="col-xs-12">
                                <div class="checkbox checkbox-custom">
                                    <input id="checkbox-signup" type="checkbox">
                                    <label for="checkbox-signup">
                                        Remember me
                                    </label>
                                </div>

                            </div>
                        </div> -->

                        <div class="form-group text-center m-t-30">
                            <div class="col-xs-12">
                                <button class="btn btn-bordred btn-block waves-effect waves-light" name="submit" type="submit" style="background-color: #664703; color: white">Log In</button>
                            </div>
                        </div>

                        <div class="form-group m-t-30 m-b-0">
                            <div class="col-sm-12">
                                <a href="page-recoverpw.php" class="text-muted"><i class="fa fa-lock m-r-5"></i> Forgot your password?</a>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
            <!-- end card-box-->
            
        </div>
        <!-- end wrapper page -->
        

        
        <script>
            var resizefunc = [];
        </script>

        <!-- jQuery  -->
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
        <script src="assets/js/detect.js"></script>
        <script src="assets/js/fastclick.js"></script>
        <script src="assets/js/jquery.slimscroll.js"></script>
        <script src="assets/js/jquery.blockUI.js"></script>
        <script src="assets/js/waves.js"></script>
        <script src="assets/js/wow.min.js"></script>
        <script src="assets/js/jquery.nicescroll.js"></script>
        <script src="assets/js/jquery.scrollTo.min.js"></script>

        <!-- App js -->
        <script src="assets/js/jquery.core.js"></script>
        <script src="assets/js/jquery.app.js"></script>
    
    </body>
</html>