<?php
include("../adminsession.php"); // your DB connection

// Get POST values and sanitize
$xconsignee_name = mysqli_real_escape_string($connection, trim($_POST['xconsignee_name']));
$mobile_no = mysqli_real_escape_string($connection, trim($_POST['mobile_no']));

$currentdate = date('Y-m-d H:i:s');

// Check for duplicate consignee name
$sqlcheckdup = mysqli_query($connection, "SELECT * FROM m_x_consignee WHERE xconsignee_name='$xconsignee_name'");
$check = mysqli_num_rows($sqlcheckdup);

if ($check > 0) {
    // Duplicate found
    echo "<div class='alert alert-danger'><strong>Error!</strong> Duplicate Record.</div>";
} else {
    // Insert new consignee
    $insert = mysqli_query($connection, "INSERT INTO m_x_consignee 
        SET xconsignee_name='$xconsignee_name',
            mobile_no='$mobile_no',
            created_date='$currentdate'");

    if ($insert) {
        // Return updated <option> list
        $res = mysqli_query($connection,"SELECT * FROM m_x_consignee ORDER BY xconsignee_id DESC");
        while($row = mysqli_fetch_array($res)) {
            echo '<option value="'.$row['xconsignee_id'].'">'.$row['xconsignee_name'].'</option>';
        }
    } else {
        echo "<div class='alert alert-danger'><strong>Error!</strong> Could not save record.</div>";
    }
}
?>
