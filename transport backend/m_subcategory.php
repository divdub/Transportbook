<?php
include("adminsession.php");
error_reporting(0);
$pagename = "m_subcategory.php";

$dup = '';
if (isset($_POST['submit'])) {
    $sub_catmenu  = $_POST['sub_catmenu'];

    $menuid = $_POST['menu_id'];
    $submenu_id = $_POST['submenu_id'];
    $pagelink  = $_POST['pagelink'];
    $sub_catmenu_id  = $_POST['sub_catid'];
    if ($sub_catmenu_id == '') {
        $sqlcheckdup = mysqli_query($connection, "SELECT * FROM m_subcatmenu WHERE submenu_id='$submenu_id' && sub_catmenu ='$sub_catmenu'");

        $check = mysqli_num_rows($sqlcheckdup);
        if ($check > 0) {
            $dup = "<div class='alert alert-danger'>
   			<strong>Error!</strong> Error : Duplicate Record.
   			</div>";
        } else {

            // echo "INSERT into m_submenu set submenu ='$sub_catmenu',sub_cat ='$sub_cat',menu_id ='$menuid',pagelink ='$pagelink',createdate=Now()";die;
            mysqli_query($connection, "INSERT into m_subcatmenu set sub_catmenu ='$sub_catmenu',submenu_id ='$submenu_id',menu_id ='$menuid',pagelink ='$pagelink',createdate=Now()");
            $action = 1;
            echo "<script>location='m_subcategory.php?action=$action'</script>";
        }
    } else {
        
        mysqli_query($connection, "UPDATE m_subcatmenu set sub_catmenu ='$sub_catmenu',submenu_id ='$submenu_id',menu_id ='$menuid',pagelink ='$pagelink',updated_date=Now() WHERE submenu_id='$_GET[eid]'");
        $action = 2;
        echo "<script>location='m_subcategory.php?action=$action'</script>";
    }
}

if ($_GET['eid'] != '') {
    $sql = mysqli_query($connection, "select * from m_subcatmenu WHERE sub_catid='$_GET[eid]'");
    $row = mysqli_fetch_array($sql);
    $sub_catmenu  = $row['sub_catmenu'];
    $submenu_id  = $row['submenu_id'];
    $menuid = $row['menu_id'];
    $pagelink  = $row['pagelink'];
} else {
    $sub_catmenu  = '';
    $submenu_id  = '';
    $menuid  = '';
    $pagelink  = '';
}
?>
<!doctype html>
<html>



<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <!-- Apple devices fullscreen -->
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <!-- Apple devices fullscreen -->
    <meta names="apple-mobile-web-app-status-bar-style" content="black-translucent" />

    <!-- <title>ITEM CATEGORY MASTER</title> -->

    <?php include("inc/top-files.php"); ?>
</head>

<body>

    <?php include("inc/model.php"); ?>

    <?php include("inc/top-header.php"); ?>


    <div class="container-fluid" id="content">
        <?php include("inc/left-menu.php"); ?>

        <div id="main">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="box box-bordered box-color">
                            <div class="box-title">
                                <h3>
                                    <i class="fa fa-list"></i>Sub Category Master
                                </h3>
                            </div>
                            <div class="box-content nopadding">
                                <?php include("include/alerts.php"); ?>
                                <?php echo  $dup;  ?>
                                <form action="" method="post" class='form-horizontal form-column form-bordered'>
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="textfield" class="control-label col-sm-4"> Menu Name<span style="color: red;">*</span></label>
                                                <div class="col-sm-8">
                                                    <select data-placeholder="Choose a Country..." name="menu_id" id="menu_id" style="width:100%;" tabindex="3" class="formcent select2-me">
                                                        <option value="">Select Name</option>
                                                        <?php
                                                        $sql = mysqli_query($connection, "select * from m_menu ");
                                                        while ($row = mysqli_fetch_array($sql)) {

                                                        ?>
                                                            <option value="<?php echo $row['menu_id']; ?>"><?php echo $row['menu_name']; ?></option>

                                                        <?php } ?>
                                                        <script>
                                                            document.getElementById('menu_id').value = '<?php echo $menuid; ?>';
                                                        </script>

                                                    </select>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="textfield" class="control-label col-sm-4">Sub Menu Name<span style="color: red;">*</span></label>
                                                <div class="col-sm-8">

                                                    <select data-placeholder="Choose a Country..." name="submenu_id" id="submenu_id" style="width:100%;" tabindex="3" class="formcent select2-me">
                                                        <option value="">Select Name</option>
                                                        <?php
                                                        $sql = mysqli_query($connection, "select * from m_submenu ");
                                                        while ($row = mysqli_fetch_array($sql)) {

                                                        ?>
                                                            <option value="<?php echo $row['submenu_id']; ?>"><?php echo $row['submenu']; ?></option>

                                                        <?php } ?>
                                                        <script>
                                                            document.getElementById('submenu_id').value = '<?php echo $submenu_id; ?>';
                                                        </script>

                                                    </select>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-sm-4">

                                            <div class="form-group">
                                                <label for="textfield" class="control-label col-sm-4">Sub Category Name<span style="color: red;">*</span></label>
                                                <div class="col-sm-8">

                                                    <input type="text" name="sub_catmenu" id="sub_catmenu" value="<?php echo $sub_catmenu; ?>" tabindex="1" placeholder="Sub Category Name" class="form-control" required>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="row">

                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="textfield" class="control-label col-sm-4">Page Link<span style="color: red;">*</span></label>
                                                <div class="col-sm-8">
                                                    <input type="text" name="pagelink" id="pagelink" value="<?php echo $pagelink; ?>" tabindex="1" placeholder="Menu Name" class="form-control">
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-actions">
                                                <center>
                                                    <button type="submit" name="submit" class="btn btn-primary" tabindex="2">
                                                        Save</button>
                                                    <a href="m_submenu.php" name="reset" id="reset" class="btn btn-success" tabindex="3">Reset</a>
                                                    <input type="hidden" name="sub_catid" id="sub_catid" value="<?php echo $_GET['eid']; ?>">

                                                </center>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <p align="right" style="margin-top:7px;"> <a href="pdf_m_item_category.php" class="btn btn-primary" target="_blank">
                        <span style="font-weight:bold;text-shadow: 2px 2px 2px #000; color:#FFF">Print PDF</span></a></p>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="box box-color box-bordered">
                            <div class="box-title">
                                <h3>
                                    <i class="fa fa-table"></i>
                                    Sub Menu Master Details
                                </h3>
                            </div>
                            <div class="box-content nopadding">
                                <table class="table table-hover table-nomargin table-striped table-bordered dataTable dataTable-colvis" id="mytable">
                                    <thead>

                                        <th>S.no.</th>
                                        
                                        <th>Sub Menu Name</th>
                                        <th>Sub Category Menu Name</th>
                                        <th>PageLink</th>
                                        <th class='hidden-350'>Action</th>


                                    </thead>
                                    <tbody style="text-transform:uppercase;">
                                        <?php $sn = 1;
                                        $sql = mysqli_query($connection, "select * from m_subcatmenu  order by sub_catid  desc");
                                        while ($row = mysqli_fetch_array($sql)) {
                                            $menu_name = $cmn->getvalfield($connection, "m_submenu", "submenu", "submenu_id='$row[submenu_id]'");

                                        ?>
                                            <tr>
                                                <td><?php echo $sn++; ?></td>
                                                <td><?php echo $menu_name; ?></td>
                                                <td><?php echo $row['sub_catmenu']; ?></td>
                                                
                                                <td><?php echo $row['pagelink']; ?></td>

                                                <td>

                                                    <a href="m_subcategory.php?eid=<?php echo $row['sub_catid']; ?>" class="btn btn-magenta">
                                                        Edit
                                                    </a>
                                                    
                                                </td>
                                            <?php } ?>
                                            </tr>

                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>

</body>



</html>