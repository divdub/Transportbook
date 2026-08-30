<?php 
include("../dbinfo.php");
include ('inc/head.php');


?> 
<body class="gradiant-bg">
	<div class="page-wraper">

		<!-- Preloader -->
		<div id="preloader">
			<div class="spinner"></div>
		</div>
		<!-- Preloader end-->

		<!-- Welcome Start -->
		<div class="content-body">
			<div class="container vh-100">
				<div class="welcome-area">
					<div class="bg-image bg-image-overlay" style="background-image: url(assets/images/login/banner.jpg);"></div>
					<div class="join-area">
						<div class="started">
							<h1 class="title">GURU ASSOCIATES</h1>
							<!-- <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor</p> -->
						</div>
				
							<form action="check_login.php" method='post' name="login" class='form-validate' id="test">
							<div class="mb-3 input-group input-group-icon">
								<span class="input-group-text">
									<div class="input-icon">
										<svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512" fill="#fff"><path d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512H418.3c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304H178.3z"/></svg>
									</div>
								</span>
								<!-- <input type="text" class="form-control" placeholder="User Name"> -->
								<input type="number" class="form-control" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="10" placeholder="Enter your mobile no." value="<?php if(isset($_COOKIE["mobile"])) { echo $_COOKIE["mobile"]; } ?>" id="mobile" name="mobile" class="validate">
								<!-- <input type="text" name='user_name' placeholder="User Name" class='form-control' value="<?php if(isset($_COOKIE["user_name"])) { echo $_COOKIE["user_name"]; } ?>"> -->
							</div>
							<div class="mb-3 input-group input-group-icon">
								<span class="input-group-text">
									<div class="input-icon">
										<svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512" fill="#fff"><path d="M144 144v48H304V144c0-44.2-35.8-80-80-80s-80 35.8-80 80zM80 192V144C80 64.5 144.5 0 224 0s144 64.5 144 144v48h16c35.3 0 64 28.7 64 64V448c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V256c0-35.3 28.7-64 64-64H80z"/></svg>
									</div>
								</span>
								<!-- <input type="password" class="form-control " placeholder="Password"> -->
								<input type="password" name="password" placeholder="Password" class='form-control dz-password' data-rule-required="true" value="<?php if(isset($_COOKIE["password"])) { echo $_COOKIE["password"]; } ?>">
								<span class="input-group-text show-pass"> 
									<i class="fa fa-eye-slash text-primary"></i>
									<i class="fa fa-eye text-primary"></i>
								</span>
							</div>
							<div class="mb-3 input-group input-group-icon custom-icon-select">
								<span class="input-group-text">
									<div class="input-icon">
										<svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 640 512" fill="#fff">
											<path d="M64 104v88h96V96H72c-4.4 0-8 3.6-8 8zm482 88L465.1 96H384v96H546zm-226 0V96H224v96h96zM592 384H576c0 53-43 96-96 96s-96-43-96-96H256c0 53-43 96-96 96s-96-43-96-96H48c-26.5 0-48-21.5-48-48V104C0 64.2 32.2 32 72 32H192 352 465.1c18.9 0 36.8 8.3 49 22.8L625 186.5c9.7 11.5 15 26.1 15 41.2V336c0 26.5-21.5 48-48 48zm-64 0a48 48 0 1 0 -96 0 48 48 0 1 0 96 0zM160 432a48 48 0 1 0 0-96 48 48 0 1 0 0 96z"/>
										</svg>
									</div>
								</span>
								
								<select name="comp_id" id="comp_id" class="form-select custom-select" aria-label="Default select example">
							    <?php
						$res = mysqli_query($connection,"Select comp_id,cname from m_company order by comp_id desc");
						if($res)
						{
							while($row = mysqli_fetch_array($res))
							{
						?>
                        <option value="<?php echo $row['comp_id']; ?>"><?php echo $row['cname']; ?></option>
                        <?php
							}
						}
						?>
										
						</select>	
						
							</div>
							<div class="mb-3 input-group input-group-icon custom-icon-select">
								<span class="input-group-text">
									<div class="input-icon">
										<svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512" fill="#fff"><path d="M96 32V64H48C21.5 64 0 85.5 0 112v48H448V112c0-26.5-21.5-48-48-48H352V32c0-17.7-14.3-32-32-32s-32 14.3-32 32V64H160V32c0-17.7-14.3-32-32-32S96 14.3 96 32zM448 192H0V464c0 26.5 21.5 48 48 48H400c26.5 0 48-21.5 48-48V192z"/></svg>
									</div>
								</span>
								
								<select name="session_id" id="session_id" class='form-control custom-select' aria-label="Default select example">

                           <?php
						$res = mysqli_query($connection,"Select session_id,session_name from m_session order by session_id desc");
						if($res)
						{
							while($row = mysqli_fetch_array($res))
							{
						?>
                        <option value="<?php echo $row['session_id']; ?>"><?php echo $row['session_name']; ?></option>
                        <?php
							}
						}
						?>
											
										
						</select>						
					
							</div>
							<div class="mb-3 input-group input-group-icon custom-icon-select">
								<span class="input-group-text">
									<div class="input-icon">
										<svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 384 512" fill="#fff"><<path d="M48 0C21.5 0 0 21.5 0 48V464c0 26.5 21.5 48 48 48h96V432c0-26.5 21.5-48 48-48s48 21.5 48 48v80h96c26.5 0 48-21.5 48-48V48c0-26.5-21.5-48-48-48H48zM64 240c0-8.8 7.2-16 16-16h32c8.8 0 16 7.2 16 16v32c0 8.8-7.2 16-16 16H80c-8.8 0-16-7.2-16-16V240zm112-16h32c8.8 0 16 7.2 16 16v32c0 8.8-7.2 16-16 16H176c-8.8 0-16-7.2-16-16V240c0-8.8 7.2-16 16-16zm80 16c0-8.8 7.2-16 16-16h32c8.8 0 16 7.2 16 16v32c0 8.8-7.2 16-16 16H272c-8.8 0-16-7.2-16-16V240zM80 96h32c8.8 0 16 7.2 16 16v32c0 8.8-7.2 16-16 16H80c-8.8 0-16-7.2-16-16V112c0-8.8 7.2-16 16-16zm80 16c0-8.8 7.2-16 16-16h32c8.8 0 16 7.2 16 16v32c0 8.8-7.2 16-16 16H176c-8.8 0-16-7.2-16-16V112zM272 96h32c8.8 0 16 7.2 16 16v32c0 8.8-7.2 16-16 16H272c-8.8 0-16-7.2-16-16V112c0-8.8 7.2-16 16-16z"/></svg>
									</div>
								</span>
							
								<select name="consignor_id" id="consignor_id" class="form-control custom-select" aria-label="Default select example"  >
<!--<option value="0">                        ALL   </option>-->
                           <?php
						$res = mysqli_query($connection,"Select * from m_consignor order by consignor_id desc");
						if($res)
						{
							while($row = mysqli_fetch_array($res))
							{
						?>
                        <option value="<?php echo $row['consignor_id']; ?>"><?php echo $row['consignor_name']; ?></option>
                        <?php
							}
						}
						?>
											
										
						</select>		
							</div>
						
						<!--<a href="forgot-password.php" class="btn-link d-block mb-3 text-end text-underline">Forgot Password</a>	-->
						<!-- <a href="dashboard.php" class="btn btn-primary btn-block mb-3">SIGN IN</a> -->
											<input type="submit" value="SIGN IN" name="login" class="btn btn-primary btn-block mb-3">
											</form>
					</div>
				</div>
			</div>
		</div>
		<!-- Welcome End -->

	</div>
	<?php include ('inc/footer.php');?> 
