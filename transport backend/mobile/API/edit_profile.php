<?php 
include('top_file.php');

if ($token == "GURU") {
    if (isset($_REQUEST['tag'])) $tag = $_REQUEST['tag'];

    if ($tag == "set_img") {
        if (isset($_REQUEST['user_id'])) $user_id = $_REQUEST['user_id'];
        if (isset($_REQUEST['user_type'])) $user_type = $_REQUEST['user_type'];

        $user_img = '';
        if (isset($_FILES['user_img']['name'])) {
            $ext = strtolower(pathinfo($_FILES['user_img']['name'], PATHINFO_EXTENSION)); 
            if ($ext == 'jpg' || $ext == 'jpeg' || $ext == 'png') {
                $user_img = rand(111111111, 999999999).'.'.$ext;
                move_uploaded_file($_FILES['user_img']['tmp_name'], './profile_img/'.$user_img);
            } else {
                $success = false;
                $msg = "Please provide only jpeg or jpg or png file for Profile Image";     
            }
        }

        // Only proceed if an image was uploaded
        if (!empty($user_img)) {
            if ($user_type == '1') {
                $query = mysqli_query($con, "UPDATE m_vehicle_owner SET profile_img = '$user_img' WHERE owner_id = '$user_id'");
            } else if ($user_type == '2') {
                $query = mysqli_query($con, "UPDATE m_driver SET profile_img = '$user_img' WHERE driver_id = '$user_id'");
            } else if ($user_type == '3') {
                $query = mysqli_query($con, "UPDATE m_petrol_pump SET profile_img = '$user_img' WHERE pump_id = '$user_id'");
            } else if ($user_type == '4') {
                $query = mysqli_query($con, "UPDATE m_userlogin SET profile_img = '$user_img' WHERE user_id = '$user_id'");
            }

            if ($query && mysqli_affected_rows($con) > 0) {
                $success = true;
                $msg = "Profile image set successfully";
            } else {
                $success = false;
                $msg = "Profile image update failed";
            }
        } 
        else {
            $success = false;
            $msg = "No image uploaded";
        }
    } 
    
  
    
    
} else {
    $success = false;
    $msg = "Incorrect token";
}

include('footer.php');
?>
