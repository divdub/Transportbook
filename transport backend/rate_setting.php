<?php
include("adminsession.php");
$tblname = "rate_setting";
$tblpkey = "rs_id";
$pagename = "rate_setting.php";
$modulename = "Rate Setting Master";
$duplicate = '';
if (isset($_GET['action'])) {
    $action = $_GET['action'];
} else {
    $action = "";
}
if (isset($_GET['editid'])) {
    $keyvalue = $_GET['editid'];
} else {
    $keyvalue = 0;
}
if (isset($_GET['editid']) != "") {
    $keyvalue = test_input($_GET['editid']);
    $sql = mysqli_query($connection, "select * from $tblname where $tblpkey='$keyvalue'");
    $row = mysqli_fetch_array($sql);
    $place_id = $row['place_id'];
    $rate  = $row['rate'];
} else {
    $place_id = '';
    $rate  = '';
}
if (isset($_POST['submit'])) {
    $place_id = $_POST['place_id'];
    
    $rate = $_POST['rate'];
    $form_data = array('place_id' => $place_id,  'rate' => $rate, 'consignorid' => $consignorid, 'created_date' => $currentdate);

    if ($keyvalue  == 0) {
        dbRowInsert($connection, $tblname, $form_data);
        echo "<script>location='$pagename?action=1'</script>";
    } else {
        $form_data = array('place_id' => $place_id,  'rate' => $rate, 'consignorid' => $consignorid, 'updated_date' => $currentdate);
        dbRowUpdate($connection, $tblname, $form_data, "$tblpkey='$keyvalue'");
        echo "<script>location='$pagename?action=2'</script>";
    }
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

    <title>RATE SETTING :: CHAARUVI INFOTECH PVT. LTD.</title>

    <?php include("inc/top-files.php"); ?>
</head>

<body>

    <?php include("inc/model.php"); ?>

    <?php include("inc/top-header.php"); ?>


    <div class="container-fluid nav-hidden" id="content">
        <?php include("inc/left-menu.php"); ?>

        <div id="main">
            <div class="container-fluid">

                <?php include("inc/breadcrumbs.php"); ?>
                <div class="row" style="padding-top:20px;">
                    <div class="col-sm-12">
                        <?php if ($duplicate != '') { ?>
                            <div class="alert alert-warning">
                                <button data-dismiss="alert" class="close" type="button">×</button>
                                <strong><i class="fa fa-clone"></i> Warning! The value you entered is already in the list. </strong>
                            </div>
                        <?php } ?>
                        <?php include("inc/alert.php"); ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="box box-bordered box-color">
                            <div class="box-title">
                                <h3>
                                    <i class="fa fa-list"></i>Rate Setting
                                </h3>
                            </div>
                            <div class="box-content nopadding">
                                <form action="#" method="POST" class='form-horizontal form-column form-bordered'>
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="textfield" class="control-label col-sm-4">Place Name <span style="color: red">*</span></label>
                                                <div class="col-sm-8">
                                                    <select name="place_id" id="place_id" class='select2-me' style="width:100%;" required>
                                                        <option value=""> Select place </option>
                                                        <?php $sql = mysqli_query($connection, "Select * from  m_place  order by place_id ");
                                                        while ($row = mysqli_fetch_array($sql)) { ?>

                                                            <option value="<?php echo $row['place_id']; ?>"><?php echo $row['place_name']; ?></option>
                                                        <?php } ?>

                                                    </select>
                                                    <script>
                                                        document.getElementById('place_id').value = '<?php echo $place_id; ?>';
                                                    </script>
                                                </div>
                                            </div>

                                        </div>

                                        
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="textfield" class="control-label col-sm-4">Rate <span style="color: red">*</span></label>
                                                <div class="col-sm-8">
                                                    <input type="text" name="rate" id="rate" placeholder="Enter Rate" class="form-control" value="<?php echo $rate; ?>" required>
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-actions">
                                                <center>
                                                    <input type="submit" name="submit" id="submit" value="Save" class="btn btn-primary">
                                                    <a type="button" href="<?php echo $pagename; ?>" class="btn btn-red">Cancel</a>
                                                </center>
                                            </div>
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="box box-color box-bordered">
                            <div class="box-title">
                                <h3>
                                    <i class="fa fa-table"></i>
                                    Rate Details
                                </h3>
                                <!-- <a href="pdf/pdf_m_place.php" class="btn" style="float: right" target="_blank">Pdf
                                    <i class="fa fa-file-pdf-o"></i></a> &nbsp;
                                <a href="excel/excel_place.php" class="btn btn-warning" style="float: right">Excel
                                    <i class="fa fa-file-excel-o"></i></a> -->
                            </div>
                            <div class="box-content nopadding">
                                <table class="table table-hover table-nomargin dataTable dataTable-colvis">
                                    <thead>
                                        <tr>
                                            <th>Sno.</th>
                                            <th>Place Name</th>
                                            
                                            <th>Rate</th>
                                            <th class='hidden-350'>Action</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sn = 1;
                                        $sql = mysqli_query($connection, "Select * from  $tblname Where consignorid=$consignorid order by $tblpkey desc");
                                        while ($row = mysqli_fetch_array($sql)) {
                                           
                                            $place_name = $cmn->getvalfield($connection, "m_place", "place_name", "place_id=$row[place_id]");
                                        ?>
                                            <tr>
                                                <td><?php echo $sn++; ?></td>
                                                <td><?php echo $place_name;  ?></td>
                                                <td><?php echo $row['rate']; ?></td>
                                                
                                                <td class='hidden-350'>
                                                    <?php if ($user_type == 'admin') { ?>
                                                        <a href="?editid=<?php echo $row['rs_id']; ?>" class="btn btn-primary" rel="tooltip" title="Edit"><i class="fa fa-edit"></i></a>
                                                        <a href="<?php echo $pagename ?>" class="btn btn-danger" onClick="funDel(<?php echo $row['place_id']; ?>)" rel="tooltip" title="Delete"><i class="fa fa-times"></i>
                                                        <?php } ?> </a>

                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
    <script type="text/javascript">
        function funDel(id) {

            var tablename = '<?php echo $tblname ?>';
            var tableid = '<?php echo $tblpkey ?>';
            if (confirm("Do You want to Delete this record ?")) {
                // alert(tableid);
                jQuery.ajax({
                    type: 'POST',
                    url: 'ajax/delete_master.php',
                    data: 'id=' + id + '&tablename=' + tablename + '&tableid=' + tableid,
                    dataType: 'html',
                    success: function(data) {
                        location = '<?php echo $pagename ?>?action=3';

                    }
                }); //ajax close
            }
        }
    </script>
</body>



</html>