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
					<div class="row pt-3">
						<div class="input-group">
							<input type="text" class="form-control text-light bg-dark text-center" name="" id="indicatorWeight" readonly value="14,980">
							<span class="input-group-text text-light bg-dark"><strong>kg</strong></span>
						</div>
					</div>
				</div>
			</div>

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
					<div class="row">
						<div class="d-flex justify-content-between col-12">
							<h5 class="card-title">Create Weighment.</h5>
							<h5 class="card-title"><strong>Date & Time</strong>: <label id="weighmentDateTime">12-09-2025 01:01:00 PM</label></h5>
						</div>
					</div>

					<hr class="mt-0 pb-3">

					<div class="row mb-3">
						<form action="">
							<div class="row">

								<div class="col-md-6 mb-3">
									<div class="input-group">
										<span class="input-group-text"><strong>Weighment Type</strong></span>
										<select id="ddWeighmentType" class="form-select">
											<option selected="">Choose...</option>
											<option>First</option>
											<option>Second</option>
											<option>Single</option>
										</select>
									</div>
								</div>

								<div class="col-md-6 mb-3">
									<div class="input-group">
										<span class="input-group-text"><strong>Ticket No.</strong></span>
										<input type="text" class="form-control" name="" id="txtTicketNo" readonly value="0978687">
									</div>
								</div>

								<div class="col-md-6 mb-3">
									<div class="input-group">
										<span class="input-group-text"><strong>Vehicle Type</strong></span>
										<select id="ddWeighmentType" class="form-select">
											<option selected="">Choose...</option>
											<option>Lorry</option>
											<option>Multi Axle</option>
											<option>Mini Goods</option>
										</select>
									</div>
								</div>

								<div class="col-md-6 mb-3">
									<div class="input-group">
										<span class="input-group-text"><strong>Party Name</strong></span>
										<input type="text" class="form-control" name="" id="txtTicketNo" readonly value="Mechotronix">
									</div>
								</div>

								<div class="col-md-6 mb-3">
									<div class="input-group">
										<span class="input-group-text"><strong>Material</strong></span>
										<input type="text" class="form-control" name="" id="txtTicketNo" readonly value="Steel">
									</div>
								</div>

								<div class="col-md-6 mb-3">
									<div class="input-group">
										<span class="input-group-text"><strong>Charges</strong></span>
										<input type="text" class="form-control" name="" id="txtTicketNo" readonly value="100">
										<span class="input-group-text"><strong>₹</strong></span>
									</div>
								</div>

								<div class="col-md-6 mb-3">
									<div class="input-group">
										<span class="input-group-text"><strong>G/T/M/A</strong></span>
										<select id="ddWeighmentType" class="form-select">
											<option selected="">Choose...</option>
											<option>Gross</option>
											<option>Tare</option>
											<option>Manual</option>
											<option>Automatic</option>
										</select>
									</div>
								</div>

								<div class="col-md-6 mb-3">
									<div class="input-group">
										<span class="input-group-text"><strong>Gross Weight</strong></span>
										<input type="text" class="form-control" name="" id="txtTicketNo" readonly value="100">
										<span class="input-group-text"><strong>kg</strong></span>
									</div>
								</div>

								<div class="col-md-6 mb-3">
									<div class="input-group">
										<span class="input-group-text"><strong>Tare Weight</strong></span>
										<input type="text" class="form-control" name="" id="txtTicketNo" readonly value="100">
										<span class="input-group-text"><strong>kg</strong></span>
									</div>
								</div>

								<div class="col-md-6 mb-3">
									<div class="input-group">
										<span class="input-group-text"><strong>Net Weight</strong></span>
										<input type="text" class="form-control" name="" id="txtTicketNo" readonly value="100">
										<span class="input-group-text"><strong>kg</strong></span>
									</div>
								</div>

								<div class="col-md-6 mb-3">
									<div class="input-group">
										<span class="input-group-text"><strong>Custom Field 1</strong></span>
										<input type="text" class="form-control" name="" id="txtTicketNo" readonly value="100">
									</div>
								</div>

								<div class="col-md-6 mb-3">
									<div class="input-group">
										<span class="input-group-text"><strong>Custom Field 2</strong></span>
										<input type="text" class="form-control" name="" id="txtTicketNo" readonly value="100">
									</div>
								</div>

								<div class="col-md-12 mt-3 text-end">
                  <button type="reset" class="btn btn-secondary">Clear</button>
                  <button type="submit" class="btn btn-primary">Save</button>
								</div>

							</div>
						</form>
					</div>
				</div>
			</div>

			<div class="card">
				<div class="card-body">
					<div class="row">
						<div class="d-flex justify-content-between col-12">
							<h5 class="card-title">Pending Weighment.</h5>
						</div>
					</div>

					<hr class="mt-0 pb-3">

					<div class="row mb-3">
						<table class="table datatable">
							<thead>
								<tr>
									<th>Ticket No.</th>
									<th>Vehicle No.</th>
									<th>Vehicle Type</th>
									<th>Charges 1<sup>st</sup></th>
									<th>Charges 2<sup>nd</sup></th>
									<th>Material</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>90809</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>

								<tr>
									<td>90809</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>

								<tr>
									<td>90809</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>

								<tr>
									<td>90809</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>

								<tr>
									<td>90809</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>

								<tr>
									<td>90809</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>

								<tr>
									<td>90809</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>

								<tr>
									<td>90809</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>

								<tr>
									<td>90809</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>90809</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>90809</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
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