<?php
include("top_file.php");

if ($token == "GURU")
{
    if (isset($_REQUEST['tag'])) $tag = $_REQUEST['tag'];
    if ($tag == "user_type"){
        if (isset($_REQUEST['userType'])) $user_Type = $_REQUEST['userType'];
        
        if($user_Type =='1'){
            $sql = mysqli_query($con,"select * from  m_vehicle_owner ");
            while ($row = mysqli_fetch_row($sql)) {
                array_push($data,$row);
                $success = true;
                $msg = "logged in successfully";
            }
        }
        else if($user_Type =='2'){
            $sql = mysqli_query($con,"select * from  m_driver ");
            while ($row = mysqli_fetch_row($sql)) {
                array_push($data,$row);
                $success = true;
                $msg = "logged in successfully";
            }
            
        }
        else if($user_Type =='3'){
            $sql = mysqli_query($con,"select * from  m_petrol_pump ");
            while ($row = mysqli_fetch_row($sql)) {
                array_push($data,$row);
                $success = true;
                $msg = "logged in successfully";
            }
            
        }
        else if($user_Type =='4'){
            $sql = mysqli_query($con,"select * from  m_employee ");
            while ($row = mysqli_fetch_row($sql)) {
                array_push($data,$row);
                $success = true;
                $msg = "logged in successfully";
            }
            
        }
        else{
                $success = true;
                $msg = "record not found";
            }
    }
    
    if ($tag == "user_mobile"){
        if (isset($_REQUEST['userType'])) $user_Type = $_REQUEST['userType'];
        if (isset($_REQUEST['username'])) $user_name = $_REQUEST['username'];
       
        if ($user_Type == '1') {
    $sql = mysqli_query($con, "SELECT mobileno1 FROM m_vehicle_owner WHERE owner_id = '$user_name'");
    while ($row = mysqli_fetch_assoc($sql)) {
        $mobile = $row['mobileno1']; // ✅ get actual mobile from DB
        // $otp = rand(1000, 9999);     // ✅ corrected spelling
         
        // // Update OTP in table (add WHERE clause if needed)
        // $updateOtp = mysqli_query($con, "UPDATE get_otp SET mobile_otp = '$otp'");

        // // Prepare and send SMS
        // $url = "http://api.iconicsolution.co.in/wapp/api/send?";
        // $msg = "Your OTP is:\nOtp :- $otp";
        // $data = "apikey=fc86f138d94c456ea7fae49bcfddee87&mobile=$mobile&msg=$msg";

        // $ch = curl_init();
        // curl_setopt($ch, CURLOPT_URL, $url);
        // curl_setopt($ch, CURLOPT_POST, 1);
        // curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
        // curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // $result = curl_exec($ch);

        array_push($data1, $row);
        $success = true;
        $msg = "Logged in successfully";
    }
}

        
        else if($user_Type =='2'){
            $sql = mysqli_query($con,"select * from  m_driver where driver_id='$user_name'");
            while ($row = mysqli_fetch_row($sql)) {
                $mobile = '6268941978';
                //  $otp = rang(1000,9999);
                //  $sql = mysqli_query($con, "update get_otp set mobile_otp='$otp'");
        
                // $url = "http://api.iconicsolution.co.in/wapp/api/send?";
                // $msg = "Your Otp is .\nOtp :- $otp";
                //  $data = "apikey=fc86f138d94c456ea7fae49bcfddee87&mobile=$mobile&msg=$msg";
                //  $ch = curl_init();
                // curl_setopt($ch, CURLOPT_URL, $url);
                // curl_setopt($ch, CURLOPT_POST, 1);
                // curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));   
                // curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
                // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                //  $result = curl_exec($ch);
                array_push($data1,$row);
                $success = true;
                $msg = "logged in successfully";
                array_push($data,$row);
                $success = true;
                $msg = "logged in successfully";
            }
            
        }
        else if($user_Type =='3'){
            $sql = mysqli_query($con,"select * from  m_petrol_pump where pump_id='$user_name'");
            while ($row = mysqli_fetch_row($sql)) {
                $mobile = $row['mobile_no'];
                //  $otp = rang(1000,9999);
                //  $sql = mysqli_query($con, "update get_otp set mobile_otp='$otp'");
        
                // $url = "http://api.iconicsolution.co.in/wapp/api/send?";
                // $msg = "Your Otp is .\nOtp :- $otp";
                //  $data = "apikey=fc86f138d94c456ea7fae49bcfddee87&mobile=$mobile&msg=$msg";
                //  $ch = curl_init();
                // curl_setopt($ch, CURLOPT_URL, $url);
                // curl_setopt($ch, CURLOPT_POST, 1);
                // curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));   
                // curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
                // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                //  $result = curl_exec($ch);
                array_push($data1,$row);
                $success = true;
                $msg = "logged in successfully";
                array_push($data,$row);
                $success = true;
                $msg = "logged in successfully";
            }
            
        }
        else if($user_Type =='4'){
            $sql = mysqli_query($con,"select * from  m_userlogin  where user_type='user' and user_id='$user_name'");
            while ($row = mysqli_fetch_row($sql)) {
                $mobile = $row['mobile'];
               
                array_push($data1,$row);
                $success = true;
                $msg = "logged in successfully";
                array_push($data,$row);
                $success = true; 
                $msg = "logged in successfully";
            }
            
        }
        else{
                $success = true;
                $msg = "record not found";
            }
    }
    
    
    // if ($tag == "create_password"){
    //     if (isset($_REQUEST['usertype'])) $user_Type = $_REQUEST['usertype'];
    //     if (isset($_REQUEST['userid'])) $user_id = $_REQUEST['userid'];
    //     if (isset($_REQUEST['password'])) $password = $_REQUEST['password'];
    //     if (isset($_REQUEST['mobile'])) $mobile = $_REQUEST['mobile'];
        
    //     if ($user_Type == '1') {
            
    //     $checkSql = mysqli_query($con, "SELECT * FROM m_vehicle_owner WHERE owner_id = '$user_id' AND mobileno1 = '$mobile'");
        
    //     if(mysqli_num_rows($checkSql) <= 0){
    //             $success = false;
    //             $msg = "your mobile number is not register  in our database please contact to admin.";
    //           }
               
    //     if (mysqli_num_rows($checkSql) > 0) {
    //         $userRow = mysqli_fetch_assoc($checkSql);
    
    //             if (!empty($userRow['password'])) {
    //                 // Password already set
                    
    //                 $success = false;
    //                 $msg = "Your account is already created. Please login or use forgot password.";
    //             } 
    //             else {
    //                 // Password not set, update it
    //                 $update = mysqli_query($con, "UPDATE m_vehicle_owner SET password = '$password' WHERE owner_id = '$user_id'");
        
    //                 if ($update) {
    //                      $success = true;
    //                      $msg = "Password updated successfully.";
    //                     $url = "http://api.iconicsolution.co.in/wapp/api/send?";
    //                     $msg = "Your id password is:\nusername :- $mobile\npassword :-$password";
    //                     $data = "apikey=fc86f138d94c456ea7fae49bcfddee87&mobile=$mobile&msg=$msg";
                
    //                     $ch = curl_init();
    //                     curl_setopt($ch, CURLOPT_URL, $url);
    //                     curl_setopt($ch, CURLOPT_POST, 1);
    //                     curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
    //                     curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    //                     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //                     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    //                     $result = curl_exec($ch);
                       
    //                 } else {
    //                     $success = false;
    //                     $msg = "Failed to update password.";
    //                 }
    //             }
    //           }
                
    //         }
    //     else if($user_Type =='2'){
            
    //         $checkSql = mysqli_query($con, "SELECT * FROM m_driver WHERE driver_id = '$user_id' AND mobile_no = '$mobile'");
    //         if(mysqli_num_rows($checkSql) <= 0){
    //             $success = false;
    //             $msg = "your mobile number is not register  in our database please contact to admin.";
    //           }
    //      else if (mysqli_num_rows($checkSql) > 0) {
    //         $userRow = mysqli_fetch_assoc($checkSql);
    
    //             if (!empty($userRow['password'])) {
    //                 // Password already set
    //                 $success = false;
    //                 $msg = "Your account is already created. Please login or use forgot password.";
    //             } 
    //             else {
    //                 // Password not set, update it
                   
    //                 $update = mysqli_query($con, "UPDATE m_driver SET password = '$password' WHERE driver_id = '$user_id'");
     
    //                 if ($update) {
    //                     $success = true;
    //                     $msg = "Password Created successfully.";
    //                 } else {
    //                     $success = false;
    //                     $msg = "Failed to update password.";
    //                 }
    //             }
    //           }
                
    //         }
    //     else if($user_Type =='3'){
           
    //         $checkSql = mysqli_query($con, "SELECT * FROM  m_petrol_pump WHERE pump_id = '$user_id' AND mobile_no = '$mobile'");
            
    //         if(mysqli_num_rows($checkSql) <= 0){
    //             $success = false;
    //             $msg = "your mobile number is not register  in our database please contact to admin.";
    //           }
               
    //     if (mysqli_num_rows($checkSql) > 0) {
    //         $userRow = mysqli_fetch_assoc($checkSql);
    
    //             if (!empty($userRow['password'])) {
    //                 // Password already set
    //                 $success = false;
    //                 $msg = "Your account is already created. Please login or use forgot password.";
    //             } 
    //             else {
    //                 // Password not set, update it
    //                 $update = mysqli_query($con, "UPDATE m_vehicle_owner SET password = '$password' WHERE pump_id = '$user_id'");
        
    //                 if ($update) {
    //                     $success = true;
    //                     $msg = "Password updated successfully.";
    //                 } else {
    //                     $success = false;
    //                     $msg = "Failed to update password.";
    //                 }
    //             }
    //           }
                
    //         }
    //     else if($user_Type =='4'){
    //         $checkSql = mysqli_query($con, "SELECT * FROM m_employee WHERE m_employee = '$user_id' AND mobile_no = '$mobile'");
            
    //         if(mysqli_num_rows($checkSql) <= 0){
    //             $success = false;
    //             $msg = "your mobile number is not register  in our database please contact to admin.";
    //           }
               
    //      if (mysqli_num_rows($checkSql) > 0) {
    //         $userRow = mysqli_fetch_assoc($checkSql);
    
    //             if (!empty($userRow['password'])) {
    //                 // Password already set
    //                 $success = false;
    //                 $msg = "Your account is already created. Please login or use forgot password.";
    //             } 
    //             else {
    //                 // Password not set, update it
    //                 $update = mysqli_query($con, "UPDATE m_vehicle_owner SET password = '$password' WHERE m_employee = '$user_id'");
        
    //                 if ($update) {
    //                     $success = true;
    //                     $msg = "Password updated successfully.";
    //                 } else {
    //                     $success = false;
    //                     $msg = "Failed to update password.";
    //                 }
    //             }
    //           }
                
    //         }
    //     else{
    //             $success = true;
    //             $msg = "record not found";
    //         }
    // }
    
    if ($tag == 'varify_otp') {
    if (isset($_REQUEST['otp'])) $otp = $_REQUEST['otp'];
   
    $data = [];
    $success = false;
    $msg = '';

    if (!empty($otp)) {
        // Fetch OTP from DB for the given user
        $sql = mysqli_query($con, "SELECT mobile_otp FROM get_otp");
        if (mysqli_num_rows($sql) > 0) {
            $row = mysqli_fetch_assoc($sql);
            $storedOtp = $row['mobile_otp'];

            if ($storedOtp == $otp) {
                $success = true;
                $msg = "OTP Verified Successfully";
                $status = "200";
            } else {
                $success = false;
                $msg = "Invalid OTP";
                
            }
        } 
    } else {
        $msg = "Missing parameters";
    }


}

// if ($tag == "genOtp"){
//     if (isset($_REQUEST['mobile'])) $mobile = $_REQUEST['mobile'];
//     $otp = rand(1000, 9999);     // ✅ corrected spelling
         
//         // Update OTP in table (add WHERE clause if needed)
//         $updateOtp = mysqli_query($con, "UPDATE get_otp SET mobile_otp = '$otp'");

//         // Prepare and send SMS
//         $url = "http://api.iconicsolution.co.in/wapp/api/send?";
//         $msg = "Your OTP is:\nOtp :- $otp";
//         $data = "apikey=fc86f138d94c456ea7fae49bcfddee87&mobile=$mobile&msg=$msg";

//         $ch = curl_init();
//         curl_setopt($ch, CURLOPT_URL, $url);
//         curl_setopt($ch, CURLOPT_POST, 1);
//         curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
//         curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
//         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//         curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
//         $result = curl_exec($ch);
//         $success = true;
//       $msg = "OTP Verified Successfully";

// }

}
else{
    $success = false;
            $msg = "Incorrect Location";
}
include('footer.php');
?>