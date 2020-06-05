<?php session_start();

if($_SESSION['UserIDLocked'] == "locked"){
    header("Location:lockscreen?pg=delegate");
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

ini_set('display_errors', 1); 
ini_set('display_startup_errors', 1); 
error_reporting(E_ALL);

if(isset($_POST['AddComplaint'])){
	
require_once('connect.php');
    
$FirstName = mysqli_real_escape_string($con,$_POST['FirstName']);
$LastName = mysqli_real_escape_string($con,$_POST['LastName']);
$EmailAddress = mysqli_real_escape_string($con,$_POST['emailAddress']);
$ContactNumber = mysqli_real_escape_string($con,$_POST['contactNumber']);
$PhysicalAddress = mysqli_real_escape_string($con,$_POST['physicalAddress']);
$ComplaintType = mysqli_real_escape_string($con,$_POST['complaintType']);
$complaint = mysqli_real_escape_string($con,$_POST['complaint']);
    
$uniqComplaint = uniqid();
$ComplaintID = md5($uniqComplaint);  
    
$uniqCommentID = uniqid();
$CommentID = md5($uniqCommentID);    
    
$uniqUser = uniqid();
$UserID = md5($uniqUser);    
    
$time = time();
$actual_date = date('Y-m-d', $time);
$actual_time = date('H:i',$time);
	
$result = mysqli_query($con,"SELECT * FROM `users` WHERE `EmailAddress` = '$EmailAddress' AND `FirstName` = '$FirstName' AND `LastName` = '$LastName'");
    
if(!mysqli_num_rows($result)){

if(mysqli_query($con,"INSERT INTO `users` (`UserID`,  `FirstName`,   `LastName`, `EmailAddress`, `Address`, `UserType`, `ContactNumber`) VALUES ('$UserID','$FirstName','$LastName','$EmailAddress','$PhysicalAddress','Client','$ContactNumber')")){
    
if(mysqli_query($con,"INSERT INTO `complaints` (`ComplaintID`,  `Complaint`,   `ComplaintType`, `LoggerID`, `Date`, `Time`) VALUES ('$ComplaintID','$complaint','$ComplaintType','$UserID','$actual_date','$actual_time')")){
    
    if(mysqli_query($con,"INSERT INTO `feedback` (`ComplaintID`,  `CommentID`, `Comment`,  `CommentType`, `UserID`, `Date`, `Time`) 
    VALUES ('$ComplaintID','$CommentID','$complaint','Log','$UserID','$actual_date','$actual_time')")){
	// Create the email and send the message
$to = $EmailAddress; 
$email_subject = "Complaint Tracker Registration.";
$htmlContent = '
    <table class="body-wrap" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; background-color: #f6f6f6; margin: 0;" bgcolor="#f6f6f6">
        <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
            <td style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;" valign="top"></td>
            <td class="container" width="600" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto;" valign="top">
                <div width="100%" class="content" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; max-width: 600px; display: block; margin: 0 auto; padding: 20px;">
                    <table class="main" min-width="100%" cellpadding="0" cellspacing="0" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; display: inline-block; font-size: 14px; overflow: hidden; border-radius: 7px; background-color: #fff; margin: 0; border: 1px solid #e9e9e9;" bgcolor="#fff">
                        <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                            <td class="alert alert-warning" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 40px; vertical-align: top; color: #fff; font-weight: 500; text-align: center; border-radius: 3px 3px 0 0; background-color: #022f44; margin: 0; padding: 20px;" align="center" bgcolor="#71b6f9" valign="top">

                                <span style="margin-top: 20px;display: block;"><strong>Complaint Tracker.</strong></span>
                            </td>
                        </tr>
                        <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box;  font-size: 14px; margin: 0;">
                            <td class="content-wrap" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; border: 2px solid #022f44; font-size: 14px; vertical-align: top; margin: 0; padding: 20px;" valign="top">
                                <table width="100%" cellpadding="0" cellspacing="0" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">

                                    <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                        <td class="content-block" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; color: #33691E; padding: 0 0 20px;" valign="top">
                                           <strong> Kindly note that your complaint was logged successfully. Your complaint Number is #'.$ComplaintID.'</strong>
                                        </td>
                                    </tr>
                                    <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                        <td class="content-block" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 16px; vertical-align: top; margin: 0; padding: 0 0 20px; color: #022f44" valign="top">
                                            <strong>'.$complaint.'</strong>
    <br><br>
    <small>'.$actual_date.' '.$actual_time.'</small>
    </td>
    </tr>

    <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
        <td class="content-block" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">
            Click <a href="http://ct.thaboirvinservices.co.za/login" style="color: #022f44; text-decoration: none;">
                here
            </a> to login.
        </td>
    </tr>
    <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
        <td class="content-block" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">

        </td>
    </tr>
    <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
        <td class="content-block" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">
            Thank you for choosing <b>Complaint Tracker</b>.
        </td>
    </tr>
    </table>
    </td>
    </tr>
    </table>
    </div>
    </td>
    <td style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;" valign="top"></td>
    </tr>
    </table>
    ';
$htmlContentPersonel = '
    <table class="body-wrap" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; background-color: #f6f6f6; margin: 0;" bgcolor="#f6f6f6">
        <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
            <td style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;" valign="top"></td>
            <td class="container" width="600" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto;" valign="top">
                <div width="100%" class="content" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; max-width: 600px; display: block; margin: 0 auto; padding: 20px;">
                    <table class="main" min-width="100%" cellpadding="0" cellspacing="0" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; display: inline-block; font-size: 14px; overflow: hidden; border-radius: 7px; background-color: #fff; margin: 0; border: 1px solid #e9e9e9;" bgcolor="#fff">
                        <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                            <td class="alert alert-warning" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 40px; vertical-align: top; color: #fff; font-weight: 500; text-align: center; border-radius: 3px 3px 0 0; background-color: #022f44; margin: 0; padding: 20px;" align="center" bgcolor="#71b6f9" valign="top">

                                <span style="margin-top: 20px;display: block;"><strong>Complaint Tracker.</strong></span>
                            </td>
                        </tr>
                        <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box;  font-size: 14px; margin: 0;">
                            <td class="content-wrap" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; border: 2px solid #022f44; font-size: 14px; vertical-align: top; margin: 0; padding: 20px;" valign="top">
                                <table width="100%" cellpadding="0" cellspacing="0" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">

                                    <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                        <td class="content-block" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; color: #33691E; padding: 0 0 20px;" valign="top">
                                           <strong> Kindly note that a complaint number #'.$ComplaintID.' was logged. Login to approve or decline the complaint.</strong>
                                        </td>
                                    </tr>
                                    <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                        <td class="content-block" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 16px; vertical-align: top; margin: 0; padding: 0 0 20px; color: #022f44" valign="top">
                                            <strong>'.$complaint.'</strong>
    <br><br>
    <small>'.$actual_date.' '.$actual_time.'</small>
    </td>
    </tr>

    <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
        <td class="content-block" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">
            Click <a href="http://ct.thaboirvinservices.co.za/login" style="color: #022f44; text-decoration: none;">
                here
            </a> to login.
        </td>
    </tr>
    <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
        <td class="content-block" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">

        </td>
    </tr>
    <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
        <td class="content-block" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">
            Thank you for choosing <b>Complaint Tracker</b>.
        </td>
    </tr>
    </table>
    </td>
    </tr>
    </table>
    </div>
    </td>
    <td style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;" valign="top"></td>
    </tr>
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
        //multipart boundary
        $messagePersonel = "--{$mime_boundary}\n" . "Content-Type: text/html; charset=\"UTF-8\"\n" .
        "Content-Transfer-Encoding: 7bit\n\n" . $htmlContentPersonel . "\n\n";

        $message .= "--{$mime_boundary}--";
        $messagePersonel .= "--{$mime_boundary}--";
        $returnpath = "-f"."noreply@ct.co.za";


        $mail = @mail($to, $email_subject, $message, $headers, $returnpath);
        $mail = @mail("personel@thaboirvinservices.co.za", $email_subject, $messagePersonel, $headers, $returnpath);

        ?>
    <script>
        Snackbar.show({
            text: 'Complaint has been successfully logged.',
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
            text: 'There was an issue while trying to add a comment to your complaint. Please try again later.',
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
            text: 'There was an issue while trying to log your complaint. Please try again later.',
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
            text: 'There was an issue while trying to save customer details. Please try again later.',
            pos: 'top-right',
            actionTextColor: '#fff',
            backgroundColor: '#B71C1C'
        });

    </script>
    <?php
}
}else{
    $res = mysqli_fetch_array($result);
    $UserID = $res['UserID'];

if(mysqli_query($con,"UPDATE `users` SET `Address` = '$PhysicalAddress', `ContactNumber` = '$ContactNumber' WHERE `UserID` = '$UserID'")){
    
if(mysqli_query($con,"INSERT INTO `complaints` (`ComplaintID`,  `Complaint`,   `ComplaintType`, `LoggerID`, `Date`, `Time`) VALUES ('$ComplaintID','$complaint','$ComplaintType','$UserID','$actual_date','$actual_time')")){
    
    if(mysqli_query($con,"INSERT INTO `feedback` (`ComplaintID`,  `CommentID`, `Comment`, `UserID`, `Date`, `Time`) 
    VALUES ('$ComplaintID','$CommentID','$complaint','$UserID','$actual_date','$actual_time')")){
	
        ?>
    <script>
        Snackbar.show({
            text: 'Complaint has been successfully logged.',
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
            text: 'There was an issue while trying to add a comment to your complaint. Please try again later.',
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
            text: 'There was an issue while trying to log your complaint. Please try again later.',
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
            text: 'There was an issue while trying to update customer details. Please try again later.',
            pos: 'top-right',
            actionTextColor: '#fff',
            backgroundColor: '#B71C1C'
        });

    </script>
    <?php
}
}
}
    
if(isset($_POST['replyBtn'])){
	
$CommentID = $_POST['commentID'];
$Comment = $_POST['ReplyText'];
$UserID = $_SESSION['UserID'];
    
$uniqReply = uniqid();
$ReplyID = md5($uniqReply);    
    
$time = time();
$actual_date = date('Y-m-d', $time);
$actual_time = date('H:i',$time);
	
require_once('connect.php');

$result = mysqli_query($con,"SELECT * FROM `users` WHERE `UserID` = '$UserID'");
$res = mysqli_fetch_array($result);
    
$Commenter = $res['FirstName'].' '.$res['LastName'];
    
$resultComment = mysqli_query($con,"SELECT * FROM `feedback` WHERE `CommentID` = '$CommentID'");
$resComment = mysqli_fetch_array($resultComment);
    
$ComplaintID = $resComment['ComplaintID'];
    
$resultComplaint = mysqli_query($con,"SELECT * FROM `complaints` WHERE `ComplaintID` = '$ComplaintID'");
$resComplaint = mysqli_fetch_array($resultComplaint);
    
$ComplaintID = $resComplaint['id'];
$LoggerID = $resComplaint['LoggerID'];
    

$resultLogger = mysqli_query($con,"SELECT * FROM `users` WHERE `UserID` = '$LoggerID'");
$resLogger = mysqli_fetch_array($resultLogger);
    
$LoggerEmail = $resLogger['EmailAddress'];
    
if(mysqli_query($con,"INSERT INTO `feedbackreplies` (`CommentID`, `ReplyID`,  `Comment`, `UserID`, `Date`, `Time`) VALUES ('$CommentID','$ReplyID','$Comment','$UserID','$actual_date','$actual_time')")){
    
    // Create the email and send the message
$to = $LoggerEmail; 
$email_subject = "Complaint Tracker Registration.";
$htmlContent = '
    <table class="body-wrap" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; background-color: #f6f6f6; margin: 0;" bgcolor="#f6f6f6">
        <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
            <td style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;" valign="top"></td>
            <td class="container" width="600" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto;" valign="top">
                <div width="100%" class="content" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; max-width: 600px; display: block; margin: 0 auto; padding: 20px;">
                    <table class="main" min-width="100%" cellpadding="0" cellspacing="0" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; display: inline-block; font-size: 14px; overflow: hidden; border-radius: 7px; background-color: #fff; margin: 0; border: 1px solid #e9e9e9;" bgcolor="#fff">
                        <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                            <td class="alert alert-warning" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 40px; vertical-align: top; color: #fff; font-weight: 500; text-align: center; border-radius: 3px 3px 0 0; background-color: #022f44; margin: 0; padding: 20px;" align="center" bgcolor="#71b6f9" valign="top">

                                <span style="margin-top: 20px;display: block;"><strong>Complaint Tracker.</strong></span>
                            </td>
                        </tr>
                        <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box;  font-size: 14px; margin: 0;">
                            <td class="content-wrap" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; border: 2px solid #022f44; font-size: 14px; vertical-align: top; margin: 0; padding: 20px;" valign="top">
                                <table width="100%" cellpadding="0" cellspacing="0" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">

                                    <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                        <td class="content-block" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; color: #33691E; padding: 0 0 20px;" valign="top">
                                           <strong> Kindly note that '.$Commenter.' replied on a comment in complaint #'.$ComplaintID.'</strong>
                                        </td>
                                    </tr>
                                    <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                        <td class="content-block" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 16px; vertical-align: top; margin: 0; padding: 0 0 20px; color: #022f44" valign="top">
                                            <strong>"'.$Comment.'"</strong>
    <br><br>
    <small>'.$actual_date.' '.$actual_time.'</small>
    </td>
    </tr>

    <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
        <td class="content-block" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">
            Click <a href="http://ct.thaboirvinservices.co.za/login" style="color: #022f44; text-decoration: none;">
                here
            </a> to login.
        </td>
    </tr>
    <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
        <td class="content-block" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">

        </td>
    </tr>
    <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
        <td class="content-block" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">
            Thank you for choosing <b>Complaint Tracker</b>.
        </td>
    </tr>
    </table>
    </td>
    </tr>
    </table>
    </div>
    </td>
    <td style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;" valign="top"></td>
    </tr>
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


        $mail = @mail($to, $email_subject, $message, $headers, $returnpath);
   
    ?>
    <script>
        Snackbar.show({
            text: 'Your reply was sent successfully.',
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
            text: 'There was an error while sending your reply. Please try again later.',
            pos: 'top-right',
            actionTextColor: '#fff',
            backgroundColor: '#B71C1C'
        });

    </script>
    <?php
    }

}
if(isset($_POST['commentBtn'])){
	
$ComplaintID = $_POST['complaintID'];
$Comment = $_POST['commentText'];
$UserID = $_SESSION['UserID'];
    
$uniqComment = uniqid();
$CommentID = md5($uniqComment);    
    
$time = time();
$actual_date = date('Y-m-d', $time);
$actual_time = date('H:i',$time);
	
require_once('connect.php');

$result = mysqli_query($con,"SELECT * FROM `users` WHERE `UserID` = '$UserID'");
$res = mysqli_fetch_array($result);
    
$Commenter = $res['FirstName'].' '.$res['LastName'];
    
$resultComplaint = mysqli_query($con,"SELECT * FROM `complaints` WHERE `ComplaintID` = '$ComplaintID'");
$resComplaint = mysqli_fetch_array($resultComplaint);
    
$ComplaintID = $resComplaint['id'];
$LoggerID = $resComplaint['LoggerID'];
    

$resultLogger = mysqli_query($con,"SELECT * FROM `users` WHERE `UserID` = '$LoggerID'");
$resLogger = mysqli_fetch_array($resultLogger);
    
$LoggerEmail = $resLogger['EmailAddress'];
    
if(mysqli_query($con,"INSERT INTO `feedback` (`ComplaintID`, `CommentID`, `Comment`, `CommentType`, `UserID`, `Date`, `Time`) VALUES ('$ComplaintID','$CommentID','$Comment','Comment','$UserID','$actual_date','$actual_time')")){
    
     // Create the email and send the message
$to = $LoggerEmail; 
$email_subject = "Complaint Tracker Registration.";
$htmlContent = '
    <table class="body-wrap" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; background-color: #f6f6f6; margin: 0;" bgcolor="#f6f6f6">
        <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
            <td style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;" valign="top"></td>
            <td class="container" width="600" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto;" valign="top">
                <div width="100%" class="content" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; max-width: 600px; display: block; margin: 0 auto; padding: 20px;">
                    <table class="main" min-width="100%" cellpadding="0" cellspacing="0" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; display: inline-block; font-size: 14px; overflow: hidden; border-radius: 7px; background-color: #fff; margin: 0; border: 1px solid #e9e9e9;" bgcolor="#fff">
                        <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                            <td class="alert alert-warning" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 40px; vertical-align: top; color: #fff; font-weight: 500; text-align: center; border-radius: 3px 3px 0 0; background-color: #022f44; margin: 0; padding: 20px;" align="center" bgcolor="#71b6f9" valign="top">

                                <span style="margin-top: 20px;display: block;"><strong>Complaint Tracker.</strong></span>
                            </td>
                        </tr>
                        <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box;  font-size: 14px; margin: 0;">
                            <td class="content-wrap" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; border: 2px solid #022f44; font-size: 14px; vertical-align: top; margin: 0; padding: 20px;" valign="top">
                                <table width="100%" cellpadding="0" cellspacing="0" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">

                                    <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                        <td class="content-block" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; color: #33691E; padding: 0 0 20px;" valign="top">
                                           <strong> Kindly note that '.$Commenter.' added a comment on complaint #'.$ComplaintID.'</strong>
                                        </td>
                                    </tr>
                                    <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                        <td class="content-block" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 16px; vertical-align: top; margin: 0; padding: 0 0 20px; color: #022f44" valign="top">
                                            <strong>"'.$Comment.'"</strong>
    <br><br>
    <small>'.$actual_date.' '.$actual_time.'</small>
    </td>
    </tr>

    <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
        <td class="content-block" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">
            Click <a href="http://ct.thaboirvinservices.co.za/login" style="color: #022f44; text-decoration: none;">
                here
            </a> to login.
        </td>
    </tr>
    <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
        <td class="content-block" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">

        </td>
    </tr>
    <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
        <td class="content-block" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">
            Thank you for choosing <b>Complaint Tracker</b>.
        </td>
    </tr>
    </table>
    </td>
    </tr>
    </table>
    </div>
    </td>
    <td style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;" valign="top"></td>
    </tr>
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


        $mail = @mail($to, $email_subject, $message, $headers, $returnpath);
   
    
    ?>
    <script>
        Snackbar.show({
            text: 'Your complaint was added successfully.',
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
            text: 'There was an error while sending your reply. Please try again later.',
            pos: 'top-right',
            actionTextColor: '#fff',
            backgroundColor: '#B71C1C'
        });

    </script>
    <?php
    }

}

if(isset($_POST['ResolvingBtn'])){
	
require_once('connect.php');
    
$ComplaintID = $_GET['yu567df6dffsd'];
$ResolvedReason = $_POST['ResolvedReason'];
$UserID = $_SESSION['UserID'];
    
$uniqComment = uniqid();
$CommentID = md5($uniqComment);    
    
$time = time();
$actual_date = date('Y-m-d', $time);
$actual_time = date('H:i',$time);

$dates = $actual_date.' '.$actual_time;

    
$result = mysqli_query($con,"SELECT * FROM `users` WHERE `UserID` = '$UserID'");
$res = mysqli_fetch_array($result);
    
$Resolver = $res['FirstName'].' '.$res['LastName'];
    
$resultComplaint = mysqli_query($con,"SELECT * FROM `complaints` WHERE `ComplaintID` = '$ComplaintID'");
$resComplaint = mysqli_fetch_array($resultComplaint);
    
$LoggerID = $resComplaint['LoggerID'];
    

$resultLogger = mysqli_query($con,"SELECT * FROM `users` WHERE `UserID` = '$LoggerID'");
$resLogger = mysqli_fetch_array($resultLogger);
    
$LoggerEmail = $resLogger['EmailAddress'];
    
    
$resultComplaintChecker = mysqli_query($con,"SELECT * FROM `complaints` WHERE `ComplaintID` = '$ComplaintID'");
    
if(mysqli_num_rows($resultComplaintChecker)){
	
	if(mysqli_query($con,"UPDATE `complaints` SET `ComplaintStatus`='Resolved', `ResolvedReason`='$ResolvedReason', `ResolvedUserID` = '$UserID', `ChangeDate` = '$dates'  WHERE `ComplaintID` = '$ComplaintID'")){
        
        $resComplaintChecker = mysqli_fetch_array($resultComplaintChecker);
        if(mysqli_query($con,"INSERT INTO `feedback` (`ComplaintID`,  `CommentID`, `Comment`,  `CommentType`, `UserID`, `Date`, `Time`) VALUES ('$ComplaintID','$CommentID','$ResolvedReason','Resolved','$UserID','$actual_date','$actual_time')")){
    
$ComplaintID = $resComplaint['id'];
             // Create the email and send the message
$to = $LoggerEmail; 
$email_subject = "Complaint Tracker Registration.";
$htmlContent = '
    <table class="body-wrap" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; background-color: #f6f6f6; margin: 0;" bgcolor="#f6f6f6">
        <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
            <td style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;" valign="top"></td>
            <td class="container" width="600" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto;" valign="top">
                <div width="100%" class="content" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; max-width: 600px; display: block; margin: 0 auto; padding: 20px;">
                    <table class="main" min-width="100%" cellpadding="0" cellspacing="0" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; display: inline-block; font-size: 14px; overflow: hidden; border-radius: 7px; background-color: #fff; margin: 0; border: 1px solid #e9e9e9;" bgcolor="#fff">
                        <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                            <td class="alert alert-warning" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 40px; vertical-align: top; color: #fff; font-weight: 500; text-align: center; border-radius: 3px 3px 0 0; background-color: #022f44; margin: 0; padding: 20px;" align="center" bgcolor="#71b6f9" valign="top">

                                <span style="margin-top: 20px;display: block;"><strong>Complaint Tracker.</strong></span>
                            </td>
                        </tr>
                        <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box;  font-size: 14px; margin: 0;">
                            <td class="content-wrap" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; border: 2px solid #022f44; font-size: 14px; vertical-align: top; margin: 0; padding: 20px;" valign="top">
                                <table width="100%" cellpadding="0" cellspacing="0" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">

                                    <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                        <td class="content-block" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; color: #33691E; padding: 0 0 20px;" valign="top">
                                           <strong> Kindly note that '.$Resolver.' marked complaint #'.$ComplaintID.' as resolved.</strong>
                                        </td>
                                    </tr>
                                    <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                        <td class="content-block" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 16px; vertical-align: top; margin: 0; padding: 0 0 20px; color: #022f44" valign="top">
                                            <strong>"'.$ResolvedReason.'"</strong>
    <br><br>
    <small>'.$actual_date.' '.$actual_time.'</small>
    </td>
    </tr>

    <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
        <td class="content-block" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">
            Click <a href="http://ct.thaboirvinservices.co.za/login" style="color: #022f44; text-decoration: none;">
                here
            </a> to login.
        </td>
    </tr>
    <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
        <td class="content-block" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">

        </td>
    </tr>
    <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
        <td class="content-block" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">
            Thank you for choosing <b>Complaint Tracker</b>.
        </td>
    </tr>
    </table>
    </td>
    </tr>
    </table>
    </div>
    </td>
    <td style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;" valign="top"></td>
    </tr>
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


        $mail = @mail($to, $email_subject, $message, $headers, $returnpath);
   
    
    ?>
    <script src="assets/js/jquery.min.js"></script>
    <script>
        Snackbar.show({
            text: 'Complaint <?php echo $resComplaintChecker['id']; ?> was resolved successfully.',
            pos: 'top-right',
            actionTextColor: '#fff',
            backgroundColor: '#33691E'
        });

    </script>
    <?php
        }else{
        ?>
    <script src="assets/js/jquery.min.js"></script>
    <script>
        Snackbar.show({
            text: 'Something went wrong while updating resolution comment on Complaint <?php echo $res['id']; ?>. Please try again later.',
            pos: 'top-right',
            actionTextColor: '#fff',
            backgroundColor: '#B71C1C'
        });

    </script>
    <?php
    }
    }else{
        ?>
    <script src="assets/js/jquery.min.js"></script>
    <script>
        Snackbar.show({
            text: 'Something went wrong while updating resolution status for Complaint <?php echo $res['id']; ?>. Please try again later.',
            pos: 'top-right',
            actionTextColor: '#fff',
            backgroundColor: '#B71C1C'
        });

    </script>
    <?php
    }
}else{
    ?>
    <script src="assets/js/jquery.min.js"></script>
    <script>
        Snackbar.show({
            text: 'Complaint not found. Please try again or contact your administrator',
            pos: 'top-right',
            actionTextColor: '#fff',
            backgroundColor: '#B71C1C'
        });

    </script>
    <?php
}
}
    
if(isset($_POST['AttachmentBtn'])){
	
require_once('connect.php');
    
$UserID = $_SESSION['UserID'];
$AttachmentDescription = mysqli_real_escape_string($con,$_POST['AttachmentDescription']);
    
	$file = $_FILES['attachfile'];
	
	//file properties
	
	$file_name = $file['name'];
	$file_tmp = $file['tmp_name'];
	$file_size = $file['size'];
	$file_error = $file['error'];
	
	//file Extension
	
	$file_ext = explode('.',$file_name);
	$file_ext = strtolower(end($file_ext));
    
		if($file_error === 0){
            
			if($file_size <= 500000000){
                
            require_once('connect.php');
               
            $time = time();
            $actual_date = date('Y-m-d', $time);
            $actual_time = date('H:i',$time);
        
            $ComplaintID = $_GET['yu567df6dffsd'];
			$file_type = $_FILES['attachfile']['type'];
			$file_data = $_FILES['attachfile']['tmp_name'];
            
			$file_name = $_FILES["attachfile"]["name"];
            $file_ext = explode(".", $file_name);
            $fileActualExt = strtolower(end($file_ext));
            
			$file_name_new = uniqid('', true) . "." . $fileActualExt;
                
            $file_path = 'documents/'.$file_name_new;
            
            if($ComplaintID != '' || $file_name_new != ''){
                    
                    if(mysqli_query($con,"INSERT INTO `attachments` (`ComplaintID`, `FileName`, `FilePath`, `FileType`, `UserID`, `Date`, `Time`) VALUES ('$ComplaintID','$file_name_new','$file_path','$fileActualExt','$UserID','$actual_date','$actual_time')")){
 
                    if(move_uploaded_file($file_data,$file_path)){
                ?>

    <script>
        Snackbar.show({
            text: 'File uploaded successfully',
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
            text: 'There was an issue while trying to save the attached document. Please try again.',
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
            text: 'There was an issue while trying to save the attachment details. Please try again.',
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
            text: 'Something went wrong. Please try uploading again or contact your administrator.',
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
            text: 'File too large.',
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
            text: 'Something went wrong while uploading your file. Please try again later.',
            pos: 'top-right',
            actionTextColor: '#fff',
            backgroundColor: '#B71C1C'
        });

    </script>
    <?php
			
		}
}
if(isset($_POST['PasswordBtn'])){
	
require_once('connect.php');
    
$UserID = $_SESSION['UserID'];
$Password = mysqli_real_escape_string($con,$_POST['Password']);
$ConfirmPassword = mysqli_real_escape_string($con,$_POST['ConfirmPassword']);
    
if($Password == $ConfirmPassword){
	
	if(mysqli_query($con,"UPDATE `users` SET `Password`= '$Password' WHERE `UserID` = '$UserID'")){
         ?>
    <script src="assets/js/jquery.min.js"></script>
    <script>
        Snackbar.show({
            text: 'Your password was updated successfully.',
            pos: 'top-right',
            actionTextColor: '#fff',
            backgroundColor: '#33691E'
        });

    </script>
    <?php
            
    }else{
        ?>
    <script src="assets/js/jquery.min.js"></script>
    <script>
        Snackbar.show({
            text: 'Something went wrong while updating your password. Please try again later.',
            pos: 'top-right',
            actionTextColor: '#fff',
            backgroundColor: '#B71C1C'
        });

    </script>
    <?php
    }
}else{
    ?>
    <script src="assets/js/jquery.min.js"></script>
    <script>
        Snackbar.show({
            text: 'Confirm password does not match.',
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
                            <a href="profile?pg=delegate">
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
                            <a href="lockscreen?pg=delegate">
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
                <form class="modal-content" action="delegate" method="POST">
                    <div class="modal-body">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="modal">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                        <div class="compose-box">
                            <div class="compose-content" id="addTaskModalTitle">
                                <h5 class="">Add Task</h5>
                                <div class="form-group mb-3">
                                    <label for="password">First Name</label>
                                    <input class="form-control" name="FirstName" required type="text" id="FirstName" placeholder="First Name">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="password">Last Name</label>
                                    <input class="form-control" name="LastName" required type="text" id="LastName" placeholder="LastName">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="password">Email Address</label>
                                    <input class="form-control" type="email" id="emailaddress" name="emailAddress" required="" placeholder="Email address">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="password">Contact Number</label>
                                    <input class="form-control" type="text" id="contactNumber" name="contactNumber" required="" placeholder="Contact Number">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="password">Physical Address</label>
                                    <input class="form-control" type="text" id="Address" name="physicalAddress" required="" placeholder="Physical address">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="ComplaintType">Complaint Type</label>
                                    <select name="complaintType" class="form-control" id="ComplaintType">
                                        <option selected value="Electricity">Electricity</option>
                                        <option value="Roads">Roads</option>
                                        <option value="Sanitation">Sanitation</option>
                                        <option value="Solid Waste">Solid Waste</option>
                                        <option value="Water">Water</option>
                                        <option value="Water Drainage">Water Drainage</option>
                                    </select>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="complaint">Complaint</label>
                                    <textarea required="" id="complaint" name="complaint" class="form-control" rows="5"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn" data-dismiss="modal">Cancel</button>
                        <button name="AddComplaint" type="submit" class="btn AddComplaint btn-outline-warning">Add Complaint</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Approve modal -->
        <div id="PasswordModal" style="z-index: 10000" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form action="delegate" method="POST" class="modal-content">
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
                                        <h5 class="app-title">Complaints</h5>
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
                                                    <a class="nav-link list-actions" id="todo-task-important" data-toggle="pill" href="#pills-important" role="tab" aria-selected="false"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-star">
                                                            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                                        </svg> Approved <span class="todo-badge badge"></span></a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link list-actions" id="todo-task-done" data-toggle="pill" href="#pills-sentmail" role="tab" aria-selected="false"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-thumbs-up">
                                                            <path d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3"></path>
                                                        </svg> Resolved <span class="todo-badge badge"></span>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link list-actions" id="todo-task-trash" data-toggle="pill" href="#pills-trash" role="tab" aria-selected="false"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2">
                                                            <polyline points="3 6 5 6 21 6"></polyline>
                                                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                                            <line x1="10" y1="11" x2="10" y2="17"></line>
                                                            <line x1="14" y1="11" x2="14" y2="17"></line>
                                                        </svg> Declined
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                    <a class="btn" id="addTask" href="#"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus">
                                            <line x1="12" y1="5" x2="12" y2="19"></line>
                                            <line x1="5" y1="12" x2="19" y2="12"></line>
                                        </svg> Complaint
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
    
                                            $result = mysqli_query($con,"SELECT * FROM `complaints` WHERE `ComplaintStatus` = 'Approved' ORDER BY `id` DESC");
                                            $resultCompleted = mysqli_query($con,"SELECT * FROM `complaints` WHERE `ComplaintStatus` = 'Resolved' ORDER BY `id` DESC");
                                            $resultDeclined = mysqli_query($con,"SELECT * FROM `complaints` WHERE `ComplaintStatus` = 'Declined' ORDER BY `id` DESC");
    
                                            while($res = mysqli_fetch_array($result)){
                                                
                                                $UserID = $res['LoggerID'];
                                                $ComplaintID = $res['ComplaintID'];
                                                
                                                $resultUser = mysqli_query($con,"SELECT * FROM `users` WHERE `UserID` = '$UserID'");
                                                $resUser = mysqli_fetch_array($resultUser);
                                                
                                                
                                        ?>
                                        <div class="todo-item all-list todo-task-important ml-3" data-toggle="modal" data-target="#ViewModal<?php echo $res['id']; ?>">
                                            <div class="todo-item-inner">
                                                <div class="todo-content">
                                                    <h5 class="todo-heading" data-todoHeading="<?php echo 'Complaint Number: '.$res['id'].' - '.$res['ComplaintType'].' By '.$resUser['FirstName'].' '.$resUser['LastName']; ?>  "><?php echo '#'.$res['id'].' - '.$res['ComplaintType'].' By '.$resUser['FirstName'].' '.$resUser['LastName']; ?> </h5>
                                                    <p class="meta-date"><?php echo $res['Date'].', '.$res['Time']; ?></p>
                                                    <p class="todo-text mt-2" data-todoHtml="<p><span class='badge outline-badge-warning'><?php echo $res['ComplaintStatus']; ?></span> - <?php echo $res['Complaint']; ?></p>" data-todoText='{"ops":[{"insert":"<span class="badge outline-badge-warning"><?php echo $res['ComplaintStatus']; ?></span> - <?php echo $res['Complaint']; ?>.\n"}]}'><span class="badge outline-badge-warning"><?php echo $res['ComplaintStatus']; ?></span> - <?php echo $res['Complaint']; ?>.</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal fade" id="ViewModal<?php echo $res['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="ViewModal<?php echo $res['id']; ?>" aria-hidden="true">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel"><?php echo $res['ComplaintType'].' By '.$resUser['FirstName'].' '.$resUser['LastName']; ?></h5>
                                                    </div>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="modal">
                                                        <line x1="18" y1="6" x2="6" y2="18"></line>
                                                        <line x1="6" y1="6" x2="18" y2="18"></line>
                                                    </svg>
                                                    <div class="modal-body">
                                                        <ul class="nav nav-tabs mb-3 nav-fill" id="lineTab" role="tablist">
                                                            <li class="nav-item">
                                                                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home<?php echo $res['id']; ?>" role="tab" aria-controls="home" aria-selected="true">Complaint</a>
                                                            </li>
                                                            <li class="nav-item">
                                                                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile<?php echo $res['id']; ?>" role="tab" aria-controls="profile" aria-selected="false">Comments</a>
                                                            </li>
                                                            <li class="nav-item">
                                                                <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact<?php echo $res['id']; ?>" role="tab" aria-controls="contact" aria-selected="false">Logger</a>
                                                            </li>
                                                        </ul>
                                                        <div class="tab-content" id="myTabContent">
                                                            <div class="tab-pane fade show active" id="home<?php echo $res['id']; ?>" role="tabpanel" aria-labelledby="home-tab">
                                                                <p class="modal-text"><span class='badge outline-badge-warning'><?php echo $res['ComplaintStatus']; ?></span> - <?php echo $res['Complaint']; ?>.</p>
                                                                <p class="todo-text text-warning">
                                                                    <small>Approved Date:
                                                                        <?php echo $res['ChangeDate']; ?>
                                                                    </small>
                                                                </p>
                                                                <?php
                                                                    $resultAttachments= mysqli_query($con,"SELECT * FROM `attachments` WHERE `ComplaintID` = '$ComplaintID' ORDER BY `id` DESC");
                                                
                                                                    if(mysqli_num_rows($resultAttachments)){
                                                
                                                                    $resAttachment = mysqli_fetch_array($resultAttachments);
                                                                    $AttachedUserID = $resAttachment['UserID'];
                                                                       
                                                                    $resultAttachmentUser = mysqli_query($con,"SELECT * FROM `users` WHERE `UserID` = '$AttachedUserID'");
                                                                    $resAttachmentUser = mysqli_fetch_array($resultAttachmentUser);
                                                                        
                                                                    $AttachmentUser = $resAttachmentUser['FirstName'].' '.$resAttachmentUser['LastName'];
                                                                ?>
                                                                <div class="table-responsive">
                                                                    <table class="table table-bordered mb-4">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>File Name</th>
                                                                                <th>Attached By</th>
                                                                                <th>Date</th>
                                                                                <th class="text-center">Time</th>
                                                                                <th></th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <tr>
                                                                                <td><?php echo $resAttachment['FileName']; ?></td>
                                                                                <td><?php echo $AttachmentUser; ?></td>
                                                                                <td><?php echo $resAttachment['Date']; ?></td>
                                                                                <td class="text-center"><span class="text-success"><?php echo $resAttachment['Time']; ?></span></td>
                                                                                <td class="text-center">
                                                                                    <a target="<?php echo $resAttachment['FileName']; ?>" href="<?php echo $resAttachment['FilePath']; ?>">
                                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye">
                                                                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                                                                            <circle cx="12" cy="12" r="3"></circle>
                                                                                        </svg>
                                                                                    </a>
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                                <?php } ?>
                                                                <p class="mt-4 col-12" style="text-align:right">
                                                                    <a href="#" data-toggle="modal" data-target="#AttachModal" class="btn btn-outline-warning waves-effect"><i class="fa fa-file mr-2"></i>Attach File</a>
                                                                    <a href="#" data-toggle="modal" data-target="#ResolveModal" class="btn btn-outline-success waves-effect"><i class="fa fa-check mr-2"></i>Resolve</a>
                                                                </p>
                                                            </div>
                                                            <div class="tab-pane fade" id="profile<?php echo $res['id']; ?>" role="tabpanel" aria-labelledby="profile-tab">
                                                                <h3>Comments</h3>

                                                                <form class="row mt-4 ">
                                                                    <div class="col">
                                                                        <div class="form-group input-fields">
                                                                            <input type="text" name="complaintID" value="<?php echo $res['ComplaintID']; ?>" style="display:none;">
                                                                            <textarea required name="commentText" class="form-control " id="exampleFormControlTextarea1" rows="3" placeholder="Type your comment here"></textarea>
                                                                            <button type="submit" name="commentBtn" class="btn btn-outline-warning mt-4 float-right">Add Comment</button>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                                <hr>

                                                                <div id="toggleAccordion">
                                                                    <?php 
                                                
                                                                        $ComplaintID = $res['ComplaintID'];
                                                                        $resultComplaint = mysqli_query($con,"SELECT * FROM `feedback` WHERE `ComplaintID` = '$ComplaintID'");
                                                                        
                                                                        while($resComplaint = mysqli_fetch_array($resultComplaint)){
                                                                            
                                                                            $CommentUserID = $resComplaint['UserID'];
                                                                            $resultCommentUser = mysqli_query($con,"SELECT * FROM `users` WHERE `UserID` = '$CommentUserID'");
                                                                            $resCommentUser = mysqli_fetch_array($resultCommentUser);
                                        
                                                                            $CommentUser = $resCommentUser['FirstName'].' '.$resCommentUser['LastName'];
                                                                    ?>
                                                                    <div class="card mb-3" style="cursor:pointer;">
                                                                        <div class="media Reply<?php echo $resComplaint['id']; ?>" role="menu" data-toggle="collapse" data-target="#Reply<?php echo $resComplaint['id']; ?>" aria-expanded="false" aria-controls="Reply<?php echo $resComplaint['id']; ?>">
                                                                            <img class="meta-usr-img rounded mr-3 bs-tooltip" title="<?php echo $CommentUser; ?>" data-placement="right" src="assets/img/avatar.jpg" height="50em" alt="pic1">
                                                                            <div class="media-body">
                                                                                <h5 class="media-heading">
                                                                                    <?php echo '<span class="text-warning">'.$resUser['FirstName'].' '.$resUser['LastName'].'</span>'; 
                                                                                if($resComplaint['CommentType'] == "Log"){ echo '<small class="text-muted"> logged a complaint.</small>';} 
                                                                                if($resComplaint['CommentType'] == "Comment"){ echo '<small class="text-info"> commented</small>';}
                                                                                if($resComplaint['CommentType'] == "Approved"){ echo '<small class="text-success"> approved complaint</small>';} 
                                                                                if($resComplaint['CommentType'] == "Resolved"){ echo '<small class="text-success"> marked complaint as resolved</small>';} 
                                                                            ?>
                                                                                </h5>
                                                                                <p class="media-text"><?php echo $resComplaint['Comment']; ?></p>
                                                                            </div>
                                                                        </div>
                                                                        <div id="Reply<?php echo $resComplaint['id']; ?>" class="collapse" aria-labelledby="Reply<?php echo $resComplaint['id']; ?>" data-parent=".Reply<?php echo $resComplaint['id']; ?>">
                                                                            <div class="card-body">
                                                                                <hr>
                                                                                <?php 
                                                                            $CommentIDFeedback = $resComplaint['CommentID'];
                                                                            
                                                                            $resultReply = mysqli_query($con,"SELECT * FROM `feedbackreplies` WHERE `CommentID` = '$CommentIDFeedback'");
                                    
                                                                            while($resReply = mysqli_fetch_array($resultReply)){
                               
                                                                            $ReplyUserID = $resReply['UserID'];
                                                                            $resultReplyUser = mysqli_query($con,"SELECT * FROM `users` WHERE `UserID` = '$ReplyUserID'");
                                                                            $resReplyUser = mysqli_fetch_array($resultReplyUser);
                                        
                                                                            $RepliedUser = $resReplyUser['FirstName'].' '.$resReplyUser['LastName'];
                                                                        ?>
                                                                                <div class="media">
                                                                                    <a class="meta-usr-img" href="javascript:void(0);">
                                                                                        <img class="rounded" src="assets/img/boy.png" height="40em" alt="pic2">
                                                                                    </a>
                                                                                    <div class="media-body">
                                                                                        <h6 class="media-heading text-warning">
                                                                                            <?php echo $RepliedUser; ?>
                                                                                            <small class="text-muted">
                                                                                                replied
                                                                                                <br>
                                                                                                <small class="text-warning"><strong> <?php echo $resReply['Date'].' '.$resReply['Time']; ?></strong></small>
                                                                                            </small>
                                                                                        </h6>

                                                                                        <p class="media-text">

                                                                                            <?php echo $resReply['Comment']; ?>
                                                                                        </p>
                                                                                    </div>
                                                                                </div>
                                                                                <hr>
                                                                                <?php 
                                                                            }
                                                                            ?>

                                                                                <div class="row mt-4 ">
                                                                                    <div class="col">
                                                                                        <form action="delegate" method="POST" class="form-group input-fields">
                                                                                            <input type="text" name="commentID" value="<?php echo $CommentIDFeedback; ?>" style="display:none;">
                                                                                            <textarea required name="ReplyText" class="form-control " id="exampleFormControlTextarea1" rows="3" placeholder="Type your reply here"></textarea>
                                                                                            <button name="replyBtn" type="submit" class="btn btn-outline-warning mt-4 float-right">Reply</button>
                                                                                        </form>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <?php
                                                                        } ?>
                                                                </div>
                                                            </div>
                                                            <?php
                                                
                                                                $UserID = $res['LoggerID'];
                                                
                                                                $resultCountofComplaints = mysqli_query($con,"SELECT COUNT(id) AS Total FROM `complaints` WHERE `LoggerID` = '$UserID'");
                                                                $resCountofComplaints = mysqli_fetch_array($resultCountofComplaints);
                                                            ?>
                                                            <div class="tab-pane fade" id="contact<?php echo $res['id']; ?>" role="tabpanel" aria-labelledby="contact-tab">
                                                                <div class="card component-card_4">
                                                                    <div class="card-body row">
                                                                        <div class="user-profile col-xl-2">
                                                                            <img src="assets/img/boy.png" class="" alt="...">
                                                                        </div>
                                                                        <div class="user-info col-xl-9 ml-3">
                                                                            <h5 class="card-user_name"><?php echo $resUser['FirstName'].' '.$resUser['LastName']; ?></h5>
                                                                            <p class="card-user_occupation"><?php echo $resUser['UserType']; ?></p>
                                                                            <div class="card-star_rating">
                                                                                <span class="badge badge-primary"><?php echo $resCountofComplaints['Total']; ?></span>
                                                                            </div>

                                                                            <div class="card-text mt-4">
                                                                                <p><span class="text-warning" style="margin-right:25px"><strong>Physical Address</strong></span>&nbsp;&nbsp;<?php echo $resUser['Address']; ?></p>
                                                                                <p><span class="text-warning" style="margin-right:45px"><strong>Email Address</strong></span>&nbsp;&nbsp;<?php echo $resUser['EmailAddress']; ?></p>
                                                                                <p><span class="text-warning" style="margin-right:30px"><strong>Contact Number</strong></span>&nbsp;&nbsp;<?php echo $resUser['ContactNumber']; ?></p>
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

                                        <!-- decline modal -->
                                        <div id="ResolveModal" style="z-index: 10000" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <form action="delegate?yu567df6dffsd=<?php echo $ComplaintID; ?>" method="POST" class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title mt-0" id="myModalLabel">Resolving Complaint <span class="text-warning"><?php echo '#'.$res['id']; ?></span></h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <h5 class="font-16">Resolution for Complaint <span class="text-warning"><span class="text-warning"><?php echo '#'.$res['id']; ?></span></span></h5>

                                                        <div class="form-group mb-3">
                                                            <textarea required="" id="complaint" name="ResolvedReason" class="form-control" rows="5"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-outline-muted waves-effect btn-lg" data-dismiss="modal">Cancel</button>
                                                        <button name="ResolvingBtn" type="submit" class="btn btn-outline-success waves-effect btn-lg waves-light">Resolve</button>
                                                    </div>
                                                </form><!-- /.modal-content -->
                                            </div><!-- /.modal-dialog -->
                                        </div><!-- /.modal -->
                                        <!-- decline modal -->
                                        <div id="AttachModal" style="z-index: 10000" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <form enctype="multipart/form-data" action="delegate?yu567df6dffsd=<?php echo $res['ComplaintID']; ?>" method="POST" class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title mt-0" id="myModalLabel">Attaching a document <span class="text-warning"><?php echo '#'.$res['id']; ?></span></h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <h5 class="font-16">Attachment Description <span class="text-warning"><span class="text-warning"><?php echo '#'.$res['id']; ?></span></span></h5>
                                                        <div class="form-group mb-3">
                                                            <textarea required="" id="AttachmentDescription" name="AttachmentDescription" class="form-control col-xl-9 col-lg-9 col-md-9" rows="5"></textarea>
                                                        </div>
                                                        <div>
                                                            <div class="upload mt-4 pr-md-4">
                                                                <p class="mt-2"><i class="flaticon-cloud-upload mr-1"></i> Upload Document</p>
                                                                <input type="file" required name="attachfile" id="input-file-max-fs" class="dropify" accept="application/msword,application/pdf,application/excel," data-max-file-size="5M" />

                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-outline-muted waves-effect btn-lg" data-dismiss="modal">Cancel</button>
                                                        <button name="AttachmentBtn" type="submit" class="btn btn-outline-success waves-effect btn-lg waves-light">Resolve</button>
                                                    </div>
                                                </form><!-- /.modal-content -->
                                            </div><!-- /.modal-dialog -->
                                        </div><!-- /.modal -->

                                        <?php }
                                        
                                            while($res = mysqli_fetch_array($resultCompleted)){
                                                
                                                
                                                $UserID = $res['LoggerID'];
                                                
                                                $resultUser = mysqli_query($con,"SELECT * FROM `users` WHERE `UserID` = '$UserID'");
                                                $resUser = mysqli_fetch_array($resultUser);
                                        ?>
                                        <div class="todo-item all-list todo-task-done ml-3" data-toggle="modal" data-target="#ApprovedModal<?php echo $res['id']; ?>">
                                            <div class="todo-item-inner">
                                                <div class="todo-content">
                                                    <h5 class="todo-heading" data-todoHeading="<?php echo '#'.$res['id'].' - '.$res['ComplaintType'].' By '.$resUser['FirstName'].' '.$resUser['LastName']; ?>  "><?php echo '#'.$res['id'].' - '.$res['ComplaintType'].' By '.$resUser['FirstName'].' '.$resUser['LastName']; ?> </h5>
                                                    <p class="meta-date text-success"><?php echo $resUser['FirstName'].' '.$resUser['LastName'].' marked complaint as Resolved'; ?></p>
                                                    <p class="meta-date"><?php echo $res['Date'].', '.$res['Time']; ?></p>
                                                    <p class="todo-text mt-2" data-todoHtml="<p><span class='badge outline-badge-success'><?php echo $res['ComplaintStatus']; ?></span> - <?php echo $res['Complaint']; ?></p>" data-todoText='{"ops":[{"insert":"<span class="badge outline-badge-success"><?php echo $res['ComplaintStatus']; ?></span> - <?php echo $res['Complaint']; ?>.\n"}]}'><span class="badge outline-badge-success"><?php echo $res['ComplaintStatus']; ?></span> - <?php echo $res['Complaint']; ?>.</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal fade" id="ApprovedModal<?php echo $res['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="ApprovedModal<?php echo $res['id']; ?>" aria-hidden="true">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel"><?php echo $res['ComplaintType'].' By '.$resUser['FirstName'].' '.$resUser['LastName']; ?></h5>
                                                    </div>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="modal">
                                                        <line x1="18" y1="6" x2="6" y2="18"></line>
                                                        <line x1="6" y1="6" x2="18" y2="18"></line>
                                                    </svg>
                                                    <div class="modal-body">
                                                        <ul class="nav nav-tabs mb-3 nav-fill" id="lineTab" role="tablist">
                                                            <li class="nav-item">
                                                                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home<?php echo $res['id']; ?>" role="tab" aria-controls="home" aria-selected="true">Complaint</a>
                                                            </li>
                                                            <li class="nav-item">
                                                                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile<?php echo $res['id']; ?>" role="tab" aria-controls="profile" aria-selected="false">Comments</a>
                                                            </li>
                                                            <li class="nav-item">
                                                                <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact<?php echo $res['id']; ?>" role="tab" aria-controls="contact" aria-selected="false">Logger</a>
                                                            </li>
                                                        </ul>
                                                        <div class="tab-content" id="myTabContent">
                                                            <div class="tab-pane fade show active" id="home<?php echo $res['id']; ?>" role="tabpanel" aria-labelledby="home-tab">

                                                                <p class="modal-text col-12">
                                                                    <span class='badge outline-badge-success'>
                                                                        <?php echo $res['ComplaintStatus']; ?>
                                                                    </span> - <?php echo $res['Complaint']; ?>.
                                                                </p><?php
                                                                    $resultAttachments= mysqli_query($con,"SELECT * FROM `attachments` WHERE `ComplaintID` = '$ComplaintID' ORDER BY `id` DESC");
                                                
                                                                    if(mysqli_num_rows($resultAttachments)){
                                                
                                                                    $resAttachment = mysqli_fetch_array($resultAttachments);
                                                                    $AttachedUserID = $resAttachment['UserID'];
                                                                       
                                                                    $resultAttachmentUser = mysqli_query($con,"SELECT * FROM `users` WHERE `UserID` = '$AttachedUserID'");
                                                                    $resAttachmentUser = mysqli_fetch_array($resultAttachmentUser);
                                                                        
                                                                    $AttachmentUser = $resAttachmentUser['FirstName'].' '.$resAttachmentUser['LastName'];
                                                                ?>
                                                                <div class="table-responsive">
                                                                    <table class="table table-bordered mb-4">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>File Name</th>
                                                                                <th>Attached By</th>
                                                                                <th>Date</th>
                                                                                <th class="text-center">Time</th>
                                                                                <th></th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <tr>
                                                                                <td><?php echo $resAttachment['FileName']; ?></td>
                                                                                <td><?php echo $AttachmentUser; ?></td>
                                                                                <td><?php echo $resAttachment['Date']; ?></td>
                                                                                <td class="text-center"><span class="text-success"><?php echo $resAttachment['Time']; ?></span></td>
                                                                                <td class="text-center">
                                                                                    <a target="<?php echo $resAttachment['FileName']; ?>" href="<?php echo $resAttachment['FilePath']; ?>">
                                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye">
                                                                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                                                                            <circle cx="12" cy="12" r="3"></circle>
                                                                                        </svg>
                                                                                    </a>
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                                <?php } ?>
                                                            </div>
                                                            <div class="tab-pane fade" id="profile<?php echo $res['id']; ?>" role="tabpanel" aria-labelledby="profile-tab">
                                                                <h3>Comments</h3>

                                                                <form class="row mt-4" action="delegate" method="POST">
                                                                    <div class="col">
                                                                        <div class="form-group input-fields">
                                                                            <input type="text" name="complaintID" value="<?php echo $res['ComplaintID']; ?>" style="display:none;">
                                                                            <textarea required name="commentText" class="form-control " id="exampleFormControlTextarea1" rows="3" placeholder="Type your comment here"></textarea>
                                                                            <button type="submit" name="commentBtn" class="btn btn-outline-warning mt-4 float-right">Add Comment</button>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                                <hr>

                                                                <div id="toggleAccordion">
                                                                    <?php 
                                                
                                                                        $ComplaintID = $res['ComplaintID'];
                                                                        $resultComplaint = mysqli_query($con,"SELECT * FROM `feedback` WHERE `ComplaintID` = '$ComplaintID'");
                                                                        
                                                                        while($resComplaint = mysqli_fetch_array($resultComplaint)){
                                                                            
                                                                            $CommentUserID = $resComplaint['UserID'];
                                                                            $resultCommentUser = mysqli_query($con,"SELECT * FROM `users` WHERE `UserID` = '$CommentUserID'");
                                                                            $resCommentUser = mysqli_fetch_array($resultCommentUser);
                                        
                                                                            $CommentUser = $resCommentUser['FirstName'].' '.$resCommentUser['LastName'];
                                                                    ?>
                                                                    <div class="card mb-3" style="cursor:pointer;">
                                                                        <div class="media Reply<?php echo $resComplaint['id']; ?>" role="menu" data-toggle="collapse" data-target="#Reply<?php echo $resComplaint['id']; ?>" aria-expanded="false" aria-controls="Reply<?php echo $resComplaint['id']; ?>">
                                                                            <img class="meta-usr-img rounded mr-3 bs-tooltip" title="<?php echo $CommentUser; ?>" data-placement="right" src="assets/img/avatar.jpg" height="50em" alt="pic1">
                                                                            <div class="media-body">
                                                                                <h5 class="media-heading">
                                                                                    <?php echo '<span class="text-warning">'.$resUser['FirstName'].' '.$resUser['LastName'].'</span>'; 
                                                                                if($resComplaint['CommentType'] == "Log"){ echo '<small class="text-muted"> logged a complaint.</small>';} 
                                                                                if($resComplaint['CommentType'] == "Comment"){ echo '<small class="text-info"> commented</small>';}
                                                                                if($resComplaint['CommentType'] == "Approved"){ echo '<small class="text-success"> approved complaint</small>';} 
                                                                                if($resComplaint['CommentType'] == "Resolved"){ echo '<small class="text-success"> marked complaint as resolved</small>';} 
                                                                            ?>
                                                                                </h5>
                                                                                <p class="media-text"><?php echo $resComplaint['Comment']; ?></p>
                                                                            </div>
                                                                        </div>
                                                                        <div id="Reply<?php echo $resComplaint['id']; ?>" class="collapse" aria-labelledby="Reply<?php echo $resComplaint['id']; ?>" data-parent=".Reply<?php echo $resComplaint['id']; ?>">
                                                                            <div class="card-body">
                                                                                <hr>
                                                                                <?php 
                                                                            $CommentIDFeedback = $resComplaint['CommentID'];
                                                                            
                                                                            $resultReply = mysqli_query($con,"SELECT * FROM `feedbackreplies` WHERE `CommentID` = '$CommentIDFeedback'  ");
                                    
                                                                            while($resReply = mysqli_fetch_array($resultReply)){
                               
                                                                            $ReplyUserID = $resReply['UserID'];
                                                                            $resultReplyUser = mysqli_query($con,"SELECT * FROM `users` WHERE `UserID` = '$ReplyUserID'");
                                                                            $resReplyUser = mysqli_fetch_array($resultReplyUser);
                                        
                                                                            $RepliedUser = $resReplyUser['FirstName'].' '.$resReplyUser['LastName'];
                                                                        ?>
                                                                                <div class="media">
                                                                                    <a class="meta-usr-img" href="javascript:void(0);">
                                                                                        <img class="rounded" src="assets/img/boy.png" height="40em" alt="pic2">
                                                                                    </a>
                                                                                    <div class="media-body">
                                                                                        <h6 class="media-heading text-warning">
                                                                                            <?php echo $RepliedUser; ?>
                                                                                            <small class="text-muted">
                                                                                                replied
                                                                                                <br>
                                                                                                <small class="text-warning"><strong> <?php echo $resReply['Date'].' '.$resReply['Time']; ?></strong></small>
                                                                                            </small>
                                                                                        </h6>

                                                                                        <p class="media-text">

                                                                                            <?php echo $resReply['Comment']; ?>
                                                                                        </p>
                                                                                    </div>
                                                                                </div>
                                                                                <hr>
                                                                                <?php 
                                                                            }
                                                                            ?>

                                                                                <div class="row mt-4 ">
                                                                                    <div class="col">
                                                                                        <form action="delegate" method="POST" class="form-group input-fields">
                                                                                            <input type="text" name="commentID" value="<?php echo $CommentIDFeedback; ?>" style="display:none;">
                                                                                            <textarea required name="ReplyText" class="form-control " id="exampleFormControlTextarea1" rows="3" placeholder="Type your reply here"></textarea>
                                                                                            <button name="replyBtn" type="submit" class="btn btn-outline-warning mt-4 float-right">Reply</button>
                                                                                        </form>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <?php
                                                                        } ?>
                                                                </div>
                                                            </div>
                                                            <?php
                                                
                                                                $UserID = $res['LoggerID'];
                                                
                                                                $resultCountofComplaints = mysqli_query($con,"SELECT COUNT(id) AS Total FROM `complaints` WHERE `LoggerID` = '$UserID'");
                                                                $resCountofComplaints = mysqli_fetch_array($resultCountofComplaints);
                                                            ?>
                                                            <div class="tab-pane fade" id="contact<?php echo $res['id']; ?>" role="tabpanel" aria-labelledby="contact-tab">
                                                                <div class="card component-card_4">
                                                                    <div class="card-body row">
                                                                        <div class="user-profile col-xl-2">
                                                                            <img src="assets/img/boy.png" class="" alt="...">
                                                                        </div>
                                                                        <div class="user-info col-xl-9 ml-3">
                                                                            <h5 class="card-user_name"><?php echo $resUser['FirstName'].' '.$resUser['LastName']; ?></h5>
                                                                            <p class="card-user_occupation"><?php echo $resUser['UserType']; ?></p>
                                                                            <div class="card-star_rating">
                                                                                <span class="badge badge-primary"><?php echo $resCountofComplaints['Total']; ?></span>
                                                                            </div>

                                                                            <div class="card-text mt-4">
                                                                                <p><span class="text-warning" style="margin-right:25px"><strong>Physical Address</strong></span>&nbsp;&nbsp;<?php echo $resUser['Address']; ?></p>
                                                                                <p><span class="text-warning" style="margin-right:45px"><strong>Email Address</strong></span>&nbsp;&nbsp;<?php echo $resUser['EmailAddress']; ?></p>
                                                                                <p><span class="text-warning" style="margin-right:30px"><strong>Contact Number</strong></span>&nbsp;&nbsp;<?php echo $resUser['ContactNumber']; ?></p>
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

                                        <?php } 
                                            while($res = mysqli_fetch_array($resultDeclined)){
                                        ?>
                                        <div class="todo-item all-list todo-task-trash ml-3" data-toggle="modal" data-target="#DeclinedModal<?php echo $res['id']; ?>">
                                            <div class="todo-item-inner">
                                                <div class="todo-content">
                                                    <h5 class="todo-heading" data-todoHeading="<?php echo 'Complaint Number: '.$res['id'].' - '.$res['ComplaintType'].' By '.$resUser['FirstName'].' '.$resUser['LastName']; ?>  "><?php echo '#'.$res['id'].' - '.$res['ComplaintType'].' By '.$resUser['FirstName'].' '.$resUser['LastName']; ?> </h5>
                                                    <p class="meta-date text-danger"><?php echo $res['Date'].' - Complaint declined by admin'; ?></p>
                                                    <p class="meta-date"><?php echo $res['Date'].', '.$res['Time']; ?></p>
                                                    <p class="todo-text mt-2" data-todoHtml="<p> <?php echo $res['ComplaintStatus']; ?> - <?php echo $res['Complaint']; ?></p>" data-todoText='{"ops":[{"insert":"<span class="badge outline-badge-danger"><?php echo $res['ComplaintStatus']; ?></span> - <?php echo $res['Complaint']; ?>.\n"}]}'><span class="badge outline-badge-danger"><?php echo $res['ComplaintStatus']; ?></span> - <?php echo $res['Complaint']; ?>.</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="modal fade" id="DeclinedModal<?php echo $res['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="DeclinedModal<?php echo $res['id']; ?>" aria-hidden="true">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel"><?php echo $res['ComplaintType'].' By '.$resUser['FirstName'].' '.$resUser['LastName']; ?></h5>
                                                    </div>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="modal">
                                                        <line x1="18" y1="6" x2="6" y2="18"></line>
                                                        <line x1="6" y1="6" x2="18" y2="18"></line>
                                                    </svg>
                                                    <div class="modal-body">
                                                        <ul class="nav nav-tabs mb-3 nav-fill" id="lineTab" role="tablist">
                                                            <li class="nav-item">
                                                                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home<?php echo $res['id']; ?>" role="tab" aria-controls="home" aria-selected="true">Complaint</a>
                                                            </li>
                                                            <li class="nav-item">
                                                                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile<?php echo $res['id']; ?>" role="tab" aria-controls="profile" aria-selected="false">Comments</a>
                                                            </li>
                                                            <li class="nav-item">
                                                                <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact<?php echo $res['id']; ?>" role="tab" aria-controls="contact" aria-selected="false">Logger</a>
                                                            </li>
                                                        </ul>
                                                        <div class="tab-content" id="myTabContent">
                                                            <div class="tab-pane fade show active" id="home<?php echo $res['id']; ?>" role="tabpanel" aria-labelledby="home-tab">
                                                                <p class="modal-text"><span class='badge outline-badge-danger'><?php echo $res['ComplaintStatus']; ?></span> - <?php echo $res['Complaint']; ?>.</p>
                                                                <p class="todo-text text-danger mt-4">
                                                                    Reason for Declining:
                                                                    <?php echo $res['DeclinedReason']; ?>
                                                                </p>
                                                                <p class="todo-text text-danger">
                                                                    <small>Declined Date:
                                                                        <?php echo $res['ChangeDate']; ?>
                                                                    </small>
                                                                </p>
                                                            </div>
                                                            <div class="tab-pane fade" id="profile<?php echo $res['id']; ?>" role="tabpanel" aria-labelledby="profile-tab">
                                                                <h3>Comments</h3>

                                                                <form class="row mt-4 ">
                                                                    <div class="col">
                                                                        <div class="form-group input-fields">
                                                                            <input type="text" name="complaintID" value="<?php echo $res['ComplaintID']; ?>" style="display:none;">
                                                                            <textarea required name="commentText" class="form-control " id="exampleFormControlTextarea1" rows="3" placeholder="Type your comment here"></textarea>
                                                                            <button type="submit" name="commentBtn" class="btn btn-outline-warning mt-4 float-right">Add Comment</button>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                                <hr>

                                                                <div id="toggleAccordion">
                                                                    <?php 
                                                
                                                                        $ComplaintID = $res['ComplaintID'];
                                                                        $resultComplaint = mysqli_query($con,"SELECT * FROM `feedback` WHERE `ComplaintID` = '$ComplaintID'");
                                                                        
                                                                        while($resComplaint = mysqli_fetch_array($resultComplaint)){
                                                                            
                                                                            $CommentUserID = $resComplaint['UserID'];
                                                                            $resultCommentUser = mysqli_query($con,"SELECT * FROM `users` WHERE `UserID` = '$CommentUserID'");
                                                                            $resCommentUser = mysqli_fetch_array($resultCommentUser);
                                        
                                                                            $CommentUser = $resCommentUser['FirstName'].' '.$resCommentUser['LastName'];
                                                                    ?>
                                                                    <div class="card mb-3" style="cursor:pointer;">
                                                                        <div class="media Reply<?php echo $resComplaint['id']; ?>" role="menu" data-toggle="collapse" data-target="#Reply<?php echo $resComplaint['id']; ?>" aria-expanded="false" aria-controls="Reply<?php echo $resComplaint['id']; ?>">
                                                                            <img class="meta-usr-img rounded mr-3 bs-tooltip" title="<?php echo $CommentUser; ?>" data-placement="right" src="assets/img/avatar.jpg" height="50em" alt="pic1">
                                                                            <div class="media-body">
                                                                                <h5 class="media-heading">
                                                                                    <?php echo '<span class="text-warning">'.$resUser['FirstName'].' '.$resUser['LastName'].'</span>'; 
                                                                                if($resComplaint['CommentType'] == "Log"){ echo '<small class="text-muted"> logged a complaint.</small>';} 
                                                                                if($resComplaint['CommentType'] == "Comment"){ echo '<small class="text-info"> commented</small>';}
                                                                                if($resComplaint['CommentType'] == "Declined"){ echo '<small class="text-danger"> declined complaint</small>';} 
                                                                            ?>
                                                                                </h5>
                                                                                <p class="media-text"><?php echo $resComplaint['Comment']; ?></p>
                                                                            </div>
                                                                        </div>
                                                                        <div id="Reply<?php echo $resComplaint['id']; ?>" class="collapse" aria-labelledby="Reply<?php echo $resComplaint['id']; ?>" data-parent=".Reply<?php echo $resComplaint['id']; ?>">
                                                                            <div class="card-body">
                                                                                <hr>
                                                                                <?php 
                                                                            $CommentIDFeedback = $resComplaint['CommentID'];
                                                                            
                                                                            $resultReply = mysqli_query($con,"SELECT * FROM `feedbackreplies` WHERE `CommentID` = '$CommentIDFeedback'");
                                    
                                                                            while($resReply = mysqli_fetch_array($resultReply)){
                               
                                                                            $ReplyUserID = $resReply['UserID'];
                                                                            $resultReplyUser = mysqli_query($con,"SELECT * FROM `users` WHERE `UserID` = '$ReplyUserID'");
                                                                            $resReplyUser = mysqli_fetch_array($resultReplyUser);
                                        
                                                                            $RepliedUser = $resReplyUser['FirstName'].' '.$resReplyUser['LastName'];
                                                                        ?>
                                                                                <div class="media">
                                                                                    <a class="meta-usr-img" href="javascript:void(0);">
                                                                                        <img class="rounded" src="assets/img/boy.png" height="40em" alt="pic2">
                                                                                    </a>
                                                                                    <div class="media-body">
                                                                                        <h6 class="media-heading text-warning">
                                                                                            <?php echo $RepliedUser; ?>
                                                                                            <small class="text-muted">
                                                                                                replied
                                                                                                <br>
                                                                                                <small class="text-warning"><strong> <?php echo $resReply['Date'].' '.$resReply['Time']; ?></strong></small>
                                                                                            </small>
                                                                                        </h6>

                                                                                        <p class="media-text">

                                                                                            <?php echo $resReply['Comment']; ?>
                                                                                        </p>
                                                                                    </div>
                                                                                </div>
                                                                                <hr>
                                                                                <?php 
                                                                            }
                                                                            ?>

                                                                                <div class="row mt-4 ">
                                                                                    <div class="col">
                                                                                        <form action="delegate" method="POST" class="form-group input-fields">
                                                                                            <input type="text" name="commentID" value="<?php echo $CommentIDFeedback; ?>" style="display:none;">
                                                                                            <textarea required name="ReplyText" class="form-control " id="exampleFormControlTextarea1" rows="3" placeholder="Type your reply here"></textarea>
                                                                                            <button name="replyBtn" type="submit" class="btn btn-outline-warning mt-4 float-right">Reply</button>
                                                                                        </form>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <?php
                                                                        } ?>
                                                                </div>
                                                            </div>
                                                            <?php
                                                
                                                                $UserID = $res['LoggerID'];
                                                
                                                                $resultCountofComplaints = mysqli_query($con,"SELECT COUNT(id) AS Total FROM `complaints` WHERE `LoggerID` = '$UserID'");
                                                                $resCountofComplaints = mysqli_fetch_array($resultCountofComplaints);
                                                            ?>
                                                            <div class="tab-pane fade" id="contact<?php echo $res['id']; ?>" role="tabpanel" aria-labelledby="contact-tab">
                                                                <div class="card component-card_4">
                                                                    <div class="card-body row">
                                                                        <div class="user-profile col-xl-2">
                                                                            <img src="assets/img/boy.png" class="" alt="...">
                                                                        </div>
                                                                        <div class="user-info col-xl-9 ml-3">
                                                                            <h5 class="card-user_name"><?php echo $resUser['FirstName'].' '.$resUser['LastName']; ?></h5>
                                                                            <p class="card-user_occupation"><?php echo $resUser['UserType']; ?></p>
                                                                            <div class="card-star_rating">
                                                                                <span class="badge badge-primary"><?php echo $resCountofComplaints['Total']; ?></span>
                                                                            </div>

                                                                            <div class="card-text mt-4">
                                                                                <p><span class="text-warning" style="margin-right:25px"><strong>Physical Address</strong></span>&nbsp;&nbsp;<?php echo $resUser['Address']; ?></p>
                                                                                <p><span class="text-warning" style="margin-right:45px"><strong>Email Address</strong></span>&nbsp;&nbsp;<?php echo $resUser['EmailAddress']; ?></p>
                                                                                <p><span class="text-warning" style="margin-right:30px"><strong>Contact Number</strong></span>&nbsp;&nbsp;<?php echo $resUser['ContactNumber']; ?></p>
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
