<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>Complaint Tracker </title>
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
                <div class="form-container mt-5 mb-5">
                    <div class="form-content">

                        <h1 class="">Register</h1>
                        <p class="signup-link register">Already have an account? <a href="login">Log in</a></p>
                        <form class="text-left" action="register" method="POST">
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
                                    <label for="contactNumber">Contact Number</label>
                                    <input class="form-control" type="text" <?php if(isset($_POST['register'])){ echo 'value="'.$_POST['contactNumber'].'"';} ?> id="contactNumber" name="contactNumber" required="" placeholder="Contact Number">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="Address">Physical Address</label>
                                    <input class="form-control" type="text" id="Address" <?php if(isset($_POST['register'])){ echo 'value="'.$_POST['physicalAddress'].'"';} ?> name="physicalAddress" required="" placeholder="Physical address">
                                </div>

                                <div class="field-wrapper terms_condition">
                                    <div class="n-chk">
                                        <label class="new-control new-checkbox checkbox-primary">
                                            <input type="checkbox" required class="new-control-input">
                                            <span class="new-control-indicator"></span><span>I agree to the <a href="javascript:void(0);"> terms and conditions </a></span>
                                        </label>
                                    </div>

                                </div>

                                <div class="d-sm-flex justify-content-between">
                                    <div class="field-wrapper">
                                        <button type="submit" name="register" class="btn btn-outline-warning" value="">Get Started!</button>
                                    </div>
                                </div>

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
    <script src="assets/js/forms/bootstrap_validation/bs_validation_script.js"></script>
    <!-- END GLOBAL MANDATORY SCRIPTS -->
    <script src="assets/js/authentication/form-2.js"></script>

</body>

</html>
<?php 

if(isset($_POST['register'])){
	
require_once('connect.php');
    
$FirstName = mysqli_real_escape_string($con,$_POST['FirstName']);
$LastName = mysqli_real_escape_string($con,$_POST['LastName']);
$EmailAddress = mysqli_real_escape_string($con,$_POST['emailAddress']);
$ContactNumber = mysqli_real_escape_string($con,$_POST['contactNumber']);
$Password = mysqli_real_escape_string($con,$_POST['password']);
$ConfirmPassword = mysqli_real_escape_string($con,$_POST['confirmPassword']);
$PhysicalAddress = mysqli_real_escape_string($con,$_POST['physicalAddress']);  
    
$uniqUser = uniqid();
$UserID = md5($uniqUser);    

if($Password == $ConfirmPassword){
    
$result = mysqli_query($con,"SELECT * FROM `users` WHERE `EmailAddress` = '$EmailAddress' AND `UserType` = 'Citizen'");
    
if(!mysqli_num_rows($result)){
    
$result = mysqli_query($con,"SELECT * FROM `users` WHERE `EmailAddress` = '$EmailAddress'");
    
if(!mysqli_num_rows($result)){

if(mysqli_query($con,"INSERT INTO `users` (`UserID`,  `FirstName`,   `LastName`, `EmailAddress`, `Password`,  `Address`, `UserType`, `ContactNumber`) VALUES ('$UserID','$FirstName','$LastName','$EmailAddress','$Password','$PhysicalAddress','Citizen','$ContactNumber')")){
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
                                                        <strong> We may need to send you critical information about our service and it is important that we have an accurate email address. </strong>
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
    window.location.href = "email";

</script>
<?php
}else{
	?>
<script>
    Snackbar.show({
        text: 'There was an issue while trying to register your account. Please try again later.',
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

if(mysqli_query($con,"UPDATE `users` SET `Password` = '$Password', `Address` = '$PhysicalAddress', `ContactNumber` = '$ContactNumber' WHERE `UserID` = '$UserID'")){
  
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
                                                        <strong> We may need to send you critical information about our service and it is important that we have an accurate email address. </strong>
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
    window.location.href = "email";

</script>
<?php
    }else{
	?>
<script>
    Snackbar.show({
        text: 'There was an issue while trying to update your existing details. Please try again later.',
        pos: 'top-right',
        actionTextColor: '#fff',
        backgroundColor: '#B71C1C'
    });

</script>
<?php
}
}
}else{
    ?>
<script>
    Snackbar.show({
        text: 'User already exist.',
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

?>
