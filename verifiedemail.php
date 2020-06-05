<?php
    if(!isset($_GET['gyuthdyust'])){
        header("Location:login");
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>Complaint Tracker</title>
    <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico" />
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/plugins.css" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->
    <link rel="stylesheet" type="text/css" href="assets/css/forms/theme-checkbox-radio.css">
    <link rel="stylesheet" type="text/css" href="assets/css/forms/switches.css">
</head>

<body class="form">

    <?php
    
        $UserID = $_GET['gyuthdyust'];
    
        require_once('connect.php');
        
        if(mysqli_query($con,"UPDATE `users` SET `UserConfirmed` = 'Yes' WHERE `UserID` = '$UserID'")){
    
    ?>

    <div class="form-container text-center" style="margin-top: 12em;">
        <div class="form-form">
            <div class="form-form-wrap">
                <div class="form-container">
                    <div class="form-content">

                        <h1 class="">Welcome to <span class="text-warning">Complaint Tracker</span></h1>
                        <p class="signup-link mb-5">You are just one step from logging a complaint from your fingertips!!</p>
                        <h4>Congratulations!!!! Your email has been verified successfully.</h4>
                        <a href="login" class="btn btn-outline-warning mt-3" value="">Login Screen</a>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php }else{
            
           ?>

    <div class="form-container text-center" style="margin-top: 12em;">
        <div class="form-form">
            <div class="form-form-wrap">
                <div class="form-container">
                    <div class="form-content">
                        <h1>Oops</h1>
                        <h1 class="text-danger"><strong>Something went wrong while trying to verify your email.</strong></h1>
                        <p class="signup-link mb-5 text-warning"> <strong>Apologies for the inconvenience.</strong></p>
                        <h4>Please try again later</h4>
                        <a href="login" class="btn btn-outline-warning mt-3" value="">Login Screen</a>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php 
            
        } ?>

    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script src="assets/js/libs/jquery-3.1.1.min.js"></script>
    <script src="bootstrap/js/popper.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>

    <!-- END GLOBAL MANDATORY SCRIPTS -->

</body>

<!-- Mirrored from designreset.com/cork/ltr/demo1/auth_pass_recovery.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 20 May 2020 01:10:04 GMT -->

</html>
