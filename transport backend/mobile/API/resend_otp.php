<?php
include("top_file.php");

if ($token == "GURU")
{
    if (isset($_REQUEST['tag'])) $tag = $_REQUEST['tag'];
    
   


if ($tag == "regenOtp") {
    $mobile = $_REQUEST['mobile'] ?? '';
    $usertype = $_REQUEST['usertype'] ?? null;

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
                array_push($data, $row);
                $success = true;
                $msg = "OTP sent to Driver";
            }

        } 
        
        else {
            
            // No usertype provided — check Petrol Pump first
            $data1 = mysqli_query($con, "SELECT * FROM m_petrol_pump WHERE mobile_no='$mobile'");
            $row = mysqli_fetch_assoc($data1);
            if ($row) {
                $usertype = '3';
                $row['usertype'] = $usertype;
                array_push($data, $row);
                $success = true;
                $msg = "OTP sent to Petrol Pump";
            } 
            
           else {
    
            $data1 = mysqli_query($con, "SELECT * FROM m_userlogin WHERE mobile='$mobile'");
            $row = mysqli_fetch_assoc($data1);
        
            if ($row) {
                if ($row['user_type'] == 'admin') {
                    $usertype = '4';
                    $msg = "OTP sent to Admin";
                } elseif ($row['user_type'] == 'user') {
                    $usertype = '5';
                    $msg = "OTP sent to General User";
                } else {
                    $usertype = '6';
                    $msg = "OTP sent to Employee";
                }
        
                $row['usertype'] = $usertype;
                array_push($data, $row);
                $success = true;
            }
         }

        }

        if ($success) {
            // Update OTP in DB
            mysqli_query($con, "UPDATE get_otp SET mobile_otp = '$otp'");

            // Send OTP via SMS API (do not return $result to frontend)
            $smsMsg = "Your OTP is:\nOtp :- $otp";
            $smsData = "apikey=fc86f138d94c456ea7fae49bcfddee87&mobile=$mobile&msg=" . urlencode($smsMsg);
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
    } else {
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