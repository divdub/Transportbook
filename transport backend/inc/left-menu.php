<?php 
// include("adminsession.php");

 $usercount = $cmn->getvalfield($connection, "m_userlogin", "count(user_id)", "1=1");
 $truckcount = $cmn->getvalfield($connection, "m_vehicle", "count(vehicle_id)", "1=1");
 $Consigneecount = $cmn->getvalfield($connection, "m_consignee", "count(consignee_id)",  "1=1");
 $Consignorcount = $cmn->getvalfield($connection, "m_consignor", "count(consignor_id)",  "1=1");
?>
<div id="left" class='force-full no-resize'>
			<form action="#" method="GET" class='search-form'>
				<div class="search-pane">
					<input type="text" name="search" placeholder="Search here...">
					<button type="submit">
						<i class="fa fa-search"></i>
					</button>
				</div>
			</form>
			
			
			<div class="subnav">
				<div class="subnav-title">
					<a href="#" class='toggle-subnav'>
						<i class="fa fa-angle-down"></i>
						<span>Progressbars</span>
					</a>
				</div>
				<div class="subnav-content">
					<div class="pagestats bar">
						<span>January - 2023</span>
						<div class="progress small">
							<div class="bar" style="width:40%"></div>
						</div>
					</div>
					<div class="pagestats bar">
						<span>February - 2023</span>
						<div class="progress small">
							<div class="bar bar-lightred" style="width:80%"></div>
						</div>
					</div>
					<div class="pagestats bar">
						<span>March - 2023</span>
						<div class="progress small">
							<div class="bar bar-green" style="width:20%"></div>
						</div>
					</div>
				</div>
			</div>
			<div class="subnav">
				<div class="subnav-title">
					<a href="#" class='toggle-subnav'>
						<i class="fa fa-angle-down"></i>
						<span>Quick stats</span>
					</a>
				</div>
				<div class="subnav-content">
					<ul class="quickstats">
						<li>
							<span class="value"><?php echo $usercount; ?></span>
							<span class="name">User</span>
						</li>
						<li>
							<span class="value"><?php echo $truckcount; ?></span>
							<span class="name">Truck</span>
						</li>
						<li>
							<span class="value"><?php echo $Consignorcount; ?></span>
							<span class="name">Consignor</span>
						</li>
						<li>
							<span class="value"><?php echo $Consigneecount; ?></span>
							<span class="name">Consignee</span>
						</li>
					</ul>
				</div>
			</div>
			<div class="subnav">
				<div class="subnav-title">
					<a href="#" class='toggle-subnav'>
						<i class="fa fa-angle-down"></i>
						<span>Calendar</span>
					</a>
				</div>
				<div class="subnav-content less">
					<div class="jq-datepicker"></div>
				</div>
			</div>
			
		</div>