<?php
// Set timezone if needed
date_default_timezone_set('Asia/Kolkata'); // adjust to your timezone

// Dates
$today = new DateTime();
$yesterday = (clone $today)->modify('-1 day');

// Format parts
$startDate = $yesterday->format('d-m-Y') . ' 08:00:00AM';
$endDate = $today->format('d-m-Y') . ' 07:59:59AM';

// HTML5 date format: YYYY-MM-DD
$fromDate = $yesterday->format('Y-m-d');
$toDate = $today->format('Y-m-d');

// HTML5 time format: HH:MM (seconds not accepted in input[type=time])
$fromTime = '08:00';
$toTime = '07:59';
?>

<section class="section dashboard">
	<div class="row">
		<div class="col-md-4 col-xxxl-3 order-md-2"><!-- Right Secion -->
			<div class="card">
				<div class="card-body">
					<div class="row mb-3">
						<div class="col-12">
							<h5 class="card-title">Front Camera</label></h5>
						</div>
					</div>

					<div class="row">
						<div class="input-group">
							<input type="text" class="form-control text-light bg-dark text-center" name="" id="indicatorWeight" readonly>
						</div>
					</div>
				</div>
			</div>

			<div class="card">
				<div class="card-body">
					<div class="row mb-3">
						<div class="col-12">
							<h5 class="card-title">Rear Camera</label></h5>
						</div>
					</div>

					<div class="row">
						<div class="input-group">
							<input type="text" class="form-control text-light bg-dark text-center" name="" id="indicatorWeight" readonly>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-8 col-xxxl-9"> <!-- Weight Secion -->
			<div class="card">
				<div class="card-body">
					<div class="row my-3">
						<div class="input-group">
							<input type="text" class="form-control text-light bg-dark text-center" name="" id="indicatorWeight" readonly value="14,980">
							<span class="input-group-text text-light bg-dark"><strong>kg</strong></span>
						</div>
					</div>
					<!-- <hr class="mt-0 pb-3"> -->
					<div class="row mb-3">
						<?php
						$form_path = "php/partials/dashboard/_create_weighment_form.php";
						if (file_exists($form_path)) {
							include_once $form_path;
						} else {
							echo "File not found: " . $form_path;
						}
						?>
					</div>
				</div>
			</div>

		</div>

	</div>
	<div class="card">
		<div class="card-body">
			<div class="row pt-3">
				<?php include_once 'php/partials/dashboard/_pending_dashboard.php'  ?>
			</div>
		</div>
	</div>

	<style>
		#indicatorWeight {
			font-size: 5rem;
			font-weight: 700;
		}
	</style>

</section>