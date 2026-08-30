<?php
error_reporting(0);
include("dbinfo.php");
if ($session_id == '') {
    $session_id = 4;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login</title>

    <link rel="stylesheet" href="css/indexcss.css">

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

</head>

<body>

    <div class="container">

        <div class="login-card">

            <div class="left">

                <div class="overlay">

                    <img src="img/clogo.png" class="logo">

                    <!-- <p class="tagline">Trust on Guru</p> -->

                    <h1><span class="t-white">GURU</span> <span class="t-gold">ASSOCIATES</span></h1>

                    <p>Transport Management System</p>
                    <div class="authorized">

                        <div class="auth-title">
                            <span></span>
                            <i class="fa-solid fa-shield-halved"></i>
                            <h4>AUTHORIZED BY</h4>
                            <span></span>
                        </div>

                     
                    <?php
                        $res = mysqli_query($connection, "Select consignor_name from m_consignor order by consignor_name desc");
                        if ($res) {
                            while ($row = mysqli_fetch_array($res)) {
                        ?>
                        <div class="auth-item">
                            <div class="auth-icon">
                                <i class="fa-solid fa-industry"></i>
                            </div>

                            <div class="auth-text">
                        

                                <h5><?php echo $row['consignor_name']; ?></h5>

                            </div>
                        </div>
                        <?php
                            }
                        }
                        ?>

                    </div>

                    <div class="features">

                        <div>
                            <i class="fa-solid fa-shield-halved"></i>
                            <span>Secured &amp; Reliable</span>
                        </div>

                        <div>
                            <i class="fa-solid fa-location-dot"></i>
                            <span>Real-time Tracking</span>
                        </div>

                        <div>
                            <i class="fa-solid fa-chart-column"></i>
                            <span>Performance Reports</span>
                        </div>

                        <div>
                            <i class="fa-solid fa-gear"></i>
                            <span>Smart Management</span>
                        </div>

                    </div>



                </div>

            </div>

            <div class="right">

                <div class="icon">
                    <i class="fa-solid fa-truck"></i>
                </div>

                <h2>Welcome Back!</h2>

                <p>Please login to continue</p>

                <form action="loginotp.php" method='post' class='form-validate' id="test">

                    <div class="input-box">

                        <i class="fa fa-user"></i>

                        <input type="text" id="user_name" name="user_name" placeholder="Username">

                    </div>

                    <div class="input-box">

                        <i class="fa fa-lock"></i>

                        <input type="password" id="password" name="password" placeholder="Password">

                    </div>

                    <select name="comp_id" id="comp_id" class='form-control'>
                        <?php
                        $res = mysqli_query($connection, "Select comp_id,cname from m_company order by comp_id desc");
                        if ($res) {
                            while ($row = mysqli_fetch_array($res)) {
                        ?>
                                <option value="<?php echo $row['comp_id']; ?>"><?php echo $row['cname']; ?></option>
                        <?php
                            }
                        }
                        ?>

                    </select>

                    <select name="session_id" id="session_id" class='form-control'>

                        <?php
                        $res = mysqli_query($connection, "Select session_id,session_name from m_session order by session_id asc");
                        if ($res) {
                            while ($row = mysqli_fetch_array($res)) {
                        ?>
                                <option value="<?php echo $row['session_id']; ?>"><?php echo $row['session_name']; ?></option>
                        <?php
                            }
                        }
                        ?>
                        <script>
                            document.getElementById('session_id').value = '<?php echo $session_id; ?>';
                        </script>

                    </select>



                    <select name="consignor_id" id="consignor_id" class='form-control' required>

                        <?php
                        $res = mysqli_query($connection, "Select * from m_consignor order by consignor_id asc");
                        if ($res) {
                            while ($row = mysqli_fetch_array($res)) {
                        ?>
                                <option value="<?php echo $row['consignor_id']; ?>"><?php echo $row['consignor_name']; ?></option>
                        <?php
                            }
                        }
                        ?>


                    </select>

                    <div class="remember">

                        <label>

                            <input type="checkbox">

                            Remember Me

                        </label>

                        <a href="#">Forgot Password?</a>

                    </div>

                    <button type="submit" name="login">

                        SIGN IN

                        <i class="fa-solid fa-arrow-right"></i>


                    </button>
                    <div class="footer">

                        Powered By

                        <strong>CHAARUVI INFOTECH PVT. LTD.</strong>

                    </div>

                </form>

            </div>

        </div>

    </div>

</body>

</html>