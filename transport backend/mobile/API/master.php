<?php 
include('top_file.php');

if ($token == "GURU")
{

    if (isset($_REQUEST['tag'])) $tag = $_REQUEST['tag'];

    if ($tag == "company") {
    $sql = mysqli_query($con, "SELECT * FROM m_company");
    $count = mysqli_num_rows($sql);

    if ($count > 0) {
        while ($row = mysqli_fetch_assoc($sql)) {
          array_push($data, $row);
             $success = true;
           $msg = "Record Found";
        }
    } 
    else {
        $success = false;
        $msg = "Record Not Found";
    }
   }
   
   if ($tag == "session") {
    $sql = mysqli_query($con, "SELECT * FROM m_session");
    $count = mysqli_num_rows($sql);

    if ($count > 0) {
        while ($row = mysqli_fetch_assoc($sql)) {
          array_push($data, $row);
             $success = true;
           $msg = "Record Found";
        }
    } 
    else {
        $success = false;
        $msg = "Record Not Found";
    }
   }
    if ($tag == "get_otp") {
    $sql = mysqli_query($con, "SELECT * FROM get_otp");
    $count = mysqli_num_rows($sql);

    if ($count > 0) {
        while ($row = mysqli_fetch_assoc($sql)) {
          array_push($data, $row);
             $success = true;
           $msg = "Record Found";
        }
    } 
    else {
        $success = false;
        $msg = "Record Not Found";
    }
   }
}
else{
    $success = false;
            $msg = "Incorrect Location";
}
include('footer.php');
?>