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

<section>
<div class="card">
		<div class="card-body">
		<div class="row mb-3">
				<div class="col-12">
					<h5 class="card-title">Batch Report for  <label id="batchHeaderStart"></label> to <label id="batchHeaderTo"></label></h5>
				</div>
			</div>

			<hr class="pb-3">
			
			<div class="row mb-3">

				<div class="col-md-3">
					<label for="dashboardFromDate" class="form-label">From Date</label>
					<input type="date" class="form-control" id="batchFromDate" value="<?= $fromDate ?>">
				</div>
				<div class="col-md-3">
					<label for="dashboardStartTime" class="form-label">From Time</label>
					<input type="time" class="form-control" id="batchStartTime" value="<?= $fromTime ?>">
				</div>

				<div class="col-md-3">
					<label for="batchToDate" class="form-label">To Date</label>
					<input type="date" class="form-control" id="batchToDate" value="<?= $toDate ?>">
				</div>
				<div class="col-md-3">
					<label for="batchEndTime" class="form-label">To Time</label>
					<input type="time" class="form-control" id="batchEndTime" value="<?= $toTime ?>">
				</div>

				<div class="row mb-3 pt-3 mt-3">
						<div class="text-center">
							<button class="btn btn-primary" id="btnBatchReport">Get Batch Data</button>
						</div>
					</div>
			</div>
		</div>
	</div>

    <div class="row">
        <div class="col-md-4 col-lg-3">
            <div class="card info-card">

                <div class="card-body">
                    <h5 class="card-title">Input to Tank<span> (kg)</span></h5>

                    <div class="d-flex align-items-center justify-content-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-box-arrow-in-down"></i>
                        </div>
                        <div class="text-center">
                            <h2><span id="inputValue">3000</span><span> kg</span></h2>

                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="col-md-4 col-lg-3">
            <div class="card info-card">

                <div class="card-body">
                    <h5 class="card-title">Output to Tank<span> (kg)</span></h5>

                    <div class="d-flex align-items-center justify-content-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-box-arrow-in-down"></i>
                        </div>
                        <div class="text-center">
                            <h2><span id="outputValue">3000</span><span> kg</span></h2>

                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="col-md-4 col-lg-3">
            <div class="card info-card">

                <div class="card-body">
                    <h5 class="card-title">Available Stock<span> (kg)</span></h5>

                    <div class="d-flex align-items-center justify-content-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-box-arrow-in-down"></i>
                        </div>
                        <div class="text-center">
                            <h2><span id="stockValue">3000</span><span> kg</span></h2>

                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="col-md-4 col-lg-3">
            <div class="card info-card">

                <div class="card-body">
                    <h5 class="card-title">Total Batches<span></span></h5>

                    <div class="d-flex align-items-center justify-content-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-box-arrow-in-down"></i>
                        </div>
                        <div class="text-center">
                            <h2 id="batchCount">5</h2>

                        </div>
                    </div>
                </div>

            </div>
        </div>

        
    </div>

    <div class="card">
		<div class="card-body">
		<div class="row mb-3">
				<div class="col-12">
					<h5 class="card-title">Batch Details</h5>
				</div>
			</div>

			<hr class="pb-3">
			
			<div class="row mb-3" id="batchTableDiv">

			</div>
		</div>
	</div>
</section>