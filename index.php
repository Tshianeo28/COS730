<?php session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>ComplaintTracker</title>
    <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico" />
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/plugins.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/authentication/form-2.css" rel="stylesheet" type="text/css" />
    <!-- toastr -->
    <link href="plugins/notification/snackbar/snackbar.min.css" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->
    <link rel="stylesheet" type="text/css" href="assets/css/forms/theme-checkbox-radio.css">
    <link rel="stylesheet" type="text/css" href="assets/css/forms/switches.css">
</head>

<body class="form">
    <div class="form-container outer">
        <div class="form-form">
            <div class="form-form-wrap">
                <div class="form-container">
                    <div class="form-content">

                        <h1 class="">Sign In</h1>
                        <p class="">Log in to your account to continue.</p>

                        <form class="text-left" action="login" method="POST" novalidate>
                            <div class="form">
                                <div id="username-field" class="field-wrapper input">
                                    <label for="username">EMAIL ADDRESS</label>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user">
                                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="12" cy="7" r="4"></circle>
                                    </svg>
                                    <input id="email" required name="email" type="text" class="form-control" placeholder="Enter Email Address">
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Please fill the name
                                    </div>
                                </div>

                                <div id="password-field" class="field-wrapper input mb-2">
                                    <div class="d-flex justify-content-between">
                                        <label for="password">PASSWORD</label>
                                        <a href="passwordrecovery" class="forgot-pass-link">Forgot Password?</a>
                                    </div>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock">
                                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                        <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                    </svg>
                                    <input id="password" required name="password" type="password" class="form-control" placeholder="Password">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" id="toggle-password" class="feather feather-eye">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                        <circle cx="12" cy="12" r="3"></circle>
                                    </svg>
                                </div>
                                <div class="d-sm-flex justify-content-between">
                                    <div class="field-wrapper">
                                        <button name="login" type="submit" class="btn btn-primary" value="">Log In</button>
                                    </div>
                                </div>
                                <p class="signup-link">Not registered ? <a href="register">Create an account</a></p>

                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script src="assets/js/libs/jquery-3.1.1.min.js"></script>
    <script src="bootstrap/js/popper.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>

    <script src="assets/js/scrollspyNav.js"></script>
    <!-- toastr -->
    <script src="plugins/notification/snackbar/snackbar.min.js"></script>

    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <script src="assets/js/components/notification/custom-snackbar.js"></script>
    <script src="assets/js/forms/bootstrap_validation/bs_validation_script.js"></script>
    <!--  END CUSTOM SCRIPTS FILE  -->
    <!-- END GLOBAL MANDATORY SCRIPTS -->
    <script src="assets/js/authentication/form-2.js"></script>

</body>

</html>
<?php

ini_set('display_errors', 1); 
ini_set('display_startup_errors', 1); 
error_reporting(E_ALL);

if(isset($_POST['login'])){
	
require_once('connect.php');
    
$email = mysqli_real_escape_string($con,$_POST['email']);
$password = mysqli_real_escape_string($con,$_POST['password']);
	
$result = mysqli_query($con,"SELECT * FROM `users` WHERE `EmailAddress` = '$email' AND `Password` = '$password'");
    
if(mysqli_num_rows($result)){
	
	$res = mysqli_fetch_array($result);
    
	$ConfirmedValue = $res['UserConfirmed'];
	$Active = $res['Active'];
    
    
    if($Active == "Yes"){
        
    if($ConfirmedValue == "Yes"){
    
	$_SESSION['UserID'] =  $res['UserID'];
    $_SESSION['UserIDLocked'] = "None";
	$_SESSION['UserType'] = $res['UserType'];
    
    if($res['UserType'] == "Admin"){
        ?>
<script>
    window.location.href = "admin";

</script>

<?php

    }
    if($res['UserType'] == "Delegate"){
         ?>
<script>
    window.location.href = "delegate";

</script>

<?php
        
    }
    if($res['UserType'] == "Citizen"){
         ?>
<script>
    window.location.href = "citizen?";

</script>

<?php
        
    }
    if($res['UserType'] == "Personel"){
         ?>
<script>
    window.location.href = "personel";

</script>

<?php
        
    }
	}else{
    ?>
<script>
    Snackbar.show({
        text: 'Please verify your Email Address first.',
        pos: 'top-right',
        actionTextColor: '#fff',
        backgroundColor: '#B71C1C'
    });

</script>
<?php
    
}
    }else{
    ?>
<script>
    Snackbar.show({
        text: 'User not Active',
        pos: 'top-right',
        actionTextColor: '#fff',
        backgroundColor: '#B71C1C'
    });

</script>
<?php
    
}
}else{
	?>
<script>
    Snackbar.show({
        text: 'Incorrect Email Address or Password.',
        pos: 'top-right',
        actionTextColor: '#fff',
        backgroundColor: '#B71C1C'
    });

</script>
<?php
}

}
?>
