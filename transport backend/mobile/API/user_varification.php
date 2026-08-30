<?php
include("top_file.php");

if ($token == "GURU")
{
    if (isset($_REQUEST['tag'])) $tag = $_REQUEST['tag'];
    
   if ($tag == 'user_id') {
    if (isset($_REQUEST['mobile'])) $mobile = $_REQUEST['mobile'];

    $success = false;
    $msg = '';
    $data = [];

    if (!empty($mobile)) {
        // Fetch from m_driver
        $sql1 = mysqli_query($con, "SELECT * FROM m_driver WHERE mobile_no = '$mobile'");
        while ($row = mysqli_fetch_assoc($sql1)) {
            $row['user_type'] = 'driver'; // optional: to identify table
            array_push($data, $row);
        }

        // Fetch from vehicle_owner
        $sql2 = mysqli_query($con, "SELECT * FROM m_vehicle_owner WHERE mobileno1 = '$mobile'");
        while ($row = mysqli_fetch_assoc($sql2)) {
            $row['user_type'] = 'vehicle_owner';
            array_push($data, $row);
        }

        // Fetch from user
        $sql3 = mysqli_query($con, "SELECT * FROM m_userlogin WHERE mobile = '$mobile'");
        while ($row = mysqli_fetch_assoc($sql3)) {
            $row['user_type'] = 'user';
            array_push($data, $row);
        }

        // Fetch from petrol_pump
        $sql4 = mysqli_query($con, "SELECT * FROM m_petrol_pump WHERE mobile_no = '$mobile'");
        while ($row = mysqli_fetch_assoc($sql4)) {
            $row['user_type'] = 'petrol_pump';
            array_push($data, $row);
        }

        if (!empty($data)) {
            $success = true;
            $msg = "logged in successfully";
        } else {
            $msg = "mobile num is not found";
        }
    } else {
        $msg = "Mobile number is required";
    }

    
}


if ($tag == "genOtp") {
    $mobile = $_REQUEST['mobile'] ?? '';
    $usertype = $_REQUEST['usertype'] ?? null;
    $compid = $_REQUEST['comp_id'] ?? '';
    $sessionid = $_REQUEST['sessionid'] ?? '';
    

    $otp = rand(1000, 9999);
    $data = [];
    $success = false;
    $msg = "Your Mobile  is not register in Guru Associate";

    if (!empty($mobile)) {
        if ($usertype == '1') {
            // Vehicle Owner
        //   echo "SELECT * FROM m_vehicle_owner WHERE mobileno1='$mobile'"; die;
            $data1 = mysqli_query($con, "SELECT * FROM m_vehicle_owner WHERE mobileno1='$mobile'");
            $row = mysqli_fetch_assoc($data1);
            if ($row) {
                $row['usertype'] = $usertype;
                $row['comp_id'] = $compid;
                $row['sessionid'] = $sessionid;
                array_push($data, $row);
                $success = true;
                $msg = "OTP sent to Vehicle Owner";
            }

        } 
        
        elseif ($usertype == '2') {
            // Driver
        
            $data1 = mysqli_query($con, "SELECT * FROM m_driver WHERE mobile_no='$mobile'");
            $row = mysqli_fetch_assoc($data1);
            if ($row) {
                $row['usertype'] = $usertype;
                 $row['comp_id'] = $compid;
                $row['sessionid'] = $sessionid;
                array_push($data, $row);
                $success = true;
                $msg = "OTP sent to Driver";
            }

        } 
        
        else {
            
            $data1 = mysqli_query($con, "SELECT * FROM m_vehicle_owner WHERE mobileno1='$mobile'");
            $row = mysqli_fetch_assoc($data1);
            if ($row) {
                $row['usertype'] = '1';
                 $row['comp_id'] = $compid;
                $row['sessionid'] = $sessionid;
                array_push($data, $row);
                $success = true;
                $msg = "OTP sent to Vehicle Owner";
            }
            
            // No usertype provided — check Petrol Pump first
            if (!$success) {
                $data1 = mysqli_query($con, "SELECT * FROM m_driver WHERE mobile_no='$mobile'");
                $row = mysqli_fetch_assoc($data1);
                if ($row) {
                    $row['usertype'] = '2';
                     $row['comp_id'] = $compid;
                $row['sessionid'] = $sessionid;
                    array_push($data, $row);
                    $success = true;
                    $msg = "OTP sent to Driver";
                }
            }
            
            if (!$success) {
                $data1 = mysqli_query($con, "SELECT * FROM m_petrol_pump WHERE mobile_no='$mobile'");
                $row = mysqli_fetch_assoc($data1);
                if ($row) {
                    $row['usertype'] = '3';
                     $row['comp_id'] = $compid;
                $row['sessionid'] = $sessionid;
                    array_push($data, $row);
                    $success = true;
                    $msg = "OTP sent to Petrol Pump";
                }
            }
            
           if (!$success) {
                $data1 = mysqli_query($con, "SELECT * FROM m_userlogin WHERE mobile='$mobile'");
                $row = mysqli_fetch_assoc($data1);
                if ($row) {
                    if ($row['user_type'] == 'admin') {
                        $row['usertype'] = '4';
                        $msg = "OTP sent to Admin";
                    } elseif ($row['user_type'] == 'user') {
                        $row['usertype'] = '5';
                        $msg = "OTP sent to General User";
                    } else {
                        $row['usertype'] = '6';
                        $msg = "OTP sent to Employee";
                    }
                      $row['comp_id'] = $compid;
                      $row['sessionid'] = $sessionid;
                    array_push($data, $row);
                    $success = true;
                }
            }

        }

        if ($success) {
            //Update OTP in DB
            mysqli_query($con, "UPDATE get_otp SET mobile_otp = '$otp'");

            // // // Send OTP via SMS API (do not return $result to frontend)
            $smsMsg = "Your OTP is:\nOtp :- $otp";
            $smsData = "apikey=644ebd38d24b4ef79f25c90e728d5e74&mobile=$mobile&msg=" . urlencode($smsMsg);
            $url = "http://api.iconicsolution.co.in/wapp/api/send";

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $smsData);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_exec($ch);
            curl_close($ch);
        }
    
    } 
    else {
        $msg = "Mobile number is required";
    }
}



}
else{
    $success = false;
            $msg = "Incorrect Location";
}
include('footer.php');
?>