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

<div class="row" id="dashSettings">
    <div class="col-lg-6 col-xxl-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Backup Database</h5>
                <div class="mb-3">
                    <img class="varienceImg" src="<?php echo $asset_base ?>assets/img/backup.jpg" alt="">
                </div>
                <div class="text-center mt-3 pt-3">
                    <a class="btn btn-primary" target="_blank" href="http://localhost:8080/phpmyadmin/index.php?route=/database/export&db=knpl_variance">Go to Database Backup</a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6 col-xxl-4 d-none">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Cumulative Report Download</h5>
                <div class="row mb-3">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="mb-3">
                                <label for="reportFromDate" class="form-label">From Date</label>
                                <input type="date" class="form-control" id="reportFromDate" value="<?= $fromDate ?>">
                            </div>
                            <div class="mb-3">
                                <label for="reportStartTime" class="form-label">From Time</label>
                                <input type="time" class="form-control" id="reportStartTime" value="<?= $fromTime ?>">
                            </div>

                            <hr class="mt-3 mb-3 text-info">

                            <div class="mb-3">
                                <label for="reportToDate" class="form-label">To Date</label>
                                <input type="date" class="form-control" id="reportToDate" value="<?= $toDate ?>">
                            </div>
                            <div class="mb-3">
                                <label for="reportEndTime" class="form-label">To Time</label>
                                <input type="time" class="form-control" id="reportEndTime" value="<?= $toTime ?>">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-check form-switch card-title d-flex justify-content-center">
                            <input class="form-check-input" type="checkbox" id="tglSplit">&nbsp;&nbsp;
                            <label class="form-check-label" id="splitLabel" for="tglSplit">Split Mode</label>
                        </div>

                    </div>

						<div class="text-center">
							<button class="btn btn-primary" id="btnGetCumulativeReport">Get Cumulative Yards Report</button>
						</div>
                </div>
            </div>
        </div>
    </div>

    <!-- <div class="col-lg-6 col-xxl-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Density Correction Factor</h5>
                <div class="mb-3">
                    <label for="entryFee" class="form-label">Current Density Factor</label>
                    <input type="number" class="form-control entryFee" id="entryFee" aria-describedby="Density Corrector Factor">
                </div>
                <div class="mb-3">
                    <label for="updatedOn" class="form-label">Last Updated by</label>
                    <input type="text" class="form-control" id="updatedOn" aria-describedby="Last Updated on">
                </div>
                <button class="btn btn-primary" id="btnUpdateFee">Update Density Factor</button>
            </div>
        </div>
    </div>
</div>

<div class="toast" role="alert" aria-live="assertive" aria-atomic="true" id="densitySuccessToast">
    <div class="toast-header">
        <strong class="me-auto">Fee Updated!</strong>
        <small>Success!</small>
        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body">
        Entry fee updation is successful!
    </div>
</div> -->



<div class="table-responsive d-none" id="dvResinYardReports">
    <table class="table table-striped mt-3 mb-3 pb-3" id="resinVarianceReport">
        <thead>
            <tr>
                <th colspan="15">
                    <h5>Resin Yard Report from <strong><span class="reportFrom"></span></strong> to <strong><span class="reportTo"></span></strong></h5>
                </th>
            </tr>
            <tr>
                <th>Sl No</th>
                <th>Tank Identification</th>
                <th>Product Identification</th>
                <th>Input to Tank (kg)<br>A</th>
                <th>Opening Stock (kg)<br>B</th>
                <th>Output From Tank (kg)<br>C</th>
                <th>Closing Stock in Tank (kg)<br>A+B-C=D</th>
                <th>Level Transmitter Value (kg)<br>E</th>
                <th>Deviation b/w D & E<br>D-E</th>

                <th>Output to Mixer - Thinner (kg)<br>F</th>
                <th>Output to Pre- Mixer - Slurry White (kg)<br>G</th>
                <th>Output to Pre- Mixer - Slurry Colour (kg)<br>H</th>
                <th>Deviation b/w C & F+G+H (kg)<br>C - (F+G+H)</th>
            </tr>
        </thead>
        <tbody id="OSYardBody">
            <!-- Data rows -->
        </tbody>
    </table>
</div>


<div class="table-responsive d-none" id="dvNewSolventYardReports">
    <table class="table table-striped mt-3 mb-3 pb-3" id="newVarianceReport">
        <thead>
            <tr>
                <th colspan="15">
                    <h5>New Solvent Yard Report from <strong><span class="reportFrom"></span></strong> to <strong><span class="reportFrom"></span></strong></h5>
                </th>
            </tr>
            <tr>
                <th rowspan="2">Sl No</th>
                <th rowspan="2">Tank Identification</th>
                <th rowspan="2">Product Identification</th>
                <th rowspan="2">Input to Tank (kg)<br>A</th>
                <th rowspan="2">Opening Stock (kg)<br>B</th>
                <th rowspan="2">Output From Tank (kg)<br>C</th>
                <th rowspan="2">Closing Stock (kg)<br>A+B-C=D</th>
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
        </tbody>
    </table>
</div>