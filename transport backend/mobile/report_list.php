<?php include ('head.php');?> 
<?php 
$pagename ="Report List";
?>
<?php include ('header.php');?>

<!-- Welcome Start -->
<div class="content-body">
	<div class="container mb-3">
		<div class="row">
			<div class="join-area">
				<form class="filter-form">
					<div class="row">
						<div class="col-md-6 col-6">
							<div class="mb-3">
								<label for="form-check-label">From Date</label>
								<input type="date" class="form-control" placeholder="Name">
							</div>
						</div>
						<div class="col-md-6 col-6">
							<div class="mb-3">
								<label for="form-check-label">To Date</label>
								<input type="date" class="form-control" placeholder="Name">
							</div>
						</div>
					</div>
					<div class="mb-3">
						<label for="form-check-label">Truck No.</label>
						<select class="form-select" aria-label="Default select example">
							<option selected>--Select--</option>
							<option value="1">12</option>
							<option value="2">13</option>
							<option value="3">14</option>
						</select>
					</div>
				</form>
				<div class="input-group my-3">
					<input type="text" class="form-control" placeholder="Search..">
					<span class="input-group-text"> 
						<svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M23.7871 22.7761L17.9548 16.9437C19.5193 15.145 20.4665 12.7982 20.4665 10.2333C20.4665 4.58714 15.8741 0 10.2333 0C4.58714 0 0 4.59246 0 10.2333C0 15.8741 4.59246 20.4665 10.2333 20.4665C12.7982 20.4665 15.145 19.5193 16.9437 17.9548L22.7761 23.7871C22.9144 23.9255 23.1007 24 23.2816 24C23.4625 24 23.6488 23.9308 23.7871 23.7871C24.0639 23.5104 24.0639 23.0528 23.7871 22.7761ZM1.43149 10.2333C1.43149 5.38004 5.38004 1.43681 10.2279 1.43681C15.0812 1.43681 19.0244 5.38537 19.0244 10.2333C19.0244 15.0812 15.0812 19.035 10.2279 19.035C5.38004 19.035 1.43149 15.0865 1.43149 10.2333Z" fill="#FE9063"></path>
						</svg>
					</span>
				</div>
				<div class="row my-3 pagination">
					<nav aria-label="Page navigation example">
						<ul class="pagination">
							<li class="page-item"><a class="page-link" href="#">Previous</a></li>
							<li class="page-item active"><a class="page-link" href="#">1</a></li>
							<li class="page-item"><a class="page-link" href="#">2</a></li>
							<li class="page-item"><a class="page-link" href="#">3</a></li>
							<li class="page-item"><a class="page-link" href="#">Next</a></li>
						</ul>
					</nav>
				</div>
			</div>
		</div>
		<div class="row mb-3 report">
			<div class="col-12">
				<div class="card p-3">
					<div class="row report-1 d-flex justify-content-between align-items-center">
						<div class="col-4 px-3"><p>No. of Trip</p>
							<span>525</span></div>
							<div class="col-4 px-3"><p>Total Frieght</p><span>525</span></div>
							<div class="col-4 px-3"><p>Trip Exps.</p><span>525</span></div>
							
						</div>
						<hr class="my-2">
						<div class="row report-1 d-flex justify-content-between align-items-center">
							<div class="col-4 px-3"><p>Mnt. Exps.</p><span>525</span></div>
							<div class="col-4 px-3"><p>Driver Pymt. </p><span>525</span></div>
							<div class="col-4 px-3"><p>Profit & Loss</p><span>525</span></div>
						</div>
					</div>
				</div>
				<div class="col-12">
					<div class="card p-3">
						<div class="row report-1 d-flex justify-content-between align-items-center">
							<div class="col-4 px-3"><p>No. of Trip</p>
								<span>525</span></div>
								<div class="col-4 px-3"><p>Total Frieght</p><span>525</span></div>
								<div class="col-4 px-3"><p>Trip Exps.</p><span>525</span></div>

							</div>
							<hr class="my-2">
							<div class="row report-1 d-flex justify-content-between align-items-center">
								<div class="col-4 px-3"><p>Mnt. Exps.</p><span>525</span></div>
								<div class="col-4 px-3"><p>Driver Pymt. </p><span>525</span></div>
								<div class="col-4 px-3"><p>Profit & Loss</p><span>525</span></div>
							</div>
						</div>
					</div>
					<div class="col-12">
						<div class="card p-3">
							<div class="row report-1 d-flex justify-content-between align-items-center">
								<div class="col-4 px-3"><p>No. of Trip</p>
									<span>525</span></div>
									<div class="col-4 px-3"><p>Total Frieght</p><span>525</span></div>
									<div class="col-4 px-3"><p>Trip Exps.</p><span>525</span></div>
								</div>
								<hr class="my-2">
								<div class="row report-1 d-flex justify-content-between align-items-center">
									<div class="col-4 px-3"><p>Mnt. Exps.</p><span>525</span></div>
									<div class="col-4 px-3"><p>Driver Pymt. </p><span>525</span></div>
									<div class="col-4 px-3"><p>Profit & Loss</p><span>525</span></div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- Welcome End -->

			<?php include('top-footer.php');?>  
			<?php include('footer.php');?>