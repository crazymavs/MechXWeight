<?php
// Set timezone if needed
date_default_timezone_set('Asia/Kolkata'); // adjust to your timezone

include_once 'php/partials/global/_config.php';

$ajax_base = getBaseUrl();

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

<script src="<?= $ajax_base; ?>assets/js/xlsx.full.min.js"></script>
<script src="<?= $ajax_base; ?>assets/js/jspdf.umd.min.js"></script>

<section class="section">
	<div class="row">
		<div class="col-lg-12">

			<div class="card">
				<div class="card-body">
					<h5 class="card-title">New Solvent Yard report</h5>
					<div class="row mb-3">
						<div class="col-md-10">
							<div class="row">
								<div class="col-md-3">
									<label for="reportFromDate" class="form-label">From Date</label>
									<input type="date" class="form-control" id="reportFromDate" value="<?= $fromDate ?>">
								</div>
								<div class="col-md-3">
									<label for="reportStartTime" class="form-label">From Time</label>
									<input type="time" class="form-control" id="reportStartTime" value="<?= $fromTime ?>">
								</div>

								<div class="col-md-3">
									<label for="reportToDate" class="form-label">To Date</label>
									<input type="date" class="form-control" id="reportToDate" value="<?= $toDate ?>">
								</div>
								<div class="col-md-3">
									<label for="reportEndTime" class="form-label">To Time</label>
									<input type="time" class="form-control" id="reportEndTime" value="<?= $toTime ?>">
								</div>
							</div>
						</div>

						<div class="col-md-2">
							<div class="form-check form-switch card-title d-flex justify-content-center">
								<input class="form-check-input" type="checkbox" id="tglSplit">&nbsp;&nbsp;
								<label class="form-check-label" id="splitLabel" for="tglSplit">Split Mode</label>
							</div>

						</div>
					</div>
					<div class="row mb-3 pt-3">
						<div class="text-center">
							<button class="btn btn-primary" id="btnGetTankYardReport">Get New Solvent Yard Report&nbsp;&nbsp;<i class="fa-duotone fa-solid fa-tank-water"></i></button>
						</div>
					</div>
				</div>
			</div>

			<div class="card">
				<div class="card-body">
					<div class="card-body">
						<div class="row">
							<div class="col-md-6 col-xl-8 d-flex align-items-center">
								<h5 class="card-title">New Solvent Yard Report</h5>
							</div>
							<div class="col-md-6 col-xl-4 card-title d-flex justify-content-end">
								<button class="btn btn-primary mx-3" id="btnExportSolventYardReportXL">Export to Excel&nbsp;&nbsp;<i class="fa-duotone fa-solid fa-download"></i></button>
								<button class="btn btn-warning text-danger" data-bs-toggle="modal" data-bs-target="#mdlSolventYardReference" id="btnviewSolventYardReference">View Reference&nbsp;&nbsp;<i class="fa-duotone fa-regular fa-eye"></i></button>
							</div>
						</div>


						<div class="row mb-3">

						</div>

						<div class="table-responsive" id="dvOldSolventYardReports">
							<table class="table table-striped mt-3 mb-3 pb-3" id="varianceReport">
								<thead>
									<tr>
										<th colspan="15">
											<h5>New Solvent Yard Report from <strong><span id="osyFrom"></span></strong> to <strong><span id="osyTo"></span></strong></h5>
										</th>
									</tr>
									<tr>
										<th rowspan="2">Sl No</th>
										<th rowspan="2">Tank Identification</th>
										<th rowspan="2">Product Identification</th>
										<th rowspan="2">Input to Tank (kg)<br>A</th>
										<th rowspan="2">Opening Stock (kg)<br>B</th>
										<th rowspan="2">Output From Tank (kg)<br>C</th>
										<th rowspan="2">Closing Stock(kg)<br>A+B-C=D</th>
										<th rowspan="2">Level Transmitter Value (kg)<br>E</th>
										<th rowspan="2">Deviation b/w D & E<br>D-E</th>
										<th rowspan="2">Output Towards New Resin First Floor (kg)<br>F</th>
										<th colspan="3">Deco <br>G = G1+G2+G3</th>
										<th rowspan="2">Output Towards Wood Finish<br>H</th>
										<th rowspan="2">Deviation b/w C & F+G+H (kg)<br>C - (F+G+H)</th>
									</tr>
									<tr>
										<th>GI Process<br>G1</th>
										<th>Slurry Colourant <br>G2</th>
										<th>Slurry White <br>G3</th>
									</tr>
								</thead>
								<tbody id="newSolventYardBody">
									<!-- Data rows -->
								</tbody>
							</table>


						</div>

					</div>

				</div>
			</div>


		</div>
</section>




<!-- Modal -->
<div class="modal fade referenceModal" id="mdlSolventYardReference" tabindex="-1" aria-labelledby="referenceModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-fullscreen">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="referenceModalLabel">Report Reference for New Solvent Yard</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
		<img src="<?= $asset_base ?>assets/img/nsy.jpg" alt="New Solvent Yard">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<style>
	table {
		border-collapse: collapse;
		width: 100%;
		font-size: 12px;
	}

	th,
	td {
		border: 1px solid #000;
		padding: 4px;
		text-align: center;
	}

	th {
		background-color: #f0f0f0;
	}

	.yellow {
		background-color: yellow;
	}

	.red {
		background-color: red;
		color: white;
	}

	.heading {
		text-align: center;
		font-weight: bold;
		font-size: 16px;
		background-color: #ddd;
	}
</style>

<script>
	document.getElementById('btnExportSolventYardReportXL').addEventListener('click', function() {
		let table = document.querySelector('table');
		let workbook = XLSX.utils.table_to_book(table, {
			sheet: "New Solvent Yard Report"
		});
		XLSX.writeFile(workbook, 'New_Solvent_Yard_Report.xlsx');
	});
</script>