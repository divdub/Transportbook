<?php 
include("adminsession.php");
$pagename = "show_otp.php";
$sql = mysqli_query($connection, "select otpcode from get_otp");
$row = mysqli_fetch_array($sql);
    
$otp = $row['otpcode']; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>OTP Page</title>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial, sans-serif;
}

body{
    background:linear-gradient(135deg,#4facfe,#00f2fe);
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
}

.modal{
    width:100%;
    max-width:420px;
    background:#fff;
    border-radius:20px;
    padding:35px 25px;
    text-align:center;
    box-shadow:0 10px 30px rgba(0,0,0,0.2);
}

.icon{
    width:80px;
    height:80px;
    margin:auto;
    background:#eaf4ff;
    border-radius:50%;
    display:flex;
    justify-content:center;
    align-items:center;
    font-size:40px;
}

h2{
    margin-top:20px;
    color:#333;
    font-size:30px;
}

.otp-field{
    margin-top:30px;
}

.otp-field input{
    width:100%;
    height:70px;
    border:2px solid #ddd;
    border-radius:15px;
    text-align:center;
    font-size:35px;
    font-weight:bold;
    color:#333;
    background:#f8fbff;
    outline:none;
    letter-spacing:8px;
}

.otp-field input:focus{
    border-color:#4facfe;
    box-shadow:0 0 10px rgba(79,172,254,0.4);
}


.verify-btn{
    width:100%;
    margin-top:30px;
    padding:15px;
    border:none;
    border-radius:12px;
    background:linear-gradient(135deg,#4facfe,#00c6fb);
    color:#fff;
    font-size:18px;
    font-weight:bold;
    cursor:pointer;
    transition:0.3s;
    
    /* Important */
    display:flex;
    justify-content:center;
    align-items:center;
    text-decoration:none;
    gap:10px;
}

.verify-btn:hover{
    transform:translateY(-2px);
    box-shadow:0 8px 20px rgba(0,198,251,0.3);
}

.verify-btn i{
    font-size:20px;
}


@media(max-width:480px){

    .modal{
        padding:25px 18px;
    }

    h2{
        font-size:24px;
    }

    .otp-field input{
        height:60px;
        font-size:28px;
    }
}

</style>
</head>

<body>

<div class="modal">

    <div class="icon">
        🔐
    </div>

    <h2>YOUR OTP</h2>

    <div class="otp-field">
        <input type="text" value="<?php echo $otp; ?>" readonly>
    </div>
    <a type="button" href="<?php echo $pagename; ?>" class="verify-btn"> Refresh For New OTP</a>

    

</div>

</body>
</html>