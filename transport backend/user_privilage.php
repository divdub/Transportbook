<?php
include("adminsession.php");
// $tblname = 'otherincome';
// $tblpkey = 'otherincomeid';
$pagename  = 'company_privilage.php';
$modulename = "User Privilage";


if (isset($_GET['user_id'])) {
  $user_id = $_GET['user_id'];
} else {

  $user_id = "";
}

?>

<!doctype html>
<html>

<head>
  <!-- <link href="https://unpkg.com/treeflex/dist/css/treeflex.css" rel="stylesheet"> -->
  <style>
    .form-actions {
      text-align: center;
    }

    /* RESET STYLES & HELPER CLASSES
–––––––––––––––––––––––––––––––––––––––––––––––––– */
    :root {
      --level-1: #8dccad;
      --level-2: #f5cc7f;
      --level-3: #7b9fe0;
      --level-4: #f27c8d;
      --black: black;
    }

    * {
      padding: 0;
      margin: 0;
      box-sizing: border-box;
    }

    ul {
      list-style: none;
    }

    body {
      margin: 50px 0 100px;
      text-align: center;
      /* font: 20px/1.5 "Inter", sans-serif; */
    }

    h1,
    h2,
    h3,
    h4 {
      /* font-size: 12px; */
    }

    .container {
      max-width: 800px;
      padding: 0 10px;
      margin: 0 auto;
      display: grid;
      align-items: center;
      justify-content: center;
      grid-column-gap: 20px;
      grid-template-columns: auto auto;
    }

    .rectangle {
      position: relative;
      padding: 10px;
      width: 20%;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
      font-size: 20px;
      font-weight: bold;
    }


    /* LEVEL-1 STYLES
–––––––––––––––––––––––––––––––––––––––––––––––––– */
    .level-1 {
      background: var(--level-1);
    }

    .level-1::before {
      content: "";
      position: absolute;
      top: 50%;
      left: 100%;
      transform: translateY(-50%);
      width: 20px;
      height: 2px;
      background: var(--black);
    }


    /* LEVEL-2 STYLES
–––––––––––––––––––––––––––––––––––––––––––––––––– */
    .level-2-wrapper {
      position: relative;
      padding-left: 20px;
      border-left: 2px solid var(--black);
      margin-left: 320px;
    }

    .level-2-wrapper::before {
      display: none;
      content: "";
      position: absolute;
      top: -20px;
      left: 10px;
      width: 2px;
      height: calc(100% + 40px);
      background: var(--black);
    }

    .level-2-wrapper::after {
      display: none;
      content: "";
      position: absolute;
      left: 10px;
      bottom: -20px;
      width: calc(100% - 10px);
      height: 2px;
      background: var(--black);
    }

    .level-2-wrapper>li {
      position: relative;
      display: flex;
      align-items: flex-start;
      column-gap: 20px;
      /* template-columns: auto auto; */
    }

    .level-2-wrapper>li:last-child {
      /* margin-top: 100px;
  align-items: flex-end; */
    }

    .level-2 {
      background: var(--level-2);
    }

    .level-2::before {
      content: "";
      position: absolute;
      top: 50%;
      right: 100%;
      transform: translateY(-50%);
      width: 20px;
      height: 2px;
      background: var(--black);
    }

    .level-2::after {
      content: "";
      position: absolute;
      top: 50%;
      left: 100%;
      transform: translateY(-50%);
      width: 20px;
      height: 2px;
      background: var(--black);
    }


    /* LEVEL-3 STYLES
–––––––––––––––––––––––––––––––––––––––––––––––––– */
    .level-3-wrapper {
      position: relative;
      top: 34px;
      padding-left: 20px;
      border-left: 2px solid var(--black);
    }

    .level-3-wrapper::before {
      display: none;
      content: "";
      position: absolute;
      top: 0;
      left: 10px;
      width: 2px;
      height: 100%;
      background: var(--black);
    }

    .level-3-wrapper::after {
      display: none;
      content: "";
      position: absolute;
      left: 10px;
      bottom: 0px;
      width: calc(100% - 10px);
      height: 2px;
      background: var(--black);
    }

    .level-3-wrapper>li {
      display: grid;
      grid-column-gap: 20px;
      grid-template-columns: auto auto;
    }

    .level-3-wrapper>li:last-child {
      /* margin-top: 30px; */
    }

    .level-2-wrapper>li:last-child .level-3-wrapper {
      /* top: 249px; */
    }

    .level-3 {
      background: var(--level-3);
    }

    .level-3::before {
      content: "";
      position: absolute;
      top: 50%;
      right: 100%;
      transform: translateY(-50%);
      width: 20px;
      height: 2px;
      background: var(--black);
    }

    .level-3::after {
      content: "";
      position: absolute;
      top: 50%;
      left: 100%;
      transform: translateY(-50%);
      /* width: 20px; */
      height: 2px;
      background: var(--black);
    }


    /* LEVEL-4 STYLES
–––––––––––––––––––––––––––––––––––––––––––––––––– */
    .level-4-wrapper {
      position: relative;
      top: 34px;
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      grid-column-gap: 20px;
      padding-left: 20px;
    }

    .level-4-wrapper::before {
      content: "";
      position: absolute;
      top: 0;
      left: 0;
      width: 2px;
      height: 50%;
      background: var(--black);
    }

    .level-3-wrapper>li:last-child .level-4-wrapper {
      /* top: -34px; */
    }

    .level-3-wrapper>li:last-child .level-4-wrapper::before {
      /* top: auto; */
      /* bottom: 0; */
    }

    .level-4 {
      background: var(--level-4);
    }

    .level-4::before {
      content: "";
      position: absolute;
      top: 50%;
      right: 100%;
      transform: translateY(-50%);
      width: 20px;
      height: 2px;
      background: var(--black);
    }


    /* MQ STYLES
–––––––––––––––––––––––––––––––––––––––––––––––––– */
    @media screen and (max-width: 1650px) {
      .rectangle {
        width: 150px;
      }
    }

    @media screen and (max-width: 1300px) {
      body {
        font-size: 16px;
      }

      h1,
      h2,
      h3,
      h4 {
        font-size: revert;
      }

      .rectangle {
        padding: 20px 10px;
        width: auto;
      }

      .container {
        display: block;
      }

      .level-1 {
        margin-bottom: 20px;
      }

      .level-1::before,
      .level-2::after,
      .level-3::after {
        display: none;
      }

      .level-2-wrapper::before,
      .level-2-wrapper::after,
      .level-3-wrapper::before,
      .level-3-wrapper::after,
      .level-2-wrapper>li,
      .level-3-wrapper>li {
        display: block;
      }

      .level-2-wrapper {
        padding-left: 30px;
        border-left: none;
      }

      .level-2-wrapper>li:last-child {
        margin-top: 50px;
      }

      .level-2-wrapper>li:last-child .level-3-wrapper,
      .level-3-wrapper>li:last-child .level-4-wrapper,
      .level-3-wrapper,
      .level-4-wrapper {
        /* top: 0; */
      }

      .level-3-wrapper {
        padding: 20px 0 20px 30px;
        border-left: none;
      }

      .level-3-wrapper>li:last-child {
        /* margin-top: 50px; */
      }

      .level-4-wrapper {
        padding: 20px 0 0 30px;
        grid-template-columns: repeat(2, 1fr);
      }

      .level-4-wrapper>li:first-child {
        margin-bottom: 20px;
      }

      .level-4-wrapper::before {
        left: 10px;
        height: 100%;
      }
    }


    /* FOOTER
–––––––––––––––––––––––––––––––––––––––––––––––––– */
    .page-footer {
      position: fixed;
      right: 0;
      bottom: 20px;
      font-size: 1rem;
      display: flex;
      align-items: center;
      padding: 5px;
    }

    .page-footer a {
      margin-left: 4px;
    }


    #save {
      background: #2c9e2e;
      font-weight: 100;
      font-size: 16px;
      border: 1px solid #2c9e2e;
    }

    #clear {
      background: #8a6d3b;
      font-weight: 100;
      font-size: 16px;
      border: 1px solid #8a6d3b;
      margin-left: 15px;
    }

    .alert-success {
      color: #31708f;
      background-color: #d9edf7;
      border-color: #bce8f1;
    }

    .innerdiv {
      float: left;
      width: 390px;
      margin-left: 8px;
      padding: 6px;
      height: 25px;
      /*border:1px solid #333;*/
    }

    .innerdiv>div {
      float: left;
      margin: 5px;
      width: 140px;
    }

    .text {
      margin: 5px 0 0 8px;

    }

    .col-sm-2 {
      width: 100%;
      height: 43px;
    }

    .navbar-nav {
      position: relative;
      width: 100%;
      background: #368ee0;
      color: #FFF;
      height: 35px;
    }

    .navbar-nav>li {
      font-size: 14px;
      color: #FFF;
      padding-left: 10px;
      padding-top: 7px;
      width: 105px;
    }

    .btn.btn-primary {
      width: 80px;

    }

    .formcent {
      margin-top: 6px;
      border: 1px solid #368ee0;
    }

    .text1 {
      margin: 5px 0 0 8px;
    }
  </style>
  <style>
    a.selected {
      background-color: #1F75CC;
      color: white;
      z-index: 100;
    }

    .messagepop {
      background-color: #0CF;
      border: 2px solid #000;
      cursor: default;
      display: none;
      border-radius: 5px;
      position: fixed;
      top: 50px;
      right: 0px;
      text-align: left;
      width: 230px;
      z-index: 50;

    }

    .messagepop p,
    .messagepop.div {
      border-bottom: 1px solid #EFEFEF;
      margin: 8px 0;
      padding-bottom: 8px;
    }
  </style>

</head>
<?php include("inc/top-files.php"); ?>
</head>

<body>

  <?php include("inc/model.php"); ?>

  <?php include("inc/top-header.php"); ?>




  <div class="container-fluid" id="content">
    <?php include("inc/left-menu.php"); ?>


    <div id="main">
      <div class="container-fluid">
        <!--  Basics Forms -->
        <div class="row-fluid">
          <div class="span12">
            <div class="box">
              <div class="box-title">


                <h3><i class="icon-edit"></i><?php echo $modulename; ?></h3>

              </div>

              <form method="get" action="" class='form-horizontal'>
                <div class="control-group">
                  <table class="table table-condensed table-bordered">

                    <tr>

                      <td style="text-align:left;"><strong>User Name: </strong></td>

                    </tr>
                    <tr>

                      <td>
                        <div class="col-sm-8">
                          <select data-placeholder="Choose a Country..." name="user_id" id="user_id" style="width:100px" tabindex="3" class="formcent select2-me" onChange="setid(this.value);">
                            <option value="">Select Name</option>
                            <?php
                            $sql = mysqli_query($connection, "select * from m_userlogin ");
                            while ($row = mysqli_fetch_array($sql)) {

                            ?>
                              <option value="<?php echo $row['user_id']; ?>"><?php echo $row['user_name']; ?></option>

                            <?php } ?>
                            <script>
                              document.getElementById('user_id').value = '<?php echo $user_id; ?>';
                            </script>

                          </select>
                      </td>

                    </tr>
                  </table>
                </div>
              </form>
              <div>
                <?php $sn = 1;
                $sql = mysqli_query($connection, "select * from m_menu  order by menu_id asc");
                while ($row = mysqli_fetch_array($sql)) {
                ?>
                  <ul>
                    <li>

                      <h1 class="level-1 rectangle">
                        <?php $activity1 = $cmn->getvalfield($connection, "user_privilege", "status", "user_id='$user_id' and menu_id='$row[menu_id]'  && submenu_id=0 && subcat_id=0"); ?>

                        <input class="form-check-input" type="checkbox" title="HOME" aria-label="Single checkbox One" id="status1<?php echo $row['menu_id']; ?>" name="status1" onclick="getmenuid(<?php echo $row['menu_id']; ?>,<?php echo $row['menu_id']; ?>);" <?php if ($activity1 == 1) { ?> checked <?php } ?>>

                        <!-- <input  type="hidden" title="HOME"  id="menu_id<?php echo $menusn++; ?>" name="menu_id"  value=<?php echo $row['menu_id']; ?>> -->
                        <?php echo ucfirst($row['menu_name']); ?>
                      </h1>

                      <ul class="level-2-wrapper">
                        <?php $subsn = 1;
                        $sql1 = mysqli_query($connection, "select * from m_submenu where menu_id=$row[menu_id] order by menu_id  asc");
                        while ($row1 = mysqli_fetch_array($sql1)) {

                        ?>
                          <li>

                            <h2 class="level-2 rectangle">
                              <?php $activity2 = $cmn->getvalfield($connection, "user_privilege", "status", "user_id='$user_id' and menu_id='$row[menu_id]'  && submenu_id='$row1[submenu_id]' && subcat_id=0"); ?>
                              <input class="form-check-input" type="checkbox" title="HOME" aria-label="Single checkbox One" id="status2<?php echo $row1['submenu_id']; ?>" name="status" onclick="getsubmenu_id(<?php echo $row['menu_id']; ?>,<?php echo $row1['submenu_id']; ?>,<?php echo $row1['submenu_id']; ?>);" <?php if ($activity2 == 1) { ?> checked <?php } ?>>

                              <!-- <input type="hidden"  id="submenu_id<?php echo $subsn++; ?>" name="submenu_id"  value=<?php echo $row1['submenu_id']; ?>> -->
                              <?php echo ucfirst($row1['submenu']); ?>
                            </h2>
                             
                            <ul class="level-3-wrapper">
                              <?php
                              $sql2 = mysqli_query($connection, "SELECT * FROM m_subcatmenu WHERE submenu_id='{$row1['submenu_id']}' ORDER BY sub_catid ASC");
                              while ($row2 = mysqli_fetch_array($sql2)) { ?>
                                <li>
                                  <h3 class="level-3 rectangle">
                                    <?php
                                    $activity3 = $cmn->getvalfield($connection, "user_privilege","status","user_id='$user_id' AND menu_id='{$row['menu_id']}' AND submenu_id='{$row1['submenu_id']}' AND subcat_id='{$row2['sub_catid']}'");?>
                                    
                                    <input type="checkbox" id="status3<?php echo $row2['sub_catid']; ?>" onchange="getsubcat_id( <?php echo $row['menu_id']; ?>, <?php echo $row1['submenu_id']; ?>, <?php echo $row2['sub_catid']; ?>, <?php echo $row2['sub_catid']; ?>)"<?php if($activity3==1) echo "checked"; ?>>
            
                                    <?php echo ucfirst($row2['sub_catmenu']); ?>
                                  </h3>
                                </li>
                              <?php } ?>
                            </ul>
                            

                          </li>
                        <?php } ?>

                      </ul>

                    </li>
                  </ul>
                <?php $sn++;
                } ?>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>

  </div>

  <script>
    function setid(user_id) {
      window.location.href = '?user_id=' + user_id;

    }

    function getmenuid(menu_id, id) {

      status1 = document.getElementById('status1' + id);

      var user_id = '<?php echo $user_id; ?>';

      if (status1.checked == true) {
        upval1 = '1';
      } else {
        upval1 = '0';
      }


      jQuery.ajax({
        type: 'POST',
        url: 'save_privilege.php',
        data: 'user_id=' + user_id + '&menu_id=' + menu_id + '&upval1=' + upval1,
        dataType: 'html',
        success: function(data) {

        }
      });
    }

    function getsubmenu_id(menu_id, submenu_id, id) {

      status2 = document.getElementById('status2' + id);
//  console.log(status3.checked);
      var user_id = '<?php echo $user_id; ?>';

      if (status2.checked == true) {
        upval2 = '1';
      } else {
        upval2 = '0';
      }

      jQuery.ajax({
        type: 'POST',
        url: 'save_privilege1.php',
        data: 'user_id=' + user_id + '&menu_id=' + menu_id + '&upval2=' + upval2 + '&submenu_id=' + submenu_id,
        dataType: 'html',
        success: function(data) {

        }
      });
    }

    function getsubcat_id(menu_id, submenu_id, subcat_id, id) {


      status3 = document.getElementById('status3' + id);
 
      var user_id = '<?php echo $user_id; ?>';


      if (status3.checked == true) {
        upval3 = '1';
      } else {
        upval3 = '0';
      }


      jQuery.ajax({
        type: 'POST',
        url: 'save_privilege2.php',
        data: 'user_id=' + user_id + '&menu_id=' + menu_id + '&upval3=' + upval3 + '&submenu_id=' + submenu_id + '&subcat_id=' + subcat_id,
        dataType: 'html',
        success: function(data) {

        }
      });
    }
  </script>


</body>

</html>