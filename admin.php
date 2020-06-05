<?php session_start();

if($_SESSION['UserIDLocked'] == "locked"){
    header("Location:lockscreen?pg=admin");
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
    <!-- END GLOBAL MANDATORY STYLES -->

    <!--  BEGIN CUSTOM STYLE FILE  -->
    <!-- toastr -->
    <link href="plugins/notification/snackbar/snackbar.min.css" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->
    <link href="assets/css/components/custom-modal.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="plugins/editors/quill/quill.snow.css">
    <link href="assets/css/apps/todolist.css" rel="stylesheet" type="text/css" />
    <!--  END CUSTOM STYLE FILE  -->
</head>

<body class="alt-menu">
    <!-- toastr -->
    <script src="plugins/notification/snackbar/snackbar.min.js"></script>

    <?php 

if(isset($_POST['register'])){
	
require_once('connect.php');
    
$FirstName = mysqli_real_escape_string($con,$_POST['FirstName']);
$LastName = mysqli_real_escape_string($con,$_POST['LastName']);
$EmailAddress = mysqli_real_escape_string($con,$_POST['emailAddress']);
$ContactNumber = mysqli_real_escape_string($con,$_POST['contactNumber']);
$Password = mysqli_real_escape_string($con,$_POST['password']);
$UserType = mysqli_real_escape_string($con,$_POST['userType']);
$ConfirmPassword = mysqli_real_escape_string($con,$_POST['confirmPassword']);
$PhysicalAddress = mysqli_real_escape_string($con,$_POST['physicalAddress']);  
    
$uniqUser = uniqid();
$UserID = md5($uniqUser);    

if($Password == $ConfirmPassword){
    
$result = mysqli_query($con,"SELECT * FROM `users` WHERE `EmailAddress` = '$EmailAddress'");
    
if(!mysqli_num_rows($result)){

if(mysqli_query($con,"INSERT INTO `users` (`UserID`,  `FirstName`, `LastName`, `EmailAddress`, `Password`,  `Address`, `UserType`, `ContactNumber`) VALUES ('$UserID','$FirstName','$LastName','$EmailAddress','$Password','$PhysicalAddress','$UserType','$ContactNumber')")){
    // Create the email and send the message
$to = $EmailAddress; 
$email_subject = "Complaint Tracker Registration.";
$htmlContent = '
    <table style="font-family:\'Helvetica Neue\',Helvetica,Arial,sans-serif;box-sizing:border-box;font-size:14px;width:100%;background-color:#f6f6f6;margin:0" bgcolor="#f6f6f6">
        <tbody>
            <tr style="font-family:\'Helvetica Neue\',Helvetica,Arial,sans-serif;box-sizing:border-box;font-size:14px;margin:0">
                <td style="font-family:\'Helvetica Neue\',Helvetica,Arial,sans-serif;box-sizing:border-box;font-size:14px;vertical-align:top;margin:0" valign="top"></td>
                <td width="600" style="font-family:\'Helvetica Neue\',Helvetica,Arial,sans-serif;box-sizing:border-box;font-size:14px;vertical-align:top;display:block!important;max-width:600px!important;clear:both!important;margin:0 auto" valign="top">
                    <div style="font-family:\'Helvetica Neue\',Helvetica,Arial,sans-serif;box-sizing:border-box;font-size:14px;max-width:600px;display:block;margin:0 auto;padding:20px">
                        <table width="100%" cellpadding="0" cellspacing="0" style="font-family:\'Helvetica Neue\',Helvetica,Arial,sans-serif;box-sizing:border-box;display:inline-block;font-size:14px;overflow:hidden;border-radius:7px;background-color:#fff;margin:0;border:1px solid #e9e9e9" bgcolor="#fff">
                            <tbody>
                                <tr style="font-family:\'Helvetica Neue\',Helvetica,Arial,sans-serif;box-sizing:border-box;font-size:14px;margin:0">
                                    <td style="font-family:\'Helvetica Neue\',Helvetica,Arial,sans-serif;box-sizing:border-box;font-size:40px;vertical-align:top;color:#fff;font-weight:500;text-align:center;border-radius:3px 3px 0 0;background-color:#022f44;margin:0;padding:20px" align="center" bgcolor="#71b6f9" valign="top">

                                        <span style="margin-top:20px;display:block"><strong>Complaint Tracker</strong> <small style="font-size:27px"> <br><br>welcomes you.</small></span>
                                    </td>
                                </tr>
                                <tr style="font-family:\'Helvetica Neue\',Helvetica,Arial,sans-serif;box-sizing:border-box;font-size:14px;margin:0">
                                    <td style="font-family:\'Helvetica Neue\',Helvetica,Arial,sans-serif;box-sizing:border-box;border:2px solid #022f44;font-size:14px;vertical-align:top;margin:0;padding:20px" valign="top">
                                        <table width="100%" cellpadding="0" cellspacing="0" style="font-family:\'Helvetica Neue\',Helvetica,Arial,sans-serif;box-sizing:border-box;font-size:14px;margin:0">

                                            <tbody>
                                                <tr style="font-family:\'Helvetica Neue\',Helvetica,Arial,sans-serif;box-sizing:border-box;font-size:14px;margin:0">
                                                    <td style="font-family:\'Helvetica Neue\',Helvetica,Arial,sans-serif;box-sizing:border-box;font-size:14px;vertical-align:top;margin:0;padding:0 0 20px" valign="top">
                                                        Please confirm your email address by clicking the link below.
                                                    </td>
                                                </tr>
                                                <tr style="font-family:\'Helvetica Neue\',Helvetica,Arial,sans-serif;box-sizing:border-box;font-size:14px;margin:0">
                                                    <td style="font-family:\'Helvetica Neue\',Helvetica,Arial,sans-serif;box-sizing:border-box;font-size:16px;vertical-align:top;margin:0;padding:0 0 20px;color:#022f44" valign="top">
                                                        <strong> Please use '.$Password.' as your password to login. Please change it iimediately after logging in. <br><br> We may need to send you critical information about our service and it is important that we have an accurate email address. </strong>
                                                    </td>
                                                </tr>
                                                <tr style="font-family:\'Helvetica Neue\',Helvetica,Arial,sans-serif;box-sizing:border-box;font-size:14px;margin:0">
                                                    <td style="font-family:\'Helvetica Neue\',Helvetica,Arial,sans-serif;box-sizing:border-box;font-size:14px;vertical-align:top;margin:0;padding:0 0 20px" valign="top">
                                                        <a href="http://ct.thaboirvinservices.co.za/verify?gyuthdyust='.$UserID.'" style="font-family:\'Helvetica Neue\',Helvetica,Arial,sans-serif;box-sizing:border-box;font-size:14px;color:#fff;text-decoration:none;line-height:2em;font-weight:bold;text-align:center;display:inline-block;border-radius:5px;text-transform:capitalize;background-color:#022f44;margin:0;border-color:#022f44;border-style:solid;border-width:8px 16px">
                                                            Verify Email
                                                        </a>
                                                    </td>
                                                </tr>
                                                <tr style="font-family:\'Helvetica Neue\',Helvetica,Arial,sans-serif;box-sizing:border-box;font-size:14px;margin:0">
                                                    <td style="font-family:\'Helvetica Neue\',Helvetica,Arial,sans-serif;box-sizing:border-box;font-size:14px;vertical-align:top;margin:0;padding:0 0 20px" valign="top">
                                                        Thank you for choosing <b>Complaint Tracker</b>.
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
';
$headers = "From: Complaint Tracker Team <noreply@ct.co.za>";
            
//boundary 
$semi_rand = md5(time()); 
$mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";
            
//headers for attachment 
$headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$mime_boundary}\"";
            
//multipart boundary 
$message = "--{$mime_boundary}\n" . "Content-Type: text/html; charset=\"UTF-8\"\n" .
"Content-Transfer-Encoding: 7bit\n\n" . $htmlContent . "\n\n"; 
      
$message .= "--{$mime_boundary}--";
$returnpath = "-f"."noreply@ct.co.za";


$mail = @mail($to, $email_subject, $message, $headers, $returnpath)
    
?>
    <script>
        Snackbar.show({
            text: 'User has been added successfully and an email has been sent to user to verify account.',
            pos: 'top-right',
            actionTextColor: '#fff',
            backgroundColor: '#33691E'
        });

    </script>
    <?php
}else{
	?>
    <script>
        Snackbar.show({
            text: 'There was an issue while trying to register user. Please try again later.',
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
            text: 'User already exists.',
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
            text: 'Passwords do not match.',
            pos: 'top-right',
            actionTextColor: '#fff',
            backgroundColor: '#B71C1C'
        });

    </script>
    <?php
}
}

if(isset($_POST['changeRole'])){
    
require_once('connect.php');
    
$UserType = mysqli_real_escape_string($con,$_POST['userType']);
$UserID = $_GET['ds4fsdf5sf'];
    
    
if(mysqli_query($con,"UPDATE `users` SET `UserType` = '$UserType'  WHERE `UserID` = '$UserID'")){
    
    ?>
    <script>
        Snackbar.show({
            text: 'User Type was changed successfully.',
            pos: 'top-right',
            actionTextColor: '#fff',
            backgroundColor: '#33691E'
        });

    </script>
    <?php
}else{
      
    ?>
    <script>
        Snackbar.show({
            text: 'Something went wrong while trying to change user type. Please try again later.',
            pos: 'top-right',
            actionTextColor: '#fff',
            backgroundColor: '#B71C1C'
        });

    </script>
    <?php
}
    
}
    
if(isset($_POST['enabling'])){
       
$UserID = $_GET['ds4fsdf5sf'];
    
require_once('connect.php');
    
if(mysqli_query($con,"UPDATE `users` SET `Active` = 'Yes'  WHERE `UserID` = '$UserID'")){
    
    ?>
    <script>
        Snackbar.show({
            text: 'User was enabled successfully.',
            pos: 'top-right',
            actionTextColor: '#fff',
            backgroundColor: '#33691E'
        });

    </script>
    <?php
}else{
      
    ?>
    <script>
        Snackbar.show({
            text: 'Something went wrong while trying to enable user. Please try again later.',
            pos: 'top-right',
            actionTextColor: '#fff',
            backgroundColor: '#B71C1C'
        });

    </script>
    <?php
}
    
}
    
if(isset($_POST['disabling'])){
       
$UserID = $_GET['ds4fsdf5sf'];
    
require_once('connect.php');
    
if(mysqli_query($con,"UPDATE `users` SET `Active` = 'No'  WHERE `UserID` = '$UserID'")){
    
    ?>
    <script>
        Snackbar.show({
            text: 'User was disabled successfully.',
            pos: 'top-right',
            actionTextColor: '#fff',
            backgroundColor: '#33691E'
        });

    </script>
    <?php
}else{
      
    ?>
    <script>
        Snackbar.show({
            text: 'Something went wrong while trying to disable user. Please try again later.',
            pos: 'top-right',
            actionTextColor: '#fff',
            backgroundColor: '#B71C1C'
        });

    </script>
    <?php
}
    
}
    
require_once('connect.php');
    
$UserIDSession = $_SESSION['UserID'];
    

$result = mysqli_query($con,"SELECT * FROM `users` WHERE `UserID` = '$UserIDSession'");
       
$res = mysqli_fetch_array($result);
?>

    <!--  BEGIN NAVBAR  -->
    <div class="header-container fixed-top">
        <header class="header navbar navbar-expand-sm expand-header">

            <ul class="navbar-item flex-row ml-auto">

                <li class="nav-item dropdown user-profile-dropdown  order-lg-0 order-1">
                    <a href="javascript:void(0);" class="nav-link dropdown-toggle user" id="userProfileDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user-check">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                            <circle cx="8.5" cy="7" r="4"></circle>
                            <polyline points="17 11 19 13 23 9"></polyline>
                        </svg>
                    </a>
                    <div class="dropdown-menu position-absolute e-animated e-fadeInUp" aria-labelledby="userProfileDropdown">
                        <div class="user-profile-section">
                            <div class="media mx-auto">
                                <img src="assets/img/avatar.jpg" class="img-fluid mr-2" alt="avatar">
                                <div class="media-body">
                                    <h5><?php echo $res['FirstName'].' '.$res['LastName']; ?></h5>
                                    <p><?php echo $res['UserType']; ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="dropdown-item">
                            <a href="profile?pg=admin">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg> <span>My Profile</span>
                            </a>
                        </div>
                        <div class="dropdown-item">
                            <a href="#" data-toggle="modal" data-target="#PasswordModal">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-git-pull-request">
                                    <circle cx="18" cy="18" r="3"></circle>
                                    <circle cx="6" cy="6" r="3"></circle>
                                    <path d="M13 6h3a2 2 0 0 1 2 2v7"></path>
                                    <line x1="6" y1="9" x2="6" y2="21"></line>
                                </svg>
                                <span>Change Password</span>
                            </a>
                        </div>
                        <div class="dropdown-item">
                            <a href="lockscreen?pg=admin">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock">
                                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                    <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                </svg> <span>Lock Screen</span>
                            </a>
                        </div>
                        <div class="dropdown-item">
                            <a href="logout">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-log-out">
                                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                    <polyline points="16 17 21 12 16 7"></polyline>
                                    <line x1="21" y1="12" x2="9" y2="12"></line>
                                </svg> <span>Log Out</span>
                            </a>
                        </div>
                    </div>
                </li>
            </ul>
        </header>
    </div>
    <!--  END NAVBAR  -->

    <!--  BEGIN MAIN CONTAINER  -->
    <div class="main-container sidebar-closed " id="container">

        <!-- Modal -->
        <div class="modal fade" id="addTaskModal" tabindex="-1" role="dialog" aria-labelledby="addTaskModalTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered " role="document">
                <form class="modal-content" action="admin" method="POST">
                    <div class="modal-body">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="modal">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                        <div class="compose-box">
                            <div class="compose-content" id="addTaskModalTitle">
                                <h5 class="">Creating User</h5>
                                <div class="form">

                                    <div class="form-group mb-3">
                                        <label for="password">First Name</label>
                                        <input class="form-control" name="FirstName" <?php if(isset($_POST['register'])){ echo 'value="'.$_POST['FirstName'].'"';} ?> required type="text" id="FirstName" placeholder="First Name">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="LastName">Last Name</label>
                                        <input class="form-control" <?php if(isset($_POST['register'])){ echo 'value="'.$_POST['LastName'].'"';} ?> name="LastName" required type="text" id="LastName" placeholder="LastName">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="emailaddress">Email Address</label>
                                        <input class="form-control" type="email" <?php if(isset($_POST['register'])){ echo 'value="'.$_POST['emailAddress'].'"';} ?> id="emailaddress" name="emailAddress" required="" placeholder="Email address">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="password">Password</label>
                                        <input class="form-control" type="text" <?php if(isset($_POST['register'])){ echo 'value="'.$_POST['password'].'"';} ?>id="password" name="password" required="" placeholder="Password">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="confirmPassword">Confirm Password</label>
                                        <input class="form-control" type="text" <?php if(isset($_POST['register'])){ echo 'value="'.$_POST['confirmPassword'].'"';} ?> id="confirmPassword" name="confirmPassword" required="" placeholder="Confirm Password">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="userType">User Type</label>
                                        <select name="userType" required class="form-control" id="UserType">
                                            <option selected value="Admin">Admin</option>
                                            <option value="Delegate">Delegate</option>
                                            <option value="Personel">Personnel</option>
                                        </select>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="contactNumber">Contact Number</label>
                                        <input class="form-control" type="text" <?php if(isset($_POST['register'])){ echo 'value="'.$_POST['contactNumber'].'"';} ?> id="contactNumber" name="contactNumber" required="" placeholder="Contact Number">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="Address">Physical Address</label>
                                        <input class="form-control" type="text" id="Address" <?php if(isset($_POST['register'])){ echo 'value="'.$_POST['physicalAddress'].'"';} ?> name="physicalAddress" required="" placeholder="Physical address">
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn" data-dismiss="modal">Cancel</button>
                        <button name="register" type="submit" class="btn AddComplaint btn-outline-warning">Add User</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Approve modal -->
        <div id="PasswordModal" style="z-index: 10000" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form action="citizen" method="POST" class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="myModalLabel">Password Change</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <h5 class="font-16">
                            Please enter and confirm your password
                        </h5>
                        <div id="username-field" class="field-wrapper input">
                            <label for="Password">Password</label>
                            <input id="Password" required name="Password" type="text" class="form-control" placeholder="Enter Password">
                        </div>
                        <div id="username-field" class="field-wrapper input mt-3">
                            <label for="ConfirmPassword">Confirm Password</label>
                            <input id="ConfirmPassword" required name="ConfirmPassword" type="text" class="form-control" placeholder="Confirm Password">
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-muted waves-effect btn-lg" data-dismiss="modal">Cancel</button>
                        <button name="PasswordBtn" type="submit" class="btn btn-outline-success waves-effect btn-lg waves-light">Save</button>
                    </div>
                </form><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

        <div class="overlay"></div>
        <div class="cs-overlay"></div>
        <div class="search-overlay"></div>

        <!--  BEGIN CONTENT AREA  -->
        <div id="content" class="main-content">
            <div class="layout-px-spacing">

                <div class="row layout-top-spacing">
                    <div class="col-xl-12 col-lg-12 col-md-12">

                        <div class="mail-box-container">
                            <div class="mail-overlay"></div>

                            <div class="tab-title">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-12 text-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clipboard">
                                            <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path>
                                            <rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect>
                                        </svg>
                                        <h5 class="app-title">Users</h5>
                                    </div>

                                    <div class="todoList-sidebar-scroll">
                                        <div class="col-md-12 col-sm-12 col-12 mt-4 pl-0">
                                            <ul class="nav nav-pills d-block" id="pills-tab" role="tablist">
                                                <li class="nav-item">
                                                    <a class="nav-link list-actions active" id="all-list" data-toggle="pill" href="#pills-inbox" role="tab" aria-selected="true"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-list">
                                                            <line x1="8" y1="6" x2="21" y2="6"></line>
                                                            <line x1="8" y1="12" x2="21" y2="12"></line>
                                                            <line x1="8" y1="18" x2="21" y2="18"></line>
                                                            <line x1="3" y1="6" x2="3" y2="6"></line>
                                                            <line x1="3" y1="12" x2="3" y2="12"></line>
                                                            <line x1="3" y1="18" x2="3" y2="18"></line>
                                                        </svg> All <span class="todo-badge badge"></span>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link list-actions" id="todo-task-important" data-toggle="pill" href="#pills-important" role="tab" aria-selected="false">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-smile">
                                                            <circle cx="12" cy="12" r="10"></circle>
                                                            <path d="M8 14s1.5 2 4 2 4-2 4-2"></path>
                                                            <line x1="9" y1="9" x2="9.01" y2="9"></line>
                                                            <line x1="15" y1="9" x2="15.01" y2="9"></line>
                                                        </svg> Citizens <span class="todo-badge badge"></span></a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link list-actions" id="todo-task-done" data-toggle="pill" href="#pills-sentmail" role="tab" aria-selected="false">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-star">
                                                            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                                        </svg> Delegates <span class="todo-badge badge"></span>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link list-actions" id="todo-task-trash" data-toggle="pill" href="#pills-trash" role="tab" aria-selected="false">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-star">
                                                            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                                        </svg> Personel/Admin
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                    <a class="btn" id="addTask" href="#"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus">
                                            <line x1="12" y1="5" x2="12" y2="19"></line>
                                            <line x1="5" y1="12" x2="19" y2="12"></line>
                                        </svg> User
                                    </a>
                                </div>
                            </div>

                            <div id="todo-inbox" class="accordion todo-inbox">
                                <div class="search">
                                    <input type="text" class="form-control input-search" placeholder="Search Here...">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-menu mail-menu d-lg-none">
                                        <line x1="3" y1="12" x2="21" y2="12"></line>
                                        <line x1="3" y1="6" x2="21" y2="6"></line>
                                        <line x1="3" y1="18" x2="21" y2="18"></line>
                                    </svg>
                                </div>

                                <div class="todo-box">

                                    <div id="ct" class="todo-box-scroll">
                                        <?php
                                            
                                            require_once('connect.php');
                                        
                                            $UserID = $_SESSION['UserID'];
    
                                            $result = mysqli_query($con,"SELECT * FROM `users` WHERE `UserType` = 'Citizen' ORDER BY `id` DESC");
                                            $resultCompleted = mysqli_query($con,"SELECT * FROM `users` WHERE `UserType` = 'Delegate'  ORDER BY `id` DESC");
                                            $resultDeclined = mysqli_query($con,"SELECT * FROM `users` WHERE `UserType` = 'Personel' OR `UserType` = 'Admin' ORDER BY `id` DESC");
    
                                            while($res = mysqli_fetch_array($result)){
                                                
                                        ?>
                                        <div class="todo-item all-list todo-task-important ml-3">
                                            <div class="todo-item-inner">
                                                <div class="todo-content">
                                                    <h5 class="todo-heading" data-todoHeading="<?php echo 'Complaint Number: '.$res['id'].' - '.$res['ComplaintType'].' By '.$resUser['FirstName'].' '.$resUser['LastName']; ?>  "><?php echo $res['FirstName'].' '.$res['LastName']; ?> </h5>
                                                    <p class="meta-date"><?php if($res['UserConfirmed'] == "Yes"){ echo '<span class="text-success">Verified</span>'; }else{  echo '<span class="text-danger">Not Verified</span>'; }if($res['Active'] == "Yes"){  echo ' - <span class="text-success">Enabled</span>'; }else{  echo ' - <span class="text-danger">Disabled</span>'; }?></p>
                                                    <p class="todo-text mt-2" data-todoHtml="<p><span class='badge outline-badge-warning'><?php echo $res['ComplaintStatus']; ?></span> - <?php echo $res['Complaint']; ?></p>" data-todoText='{"ops":[{"insert":"<span class="badge outline-badge-warning"><?php echo $res['ComplaintStatus']; ?></span> - <?php echo $res['Complaint']; ?>.\n"}]}'><span class="badge outline-badge-warning"><?php echo $res['UserType']; ?></span> - <?php echo $res['Address']; ?>.</p>
                                                </div>
                                                <div class="action-dropdown custom-dropdown-icon">
                                                    <div class="dropdown">
                                                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink-2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical">
                                                                <circle cx="12" cy="12" r="1"></circle>
                                                                <circle cx="12" cy="5" r="1"></circle>
                                                                <circle cx="12" cy="19" r="1"></circle>
                                                            </svg>
                                                        </a>

                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink-2">
                                                            <a class="edit dropdown-item" data-toggle="modal" data-target="#RoleChangeModal<?php echo $res['id']; ?>" href="javascript:void(0);">Change User Type</a>
                                                            <a class="edit dropdown-item" data-toggle="modal" data-target="#disablingModal<?php echo $res['id']; ?>" href="javascript:void(0);"><?php if($res['Active'] == "Yes"){ echo "Disable User"; }else{ echo "Enable User"; } ?></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <!-- Modal -->
                                        <div class="modal fade" id="RoleChangeModal<?php echo $res['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="addTaskModalTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered " role="document">
                                                <form class="modal-content" action="admin?ds4fsdf5sf=<?php echo $res['UserID']; ?>" method="POST">
                                                    <div class="modal-body">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="modal">
                                                            <line x1="18" y1="6" x2="6" y2="18"></line>
                                                            <line x1="6" y1="6" x2="18" y2="18"></line>
                                                        </svg>
                                                        <div class="compose-box">
                                                            <div class="compose-content" id="addTaskModalTitle">
                                                                <h5 class="">Changing <?php echo $res['FirstName'].' '.$res['LastName']; ?>'s User Type</h5>
                                                                <div class="form">
                                                                    <div class="form-group mb-3">
                                                                        <label for="userType">User Type</label>
                                                                        <select name="userType" required class="form-control" id="UserType">
                                                                            <option selected value="Admin">Admin</option>
                                                                            <option value="Delegate">Delegate</option>
                                                                            <option value="Personel">Personnel</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button class="btn" data-dismiss="modal">Cancel</button>
                                                        <button name="changeRole" type="submit" class="btn AddComplaint btn-outline-warning">Change Role</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <!-- Modal -->
                                        <div class="modal fade" id="disablingModal<?php echo $res['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="addTaskModalTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered " role="document">
                                                <form class="modal-content" action="admin?ds4fsdf5sf=<?php echo $res['UserID']; ?>" method="POST">
                                                    <div class="modal-body">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="modal">
                                                            <line x1="18" y1="6" x2="6" y2="18"></line>
                                                            <line x1="6" y1="6" x2="18" y2="18"></line>
                                                        </svg>
                                                        <div class="compose-box">
                                                            <div class="compose-content" id="addTaskModalTitle">
                                                                <h5 class="">Are you sure you want to disable <?php echo $res['FirstName'].' '.$res['LastName']; ?> ?</h5>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button class="btn" data-dismiss="modal">Cancel</button>
                                                        <button name="<?php if($res['Active'] == "Yes"){ echo "disabling"; }else{ echo "enabling"; } ?>" type="submit" class="btn AddComplaint btn-outline-warning"><?php if($res['Active'] == "Yes"){ echo "Disable User"; }else{ echo "Enable User"; } ?></button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <?php }
                                        
                                            while($res = mysqli_fetch_array($resultCompleted)){
                                                
                                        ?>
                                        <div class="todo-item all-list todo-task-done ml-3">
                                            <div class="todo-item-inner">
                                                <div class="todo-content">
                                                    <h5 class="todo-heading" data-todoHeading="<?php echo 'Complaint Number: '.$res['id'].' - '.$res['ComplaintType'].' By '.$resUser['FirstName'].' '.$resUser['LastName']; ?>  "><?php echo $res['FirstName'].' '.$res['LastName']; ?> </h5>
                                                    <p class="meta-date"><?php if($res['UserConfirmed'] == "Yes"){ echo '<span class="text-success">Verified</span>'; }else{  echo '<span class="text-danger">Not Verified</span>'; }if($res['Active'] == "Yes"){  echo ' - <span class="text-success">Enabled</span>'; }else{  echo ' - <span class="text-danger">Disabled</span>'; }?></p>
                                                    <p class="todo-text mt-2" data-todoHtml="<p><span class='badge outline-badge-info'><?php echo $res['ComplaintStatus']; ?></span> - <?php echo $res['Complaint']; ?></p>" data-todoText='{"ops":[{"insert":"<span class="badge outline-badge-warning"><?php echo $res['ComplaintStatus']; ?></span> - <?php echo $res['Complaint']; ?>.\n"}]}'><span class="badge outline-badge-info"><?php echo $res['UserType']; ?></span> - <?php echo $res['Address']; ?>.</p>
                                                </div>
                                                <div class="action-dropdown custom-dropdown-icon">
                                                    <div class="dropdown">
                                                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink-2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical">
                                                                <circle cx="12" cy="12" r="1"></circle>
                                                                <circle cx="12" cy="5" r="1"></circle>
                                                                <circle cx="12" cy="19" r="1"></circle>
                                                            </svg>
                                                        </a>

                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink-2">
                                                            <a class="edit dropdown-item" data-toggle="modal" data-target="#RoleChangeModal<?php echo $res['id']; ?>" href="javascript:void(0);">Change User Type</a>
                                                            <a class="edit dropdown-item" data-toggle="modal" data-target="#disablingModal<?php echo $res['id']; ?>" href="javascript:void(0);"><?php if($res['Active'] == "Yes"){ echo "Disable User"; }else{ echo "Enable User"; } ?></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <!-- Modal -->
                                        <div class="modal fade" id="RoleChangeModal<?php echo $res['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="addTaskModalTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered " role="document">
                                                <form class="modal-content" action="admin?ds4fsdf5sf=<?php echo $res['UserID']; ?>" method="POST">
                                                    <div class="modal-body">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="modal">
                                                            <line x1="18" y1="6" x2="6" y2="18"></line>
                                                            <line x1="6" y1="6" x2="18" y2="18"></line>
                                                        </svg>
                                                        <div class="compose-box">
                                                            <div class="compose-content" id="addTaskModalTitle">
                                                                <h5 class="">Changing <?php echo $res['FirstName'].' '.$res['LastName']; ?>'s User Type</h5>
                                                                <div class="form">
                                                                    <div class="form-group mb-3">
                                                                        <label for="userType">User Type</label>
                                                                        <select name="userType" required class="form-control" id="UserType">
                                                                            <option selected value="Admin">Admin</option>
                                                                            <option value="Delegate">Delegate</option>
                                                                            <option value="Personel">Personnel</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button class="btn" data-dismiss="modal">Cancel</button>
                                                        <button name="changeRole" type="submit" class="btn AddComplaint btn-outline-warning">Change Role</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <!-- Modal -->
                                        <div class="modal fade" id="disablingModal<?php echo $res['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="addTaskModalTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered " role="document">
                                                <form class="modal-content" action="admin?ds4fsdf5sf=<?php echo $res['UserID']; ?>" method="POST">
                                                    <div class="modal-body">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="modal">
                                                            <line x1="18" y1="6" x2="6" y2="18"></line>
                                                            <line x1="6" y1="6" x2="18" y2="18"></line>
                                                        </svg>
                                                        <div class="compose-box">
                                                            <div class="compose-content" id="addTaskModalTitle">
                                                                <h5 class="">Are you sure you want to disable <?php echo $res['FirstName'].' '.$res['LastName']; ?> ?</h5>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button class="btn" data-dismiss="modal">Cancel</button>
                                                        <button name="<?php if($res['Active'] == "Yes"){ echo "disabling"; }else{ echo "enabling"; } ?>" type="submit" class="btn AddComplaint btn-outline-warning"><?php if($res['Active'] == "Yes"){ echo "Disable User"; }else{ echo "Enable User"; } ?></button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>

                                        <?php } 
                                            while($res = mysqli_fetch_array($resultDeclined)){
                                        ?>
                                        <div class="todo-item all-list todo-task-trash ml-3">
                                            <div class="todo-item-inner">
                                                <div class="todo-content">
                                                    <h5 class="todo-heading" data-todoHeading="<?php echo 'Complaint Number: '.$res['id'].' - '.$res['ComplaintType'].' By '.$resUser['FirstName'].' '.$resUser['LastName']; ?>  "><?php echo $res['FirstName'].' '.$res['LastName']; ?> </h5>
                                                    <p class="meta-date"><?php if($res['UserConfirmed'] == "Yes"){ echo '<span class="text-success">Verified</span>'; }else{  echo '<span class="text-danger">Not Verified</span>'; }if($res['Active'] == "Yes"){  echo ' - <span class="text-success">Enabled</span>'; }else{  echo ' - <span class="text-danger">Disabled</span>'; }?></p>
                                                    <p class="todo-text mt-2" data-todoHtml="<p><span class='badge outline-badge-success'><?php echo $res['ComplaintStatus']; ?></span> - <?php echo $res['Complaint']; ?></p>" data-todoText='{"ops":[{"insert":"<span class="badge outline-badge-warning"><?php echo $res['ComplaintStatus']; ?></span> - <?php echo $res['Complaint']; ?>.\n"}]}'><span class="badge outline-badge-success"><?php echo $res['UserType']; ?></span> - <?php echo $res['Address']; ?>.</p>
                                                </div>
                                                <div class="action-dropdown custom-dropdown-icon">
                                                    <div class="dropdown">
                                                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink-2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical">
                                                                <circle cx="12" cy="12" r="1"></circle>
                                                                <circle cx="12" cy="5" r="1"></circle>
                                                                <circle cx="12" cy="19" r="1"></circle>
                                                            </svg>
                                                        </a>

                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink-2">
                                                            <a class=" dropdown-item" data-toggle="modal" data-target="#RoleChangeModal<?php echo $res['id']; ?>">Change User Type</a>
                                                            <a class=" dropdown-item" data-toggle="modal" data-target="#disablingModal<?php echo $res['id']; ?>"><?php if($res['Active'] == "Yes"){ echo "Disable User"; }else{ echo "Enable User"; } ?></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <!-- Modal -->
                                        <div class="modal fade" id="RoleChangeModal<?php echo $res['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="addTaskModalTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered " role="document">
                                                <form class="modal-content" action="admin?ds4fsdf5sf=<?php echo $res['UserID']; ?>" method="POST">
                                                    <div class="modal-body">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="modal">
                                                            <line x1="18" y1="6" x2="6" y2="18"></line>
                                                            <line x1="6" y1="6" x2="18" y2="18"></line>
                                                        </svg>
                                                        <div class="compose-box">
                                                            <div class="compose-content" id="addTaskModalTitle">
                                                                <h5 class="">Changing <?php echo $res['FirstName'].' '.$res['LastName']; ?>'s User Type</h5>
                                                                <div class="form">
                                                                    <div class="form-group mb-3">
                                                                        <label for="userType">User Type</label>
                                                                        <select name="userType" required class="form-control" id="UserType">
                                                                            <option selected value="Admin">Admin</option>
                                                                            <option value="Delegate">Delegate</option>
                                                                            <option value="Personel">Personnel</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button class="btn" data-dismiss="modal">Cancel</button>
                                                        <button name="changeRole" type="submit" class="btn AddComplaint btn-outline-warning">Change Role</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <!-- Modal -->
                                        <div class="modal fade" id="disablingModal<?php echo $res['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="addTaskModalTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered " role="document">
                                                <form class="modal-content" action="admin?ds4fsdf5sf=<?php echo $res['UserID']; ?>" method="POST">
                                                    <div class="modal-body">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="modal">
                                                            <line x1="18" y1="6" x2="6" y2="18"></line>
                                                            <line x1="6" y1="6" x2="18" y2="18"></line>
                                                        </svg>
                                                        <div class="compose-box">
                                                            <div class="compose-content" id="addTaskModalTitle">
                                                                <h5 class="">Are you sure you want to <?php if($res['Active'] == "Yes"){ echo "disable"; }else{ echo "enable"; } ?> <?php echo $res['FirstName'].' '.$res['LastName']; ?> ?</h5>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button class="btn" data-dismiss="modal">Cancel</button>
                                                        <button name="<?php if($res['Active'] == "Yes"){ echo "disabling"; }else{ echo "enabling"; } ?>" type="submit" class="btn AddComplaint btn-outline-warning"> <?php if($res['Active'] == "Yes"){ echo "Disable User"; }else{ echo "Enable User"; } ?></button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>

                                        <?php  } ?>

                                        <div class="modal fade" id="todoShowListItem" tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered " role="document">
                                                <div class="modal-content">
                                                    <div class="modal-body">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="modal">
                                                            <line x1="18" y1="6" x2="6" y2="18"></line>
                                                            <line x1="6" y1="6" x2="18" y2="18"></line>
                                                        </svg>
                                                        <div class="compose-box">
                                                            <div class="compose-content">
                                                                <h5 class="task-heading"></h5>
                                                                <p class="task-text"></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
            <!--  END CONTENT AREA  -->
        </div>
    </div>
    <!-- END MAIN CONTAINER -->

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <script src="assets/js/libs/jquery-3.1.1.min.js"></script>
    <script src="bootstrap/js/popper.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="assets/js/app.js"></script>
    <script src="plugins/highlight/highlight.pack.js"></script>
    <script src="assets/js/custom.js"></script>

    <script>
        $(document).ready(function() {
            App.init();
        });

    </script>
    <script src="assets/js/custom.js"></script>
    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- toastr -->
    <script src="plugins/notification/snackbar/snackbar.min.js"></script>

    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <script src="assets/js/ie11fix/fn.fix-padStart.js"></script>
    <script src="plugins/editors/quill/quill.js"></script>
    <script src="assets/js/apps/todoList.js"></script>

</body>

</html>
