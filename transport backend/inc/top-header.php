<div id="navigation">
	<div class="container-fluid">
		<a href="#" id="brand"><?php echo $cmn->getvalfield($connection, "m_company", "cname", "comp_id='$_SESSION[comp_id]'"); ?></a>
		<a class="toggle-nav" rel="tooltip" data-placement="bottom" title="Toggle navigation" onclick="openleft();">
			<i class="fa fa-bars"></i>
		</a>
		<ul class='main-nav'>
			<li class='active'>
				<a href="dashboard.php">
					<span>Dashboard</span>
				</a>
			</li>


			<?php

			$sql = mysqli_query($connection, "SELECT up.status, up.menu_id, mm.type, mm.menu_name FROM user_privilege AS up INNER JOIN m_menu AS mm ON up.menu_id = mm.menu_id WHERE up.menu_id != 0 AND up.submenu_id = 0 AND up.subcat_id = 0 AND up.user_id = '$user_id' && mm.type = 'Menu' && up.status = '1' ORDER BY up.menu_id ASC");

			while ($row = mysqli_fetch_array($sql)) {

				$menu_id   = $row['menu_id'];
				$menu_name = $row['menu_name'];

			?>

				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<?php echo $menu_name; ?> <span class="caret"></span>
					</a>

					<ul class="dropdown-menu">

						<?php
						$sql1 = mysqli_query($connection, "SELECT up.status, up.menu_id, up.submenu_id,sm.submenu, sm.menu_id, sm.pagelink FROM user_privilege AS up INNER JOIN m_submenu AS sm ON up.submenu_id = sm.submenu_id WHERE up.menu_id != 0 AND up.submenu_id != 0
                                           AND up.subcat_id = 0 AND up.user_id = '$user_id' AND sm.menu_id = '$menu_id' AND up.status = '1' ORDER BY up.submenu_id ASC");

						while ($row1 = mysqli_fetch_array($sql1)) {

							$check = $cmn->getvalfield($connection,"m_subcatmenu","COUNT(*)","submenu_id='$row1[submenu_id]'");

							if ($check > 0) {
						?>
								<li class="dropdown-submenu">
									<a href="#">
										<?php echo $row1['submenu']; ?>
									</a>

									<ul class="dropdown-menu">

										<?php
										$sql2 = mysqli_query($connection, "SELECT up.status, up.menu_id,up.submenu_id, up.subcat_id, scm.sub_catmenu, scm.pagelink  FROM user_privilege AS up  INNER JOIN m_subcatmenu AS scm ON up.subcat_id = scm.sub_catid  WHERE up.user_id='$user_id' AND up.menu_id='$menu_id'  AND up.submenu_id='$row1[submenu_id]'
                                                    AND up.subcat_id!=0 AND up.status='1'  ORDER BY up.subcat_id ASC");

										while ($row2 = mysqli_fetch_array($sql2)) {
										?>
											<li>
												<a href="<?php echo $row2['pagelink']; ?>">
													<?php echo $row2['sub_catmenu']; ?>
												</a>
											</li>
										<?php } ?>

									</ul>
								</li>

							<?php
							} else {
							?>
								<li>
									<a href="<?php echo $row1['pagelink']; ?>">
										<?php echo $row1['submenu']; ?>
									</a>
								</li>
						<?php
						}}?>
						

					</ul>
				</li>

			<?php } ?>


			<?php if ($user_type == 'admin') { ?>
				<li>
					<a href="show_otp.php">OTP</a>
				</li>
			<?php		} ?>

			<li>



				<ul>

					<?php if ($user_type == "admin") { ?>

						<select name="consignorid" class="form-control email" onchange="getDetail(this.value);" id="consignorid" data-rule-required="true">

							<option value="">-Select Consignor-</option>
							<?php

							$res = mysqli_query($connection, "Select * from m_consignor  order by consignor_name desc");


							while ($row = mysqli_fetch_array($res)) {
							?>
								<option value="<?php echo $row['consignor_id']; ?>"><?php echo $row['consignor_name']; ?></option>
						<?php }
						} ?>
						<script>
							document.getElementById('consignorid').value = '<?php echo $consignorid; ?>';
						</script>
						</select>


				</ul>
			</li>

			<li>
				<a href="dbbackup.php">
					<span>DB Backup</span>
					<!--<span class="caret"></span>-->
				</a>
			</li>
			<li>
				<a>
					<span><?php echo $session_name; ?></span>

				</a>
			</li>
		</ul>
		<div class="user">

			<div class="dropdown">
				<a href="#" class='dropdown-toggle' data-toggle="dropdown"><?php echo $cmn->getvalfield($connection, "m_userlogin", "user_name", "user_id='$_SESSION[user_id]'"); ?>
					<img src="img/demo/user-avatar.jpg" alt="">
				</a>
				<ul class="dropdown-menu pull-right">
					<li>
						<a href="user-profile.php">Update Password</a>
					</li>

					<li>
						<a href="logout.php">Sign Out</a>
					</li>
				</ul>
			</div>
		</div>
	</div>
</div>
<script>
	function getDetail(consignor_id) {
		location = "checklogin_admin.php?consignor_id=" + consignor_id;
	}
</script>