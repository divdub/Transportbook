<?php 
include('top_file.php');

if ($token == "GURU") {
    if (isset($_REQUEST['tag'])) $tag = $_REQUEST['tag'];

    if ($tag == "save_receipt") {
        if (isset($_REQUEST['user_id'])) $user_id = $_REQUEST['user_id'];
        if (isset($_REQUEST['dispatch_id'])) $dispatch_id = $_REQUEST['dispatch_id'];
        if (isset($_REQUEST['truck_id'])) $truck_id = $_REQUEST['truck_id'];
        if (isset($_REQUEST['fromdate'])) $fromdate1 = $_REQUEST['fromdate'];
         if (isset($_REQUEST['weight'])) $weight = $_REQUEST['weight'];
          if (isset($_REQUEST['qty'])) $qty = $_REQUEST['qty'];
           if (isset($_REQUEST['dest'])) $dest = $_REQUEST['dest'];
            if (isset($_REQUEST['rec_wt'])) $rec_wt = $_REQUEST['rec_wt'];
            if (isset($_REQUEST['rec_bag'])) $rec_bag = $_REQUEST['rec_bag'];
            if (isset($_REQUEST['unload_place'])) $unload_place = $_REQUEST['unload_place'];
        if (isset($_REQUEST['location'])) $location = $_REQUEST['location'];
         $fromdate = date('Y-m-d');
      

        $user_img = '';
        if (isset($_FILES['user_img']['name'])) {
            $ext = strtolower(pathinfo($_FILES['user_img']['name'], PATHINFO_EXTENSION)); 
            if ($ext == 'jpg' || $ext == 'jpeg' || $ext == 'png') {
                $user_img = rand(111111111, 999999999).'.'.$ext;
                move_uploaded_file($_FILES['user_img']['tmp_name'], './receipt_img/'.$user_img);
            } else {
                $success = false;
                $msg = "Please provide only jpeg or jpg or png file for Profile Image";     
            }
        }

        // Only proceed if an image was uploaded
        // if (!empty($user_img)) {
                $query = mysqli_query($con, "UPDATE dispatch_entry SET rec_wt='$rec_wt',rec_qty='$rec_bag',rec_date='$fromdate',unloading_place='$unload_place', rec_img = '$user_img'  ,online_rec_type='1',location='$location' WHERE driver_id = '$user_id' and dispatch_id='$dispatch_id'");
            if ($query && mysqli_affected_rows($con) > 0) {
                $success = true;
                $msg = "Receipt Generated  Successfully";
            } else {
                $success = false;
                $msg = "Receipt Generation Failed";
            }
        // } 
        // else {
        //     $success = false;
        //     $msg = "No image uploaded";
        // }
    }
    
     if ($tag == "save_flue_dem") {
        if (isset($_REQUEST['user_id'])) $user_id = $_REQUEST['user_id'];
        if (isset($_REQUEST['dispatch_id'])) $dispatch_id = $_REQUEST['dispatch_id'];
        if (isset($_REQUEST['time'])) $time = $_REQUEST['time'];
        if (isset($_REQUEST['slip_no'])) $slip_no = $_REQUEST['slip_no'];
        
         $fromdate = date('Y-m-d');
      

        $user_img = '';
        if (isset($_FILES['user_img']['name'])) {
            $ext = strtolower(pathinfo($_FILES['user_img']['name'], PATHINFO_EXTENSION)); 
            if ($ext == 'jpg' || $ext == 'jpeg' || $ext == 'png') {
                $user_img = rand(111111111, 999999999).'.'.$ext;
                move_uploaded_file($_FILES['user_img']['tmp_name'], './receipt_img/'.$user_img);
            } else {
                $success = false;
                $msg = "Please provide only jpeg or jpg or png file for Profile Image";     
            }
        }

        // Only proceed if an image was uploaded
        // if (!empty($user_img)) {
                $query = mysqli_query($con, "UPDATE dispatch_entry SET rec_des_date='$fromdate', des_img = '$user_img'  ,is_dis_rec='1',time='$time' WHERE  dispatch_id='$dispatch_id'");
            if ($query && mysqli_affected_rows($con) > 0) {
                $success = true;
                $msg = "Acknoweledgement   Successfully";
            } else {
                $success = false;
                $msg = "Acknoweledgement Failed";
            }
        // } 
        // else {
        //     $success = false;
        //     $msg = "No image uploaded";
        // }
    }
    
}
else {
    $success = false;
    $msg = "Incorrect token";
}

include('footer.php');
?>
