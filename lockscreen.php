<?php session_start();

if(!isset($_GET['pg'])){
    header("Location:logout");
}
if(!isset($_SESSION['UserID'])){
    
    header("Location:logout");
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
    <link href="assets/css/authentication/form-2.css" rel="stylesheet" type="text/css" />
    <!-- toastr -->
    <link href="plugins/notification/snackbar/snackbar.min.css" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->
    <link rel="stylesheet" type="text/css" href="assets/css/forms/theme-checkbox-radio.css">
    <link rel="stylesheet" type="text/css" href="assets/css/forms/switches.css">
</head>

<body class="form no-image-content">
    <?php
    
$UserID = $_SESSION['UserID'];

$_SESSION['UserIDLocked'] = "locked";
    
require_once('connect.php');
    
$result = mysqli_query($con,"SELECT * FROM `users` WHERE `UserID` = '$UserID'");
       
$res = mysqli_fetch_array($result);
    ?>
    <div class="form-container outer">
        <div class="form-form">
            <div class="form-form-wrap">
                <div class="form-container">
                    <div class="form-content">

                        <div class="d-flex user-meta">
                            <img src="assets/img/avatar.jpg" class="usr-profile" alt="avatar">
                            <div class="">
                                <p class=""><?php echo $res['FirstName'].' '.$res['LastName']; ?></p>
                            </div>
                        </div>

                        <form class="text-left" action="lockscreen?pg=<?php echo $_GET['pg']; ?>" method="POST">
                            <div class="form">
                                <div id="password-field" class="field-wrapper input mb-2">
                                    <div class="d-flex justify-content-between">
                                        <label for="password">PASSWORD</label>
                                        <a href="passwordrecovery" class="forgot-pass-link">Forgot Password?</a>
                                    </div>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock">
                                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                        <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                    </svg>
                                    <input id="password" name="password" type="password" class="form-control" placeholder="Password">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" id="toggle-password" class="feather feather-eye">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                        <circle cx="12" cy="12" r="3"></circle>
                                    </svg>
                                </div>
                                <div class="d-sm-flex justify-content-between">
                                    <div class="field-wrapper">
                                        <button type="submit" name="unlock" class="btn btn-primary" value="">Unlock</button>
                                    </div>
                                </div>
                                <a href="logout" class="forgot-pass-link mt-3 float-right">Sign out.</a>

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
    <!-- toastr -->
    <script src="plugins/notification/snackbar/snackbar.min.js"></script>

    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <script src="assets/js/components/notification/custom-snackbar.js"></script>

    <!-- END GLOBAL MANDATORY SCRIPTS -->
    <script src="assets/js/authentication/form-2.js"></script>

</body>

</html>
<?php

ini_set('display_errors', 1); 
ini_set('display_startup_errors', 1); 
error_reporting(E_ALL);

if(isset($_POST['unlock'])){
	
require_once('connect.php');
    
$UserID = $_SESSION['UserID'];
$password = mysqli_real_escape_string($con,$_POST['password']);
	
$result = mysqli_query($con,"SELECT * FROM `users` WHERE `UserID` = '$UserID' AND `Password` = '$password'");
    
if(mysqli_num_rows($result)){
	
	$res = mysqli_fetch_array($result);
        
	$_SESSION['UserIDLocked'] = "None";
    
        ?>
<script>
    window.location.href = "<?php echo $_GET['pg']; ?>";

</script>

<?php

	
    
}else{
	?>
<script>
    Snackbar.show({
        text: 'Incorrect Password.',
        pos: 'top-right',
        actionTextColor: '#fff',
        backgroundColor: '#B71C1C'
    });

</script>
<?php
}

}
?>
