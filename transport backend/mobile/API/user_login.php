<?php 
include('top_file.php');

if ($token == "GURU")
{

    if (isset($_REQUEST['tag'])) $tag = $_REQUEST['tag'];

    if ($tag == "login")
    {
        if (isset($_REQUEST['usertype'])) $usertype = $_REQUEST['usertype'];
        if (isset($_REQUEST['mobile'])) $mobile = $_REQUEST['mobile'];
        $otp = rand(1000, 9999);
        
        if($usertype =='1'){
         echo "select * from m_vehicle_owner where mobileno1='$mobile'";
          $data1 = mysqli_query($con,"select * from m_vehicle_owner where mobileno1='$mobile'");
        $row=mysqli_fetch_array($data1);
        $count=mysqli_num_rows($data1);
        // echo $count;die;
        if ($count>0)
        {
                      $row['usertype'] = $usertype;
                        array_push($data, $row);
                         mysqli_query($con, "UPDATE get_otp SET mobile_otp = '$otp' WHERE mobile = '$mobile'");

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
                        $success = true;
                        $msg = "logged in successfully";
        }  
        }
        
         else if($usertype =='2'){
          $data1 = mysqli_query($con,"select * from m_driver where mobile_no='$user_name' and password='$password'");
        $row=mysqli_fetch_array($data1);
        $count=mysqli_num_rows($data1);
        // echo $count;die;
        if ($count>0)
        {
                       $row['usertype'] = $usertype;
                        array_push($data, $row);
                        $success = true;
                        $msg = "logged in successfully";
        }  
        }
         else if($usertype =='3'){
          $data1 = mysqli_query($con,"select * from m_petrol_pump where mobile_no='$user_name' and password='$password'");
        $row=mysqli_fetch_array($data1);
        $count=mysqli_num_rows($data1);
        // echo $count;die;
        if ($count>0)
        {
                       $row['usertype'] = $usertype;
                        array_push($data, $row);
                        $success = true;
                        $msg = "logged in successfully";
        }  
        }
         else if($usertype =='4'){
          $data1 = mysqli_query($con,"select * from m_employee where mobile_no='$user_name' and password='$password'");
        $row=mysqli_fetch_array($data1);
        $count=mysqli_num_rows($data1);
        // echo $count;die;
        if ($count>0)
        {
                       $row['usertype'] = $usertype;
                        array_push($data, $row);
                        $success = true;
                        $msg = "logged in successfully";
        }  
        }
        else
        {
            $success = false;
            $msg = "Incorrect Username or password";
        }
    }
    
    if ($tag == "update_profile")
    {
        if (isset($_REQUEST['user_id'])) $userid = $_REQUEST['user_id'];
        if (isset($_REQUEST['mobile_no'])) $mobile = $_REQUEST['mobile_no'];
        if (isset($_REQUEST['password'])) $password = $_REQUEST['password'];

        $sql=mysqli_query($con, "update user set mobile='$mobile',password='$password' where userid='$userid'");	
		 
        if($sql){
           
            $success=true;
            $msg='Profile Updated Successfully';
           
        }
        else{
            $success=false;
            $msg='Something went wrong';
        }
    }
    
  

}
else{
    $success = false;
            $msg = "Incorrect Location";
}
include('footer.php');
?>