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
    <!-- END GLOBAL MANDATORY STYLES -->

    <!--  BEGIN CUSTOM STYLE FILE  -->
    <!-- toastr -->
    <link href="plugins/notification/snackbar/snackbar.min.css" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->
    <link href="assets/css/components/custom-modal.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/components/timeline/custom-timeline.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="plugins/editors/quill/quill.snow.css">
    <link href="assets/css/apps/todolist.css" rel="stylesheet" type="text/css" />
    <!--  END CUSTOM STYLE FILE  -->
</head>

<body class="alt-menu">
    <!-- toastr -->
    <script src="plugins/notification/snackbar/snackbar.min.js"></script>

    <?php

ini_set('display_errors', 1); 
ini_set('display_startup_errors', 1); 
error_reporting(E_ALL);
    
require_once('connect.php');

if(isset($_POST['save'])){
    
$UserID = $_SESSION['UserID'];
    
$FirstName = mysqli_real_escape_string($con,$_POST['FirstName']);
$LastName = mysqli_real_escape_string($con,$_POST['LastName']);
$EmailAddress = mysqli_real_escape_string($con,$_POST['EmailAddress']);
$ContactNumber = mysqli_real_escape_string($con,$_POST['ContactNumber']);
$PhysicalAddress = mysqli_real_escape_string($con,$_POST['PhysicalAddress']);
    
    if(mysqli_query($con,"UPDATE `users` SET `FirstName` = '$FirstName', `LastName` = '$LastName', `EmailAddress` = '$EmailAddress', `Address` = '$PhysicalAddress', `ContactNumber` = '$ContactNumber' WHERE `UserID` = '$UserID'")){
        ?>
    <script>
        Snackbar.show({
            text: 'Details were updated successfully.',
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
            text: 'Something went wrong while updating your details. Please try again later.',
            pos: 'top-right',
            actionTextColor: '#fff',
            backgroundColor: '#B71C1C'
        });

    </script>
    <?php
    }
}
$UserIDSession = $_SESSION['UserID'];

$result = mysqli_query($con,"SELECT * FROM `users` WHERE `UserID` = '$UserIDSession'");

$res = mysqli_fetch_array($result);
?>

    <!--  BEGIN NAVBAR  -->
    <div class="header-container fixed-top">
        <header class="header navbar navbar-expand-sm expand-header">

            <a href="<?php echo $_GET['pg']; ?>" class="btn btn-sm btn-outline-warning ml-2 float-left">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left">
                    <line x1="19" y1="12" x2="5" y2="12"></line>
                    <polyline points="12 19 5 12 12 5"></polyline>
                </svg>
            </a>
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
                            <a href="profile">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg> <span>My Profile</span>
                            </a>
                        </div>
                        <div class="dropdown-item">
                            <a href="lockscreen">
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

        <div class="overlay"></div>
        <div class="cs-overlay"></div>
        <div class="search-overlay"></div>
        <?php
        
            $resultCountofComplaints = mysqli_query($con,"SELECT COUNT(id) AS Total FROM `complaints` WHERE `LoggerID` = '$UserIDSession'");
            $resCountofComplaints = mysqli_fetch_array($resultCountofComplaints);
        
        ?>
        <!--  BEGIN CONTENT AREA  -->
        <div id="content" class="main-content">
            <div class="layout-spacing ml-0 row">
                <div class="card pb-5 mb-3 pt-2 col-6">
                    <div class="card-body row m-0">
                        <img src="assets/img/avatar.jpg" height="130px" class="col-3" alt="...">
                        <div class="user-info col-8 m-0">
                            <h5 class="card-user_name"><?php echo $res['FirstName'].' '.$res['LastName']; ?></h5>
                            <p class="card-user_occupation"><?php echo $res['UserType']; ?></p>
                            <div class="card-star_rating">
                                <span class="badge badge-primary"><?php echo $resCountofComplaints['Total']; ?></span>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="timeline-alter">
                        <?php
        
                            $resultComplaints = mysqli_query($con,"SELECT * FROM `complaints` WHERE `LoggerID` = '$UserIDSession'");
                           
                            while($resComplaints = mysqli_fetch_array($resultComplaints)){
        
                        ?>
                        <div class="item-timeline">
                            <div class="t-time">
                                <p class=""><?php echo $resComplaints['Time']; ?></p>
                            </div>
                            <div class="t-img">
                                <img src="assets/img/avatar.jpg">
                            </div>
                            <div class="t-meta-time">
                                <p class=""><?php echo $resComplaints['Date']; ?></p>
                            </div>

                            <div class="t-text">
                                <p><?php echo $resComplaints['ComplaintType']; ?>.</p>
                            </div>
                        </div>
                        <?php
                                }
                        ?>
                    </div>
                </div>
                <div class=" card ml-3 mb-3 pb-3 col-5">
                    <div class="form-form widget-content-area">
                        <div class="form-form-wrap">
                            <div class="form-container">
                                <div class="form-content">
                                    <div class="text-center mt-4">
                                        <h1 class="">Profile</h1>
                                        <p class="text-warning"> <strong>Remember to save your changes before you leave the page.</strong></p>
                                    </div>
                                    <form class="text-left" action="profile?pg=<?php echo $_GET['pg']; ?>" method="POST">
                                        <div class="form mt-4">
                                            <div id="username-field" class="field-wrapper input">
                                                <label for="FirstName">First Name</label>
                                                <input id="FirstName" value="<?php echo $res['FirstName']; ?>" required name="FirstName" type="text" class="form-control" placeholder="Enter First Name">
                                            </div>
                                            <div id="username-field" class="field-wrapper input mt-3">
                                                <label for="LastName">Last Name</label>
                                                <input id="LastName" value="<?php echo $res['LastName']; ?>" required name="LastName" type="text" class="form-control" placeholder="Enter Last Name">
                                            </div>
                                            <div id="username-field" class="field-wrapper input mt-3">
                                                <label for="EmailAddress">Email Address</label>
                                                <input id="EmailAddress" value="<?php echo $res['EmailAddress']; ?>" required name="EmailAddress" type="text" class="form-control" placeholder="Enter Email Address">
                                            </div>
                                            <div id="username-field" class="field-wrapper input mt-3">
                                                <label for="PhysicalAddress">Physical Address</label>
                                                <input id="PhysicalAddress" value="<?php echo $res['Address']; ?>" required name="PhysicalAddress" type="text" class="form-control" placeholder="Enter Physical Address">
                                            </div>
                                            <div id="username-field" class="field-wrapper input mt-3">
                                                <label for="ContactNumber">Contact Number</label>
                                                <input id="ContactNumber" value="<?php echo $res['ContactNumber']; ?>" required name="ContactNumber" type="text" class="form-control" placeholder="Enter Contact Number">
                                            </div>
                                            <p class="text-warning mt-3 mb-3"> <strong>Remember to save your changes before you leave the page.</strong></p>
                                            <div class="d-sm-flex justify-content-between mt-3 float-right">
                                                <div class="field-wrapper">
                                                    <button name="save" type="submit" class="btn btn-outline-warning ">Save Changes</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>

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
    <script src="plugins/highlight/highlight.pack.js"></script>
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
