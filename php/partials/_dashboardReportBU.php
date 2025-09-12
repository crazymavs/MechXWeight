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
  <div class="card">
    <div class="card-body">
      <h5 class="card-title">Dashboard for <?= $startDate ?> to <?= $endDate ?></h5>
      <div class="row mb-3">

        <div class="col-md-3">
          <label for="dashboardFromDate" class="form-label">From Date</label>
          <input type="date" class="form-control" id="dashboardFromDate" value="<?= $fromDate ?>">
        </div>
        <div class="col-md-3">
          <label for="dashboardStartTime" class="form-label">From Time</label>
          <input type="time" class="form-control" id="dashboardStartTime" value="<?= $fromTime ?>">
        </div>

        <div class="col-md-3">
          <label for="dashboardToDate" class="form-label">To Date</label>
          <input type="date" class="form-control" id="dashboardToDate" value="<?= $toDate ?>">
        </div>
        <div class="col-md-3">
          <label for="dashboardEndTime" class="form-label">To Time</label>
          <input type="time" class="form-control" id="dashboardEndTime" value="<?= $toTime ?>">
        </div>


      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Cumulative tank values</h5>

          <!-- Polar Area Chart -->
          <div id="polarAreaChart" style="min-height: 400px;" class="echart"></div>

          <script>
            // document.addEventListener("DOMContentLoaded", () => {
            //   echarts.init(document.querySelector("#polarAreaChart")).setOption({
            //     tooltip: {
            //       trigger: 'axis',
            //       axisPointer: {
            //         type: 'shadow'
            //       }
            //     },
            //     legend: {},
            //     grid: {
            //       left: '3%',
            //       right: '4%',
            //       bottom: '3%',
            //       containLabel: true
            //     },

            //     xAxis: [{
            //       type: 'category',
            //       data: [
            //         'Toluene',
            //         'Butyle',
            //         '150001 MTO',
            //         '150001 MTO',
            //         '150001 MTO',
            //         '150001 MTO',
            //         '150001 Toluene',
            //         '50001',
            //         '50002',
            //         '50003',
            //         '50004',
            //         '50005'
            //       ]
            //     }],
            //     yAxis: [{
            //       type: 'value'
            //     }],
            //     series: [{
            //         name: 'Actual Level',
            //         type: 'bar',
            //         emphasis: {
            //           focus: 'series'
            //         },
            //         data: [
            //           1000, 1000, 1000, 1000, 1000, 1000, 1000, 1000, 1000, 1000, 1000, 1000
            //         ]
            //       },
            //       {
            //         name: 'Stock',
            //         type: 'bar',
            //         emphasis: {
            //           focus: 'series'
            //         },
            //         data: [50, 100, 150, 10, 20, 70, 90, 85, 65, 50, 30, 10]
            //       },
            //       {
            //         name: 'Input',
            //         type: 'bar',
            //         // stack: 'Ad',
            //         emphasis: {
            //           focus: 'series'
            //         },
            //         data: [450, 350, 590, 610, 240, 390, 760, 590, 610, 240, 390, 760]
            //       },
            //       {
            //         name: 'Output',
            //         type: 'bar',
            //         // stack: 'Ad',
            //         emphasis: {
            //           focus: 'series'
            //         },
            //         data: [550, 650, 410, 390, 760, 610, 230, 410, 390, 760, 610, 230]
            //       }
            //     ]
            //   });
            // });

          </script>
          <!-- End Polar Area Chart -->

        </div>
      </div>
    </div>
  </div>
  <div class="row">

    <!-- Left side columns -->
    <div class="col-lg-12">
      <div class="row">



        <!-- Toluene -->
        <div class="col-xxl-3 col-md-4 col-sm-6">
          <div class="card info-card sales-card">

            <div class="card-body">
              <h5 class="card-title">Toluene <span>| readings</span></h5>

              <div class="d-flex align-items-center">
                <div class="d-flex align-items-center justify-content-center">

                  <div class="tank-wrapper">
                    <div class="tank">
                      <div class="tank-fill" style="--fill: 50;"></div>
                      <div class="tank-label">5000KG</div>
                    </div>
                  </div>

                </div>
                <div class="ps-3">
                  <div class="tankValues">
                    <table>
                      <tr>
                        <td><strong>Actual Level</strong></td>
                        <td>: 100 cm</td>
                      </tr>
                      <tr>
                        <td><strong>Actual Input</strong></td>
                        <td>: 4500 kg</td>
                      </tr>
                      <tr>
                        <td><strong>Actual Output</strong></td>
                        <td>: 5500 kg</td>
                      </tr>
                      <tr>
                        <td><strong>Input Flowrate</strong></td>
                        <td>: 5000 kg/hr</td>
                      </tr>
                      <tr>
                        <td><strong>Output Flowrate</strong></td>
                        <td>: 6000 kg/hr</td>
                      </tr>
                      <tr>
                        <td><strong>Stock</strong></td>
                        <td>: 6000 kg</td>
                      </tr>
                    </table>

                  </div>

                </div>
              </div>
            </div>

          </div>
        </div><!-- End Toluene Card -->

        <!-- Toluene -->
        <div class="col-xxl-3 col-md-4 col-sm-6">
          <div class="card info-card sales-card">

            <div class="card-body">
              <h5 class="card-title">Butyl <span>| readings</span></h5>

              <div class="d-flex align-items-center">
                <div class="d-flex align-items-center justify-content-center">

                  <div class="tank-wrapper">
                    <div class="tank">
                      <div class="tank-fill" style="--fill: 40;"></div>
                      <div class="tank-label">4000KG</div>
                    </div>
                  </div>

                </div>
                <div class="ps-3">
                  <div class="tankValues">
                    <table>
                      <tr>
                        <td><strong>Actual Level</strong></td>
                        <td>: 100 cm</td>
                      </tr>
                      <tr>
                        <td><strong>Actual Input</strong></td>
                        <td>: 4500 kg</td>
                      </tr>
                      <tr>
                        <td><strong>Actual Output</strong></td>
                        <td>: 5500 kg</td>
                      </tr>
                      <tr>
                        <td><strong>Input Flowrate</strong></td>
                        <td>: 5000 kg/hr</td>
                      </tr>
                      <tr>
                        <td><strong>Output Flowrate</strong></td>
                        <td>: 6000 kg/hr</td>
                      </tr>
                      <tr>
                        <td><strong>Stock</strong></td>
                        <td>: 6000 kg</td>
                      </tr>
                    </table>

                  </div>

                </div>
              </div>
            </div>

          </div>
        </div><!-- End Toluene Card -->

        <!-- Toluene -->
        <div class="col-xxl-3 col-md-4 col-sm-6">
          <div class="card info-card sales-card">

            <div class="card-body">
              <h5 class="card-title">150001 MTO <span>| readings</span></h5>

              <div class="d-flex align-items-center">
                <div class="d-flex align-items-center justify-content-center">
                  <div class="tank-wrapper">
                    <div class="tank">
                      <div class="tank-fill" style="--fill: 32;"></div>
                      <div class="tank-label">3200KG</div>
                    </div>
                  </div>
                </div>
                <div class="ps-3">
                  <div class="tankValues">
                    <table>
                      <tr>
                        <td><strong>Actual Level</strong></td>
                        <td>: 100 cm</td>
                      </tr>
                      <tr>
                        <td><strong>Actual Input</strong></td>
                        <td>: 4500 kg</td>
                      </tr>
                      <tr>
                        <td><strong>Actual Output</strong></td>
                        <td>: 5500 kg</td>
                      </tr>
                      <tr>
                        <td><strong>Input Flowrate</strong></td>
                        <td>: 5000 kg/hr</td>
                      </tr>
                      <tr>
                        <td><strong>Output Flowrate</strong></td>
                        <td>: 6000 kg/hr</td>
                      </tr>
                      <tr>
                        <td><strong>Stock</strong></td>
                        <td>: 6000 kg</td>
                      </tr>
                    </table>

                  </div>

                </div>
              </div>
            </div>

          </div>
        </div><!-- End Toluene Card -->

        <!-- Toluene -->
        <div class="col-xxl-3 col-md-4 col-sm-6">
          <div class="card info-card sales-card">

            <div class="card-body">
              <h5 class="card-title">150002 MTO <span>| readings</span></h5>

              <div class="d-flex align-items-center">
                <div class="d-flex align-items-center justify-content-center">
                  <div class="tank-wrapper">
                    <div class="tank">
                      <div class="tank-fill" style="--fill: 72;"></div>
                      <div class="tank-label">7200KG</div>
                    </div>
                  </div>
                </div>
                <div class="ps-3">
                  <div class="tankValues">
                    <table>
                      <tr>
                        <td><strong>Actual Level</strong></td>
                        <td>: 100 cm</td>
                      </tr>
                      <tr>
                        <td><strong>Actual Input</strong></td>
                        <td>: 4500 kg</td>
                      </tr>
                      <tr>
                        <td><strong>Actual Output</strong></td>
                        <td>: 5500 kg</td>
                      </tr>
                      <tr>
                        <td><strong>Input Flowrate</strong></td>
                        <td>: 5000 kg/hr</td>
                      </tr>
                      <tr>
                        <td><strong>Output Flowrate</strong></td>
                        <td>: 6000 kg/hr</td>
                      </tr>
                      <tr>
                        <td><strong>Stock</strong></td>
                        <td>: 6000 kg</td>
                      </tr>
                    </table>

                  </div>

                </div>
              </div>
            </div>

          </div>
        </div><!-- End Toluene Card -->

        <!-- Toluene -->
        <div class="col-xxl-3 col-md-4 col-sm-6">
          <div class="card info-card sales-card">

            <div class="card-body">
              <h5 class="card-title">150003 MTO <span>| readings</span></h5>

              <div class="d-flex align-items-center">
                <div class="d-flex align-items-center justify-content-center">
                  <div class="tank-wrapper">
                    <div class="tank">
                      <div class="tank-fill" style="--fill: 60;"></div>
                      <div class="tank-label">6000KG</div>
                    </div>
                  </div>
                </div>
                <div class="ps-3">
                  <div class="tankValues">
                    <table>
                      <tr>
                        <td><strong>Actual Level</strong></td>
                        <td>: 100 cm</td>
                      </tr>
                      <tr>
                        <td><strong>Actual Input</strong></td>
                        <td>: 4500 kg</td>
                      </tr>
                      <tr>
                        <td><strong>Actual Output</strong></td>
                        <td>: 5500 kg</td>
                      </tr>
                      <tr>
                        <td><strong>Input Flowrate</strong></td>
                        <td>: 5000 kg/hr</td>
                      </tr>
                      <tr>
                        <td><strong>Output Flowrate</strong></td>
                        <td>: 6000 kg/hr</td>
                      </tr>
                      <tr>
                        <td><strong>Stock</strong></td>
                        <td>: 6000 kg</td>
                      </tr>
                    </table>

                  </div>

                </div>
              </div>
            </div>

          </div>
        </div><!-- End Toluene Card -->

        <!-- Toluene -->
        <div class="col-xxl-3 col-md-4 col-sm-6">
          <div class="card info-card sales-card">

            <div class="card-body">
              <h5 class="card-title">150004 MTO <span>| readings</span></h5>

              <div class="d-flex align-items-center">
                <div class="d-flex align-items-center justify-content-center">
                  <div class="tank-wrapper">
                    <div class="tank">
                      <div class="tank-fill" style="--fill: 60;"></div>
                      <div class="tank-label">6000KG</div>
                    </div>
                  </div>
                </div>
                <div class="ps-3">
                  <div class="tankValues">
                    <table>
                      <tr>
                        <td><strong>Actual Level</strong></td>
                        <td>: 100 cm</td>
                      </tr>
                      <tr>
                        <td><strong>Actual Input</strong></td>
                        <td>: 4500 kg</td>
                      </tr>
                      <tr>
                        <td><strong>Actual Output</strong></td>
                        <td>: 5500 kg</td>
                      </tr>
                      <tr>
                        <td><strong>Input Flowrate</strong></td>
                        <td>: 5000 kg/hr</td>
                      </tr>
                      <tr>
                        <td><strong>Output Flowrate</strong></td>
                        <td>: 6000 kg/hr</td>
                      </tr>
                      <tr>
                        <td><strong>Stock</strong></td>
                        <td>: 6000 kg</td>
                      </tr>
                    </table>

                  </div>

                </div>
              </div>
            </div>

          </div>
        </div><!-- End Toluene Card -->

        <!-- Toluene -->
        <div class="col-xxl-3 col-md-4 col-sm-6">
          <div class="card info-card sales-card">

            <div class="card-body">
              <h5 class="card-title">150005 Toluene <span>| readings</span></h5>

              <div class="d-flex align-items-center">
                <div class="d-flex align-items-center justify-content-center">
                  <div class="tank-wrapper">
                    <div class="tank">
                      <div class="tank-fill" style="--fill: 60;"></div>
                      <div class="tank-label">6000KG</div>
                    </div>
                  </div>
                </div>
                <div class="ps-3">
                  <div class="tankValues">
                    <table>
                      <tr>
                        <td><strong>Actual Level</strong></td>
                        <td>: 100 cm</td>
                      </tr>
                      <tr>
                        <td><strong>Actual Input</strong></td>
                        <td>: 4500 kg</td>
                      </tr>
                      <tr>
                        <td><strong>Actual Output</strong></td>
                        <td>: 5500 kg</td>
                      </tr>
                      <tr>
                        <td><strong>Input Flowrate</strong></td>
                        <td>: 5000 kg/hr</td>
                      </tr>
                      <tr>
                        <td><strong>Output Flowrate</strong></td>
                        <td>: 6000 kg/hr</td>
                      </tr>
                      <tr>
                        <td><strong>Stock</strong></td>
                        <td>: 6000 kg</td>
                      </tr>
                    </table>

                  </div>

                </div>
              </div>
            </div>

          </div>
        </div><!-- End Toluene Card -->

        <!-- Toluene -->
        <div class="col-xxl-3 col-md-4 col-sm-6">
          <div class="card info-card sales-card">

            <div class="card-body">
              <h5 class="card-title">50001 <span>| readings</span></h5>

              <div class="d-flex align-items-center">
                <div class="d-flex align-items-center justify-content-center">
                  <div class="tank-wrapper">
                    <div class="tank">
                      <div class="tank-fill" style="--fill: 60;"></div>
                      <div class="tank-label">6000KG</div>
                    </div>
                  </div>
                </div>
                <div class="ps-3">
                  <div class="tankValues">
                    <table>
                      <tr>
                        <td><strong>Actual Level</strong></td>
                        <td>: 100 cm</td>
                      </tr>
                      <tr>
                        <td><strong>Actual Input</strong></td>
                        <td>: 4500 kg</td>
                      </tr>
                      <tr>
                        <td><strong>Actual Output</strong></td>
                        <td>: 5500 kg</td>
                      </tr>
                      <tr>
                        <td><strong>Input Flowrate</strong></td>
                        <td>: 5000 kg/hr</td>
                      </tr>
                      <tr>
                        <td><strong>Output Flowrate</strong></td>
                        <td>: 6000 kg/hr</td>
                      </tr>
                      <tr>
                        <td><strong>Stock</strong></td>
                        <td>: 6000 kg</td>
                      </tr>
                    </table>

                  </div>

                </div>
              </div>
            </div>

          </div>
        </div><!-- End Toluene Card -->

        <!-- Toluene -->
        <div class="col-xxl-3 col-md-4 col-sm-6">
          <div class="card info-card sales-card">

            <div class="card-body">
              <h5 class="card-title">50002 <span>| readings</span></h5>

              <div class="d-flex align-items-center">
                <div class="d-flex align-items-center justify-content-center">
                  <div class="tank-wrapper">
                    <div class="tank">
                      <div class="tank-fill" style="--fill: 60;"></div>
                      <div class="tank-label">6000KG</div>
                    </div>
                  </div>
                </div>
                <div class="ps-3">
                  <div class="tankValues">
                    <table>
                      <tr>
                        <td><strong>Actual Level</strong></td>
                        <td>: 100 cm</td>
                      </tr>
                      <tr>
                        <td><strong>Actual Input</strong></td>
                        <td>: 4500 kg</td>
                      </tr>
                      <tr>
                        <td><strong>Actual Output</strong></td>
                        <td>: 5500 kg</td>
                      </tr>
                      <tr>
                        <td><strong>Input Flowrate</strong></td>
                        <td>: 5000 kg/hr</td>
                      </tr>
                      <tr>
                        <td><strong>Output Flowrate</strong></td>
                        <td>: 6000 kg/hr</td>
                      </tr>
                      <tr>
                        <td><strong>Stock</strong></td>
                        <td>: 6000 kg</td>
                      </tr>
                    </table>

                  </div>

                </div>
              </div>
            </div>

          </div>
        </div><!-- End Toluene Card -->

        <!-- Toluene -->
        <div class="col-xxl-3 col-md-4 col-sm-6">
          <div class="card info-card sales-card">

            <div class="card-body">
              <h5 class="card-title">50003 <span>| readings</span></h5>

              <div class="d-flex align-items-center">
                <div class="d-flex align-items-center justify-content-center">
                  <div class="tank-wrapper">
                    <div class="tank">
                      <div class="tank-fill" style="--fill: 60;"></div>
                      <div class="tank-label">6000KG</div>
                    </div>
                  </div>
                </div>
                <div class="ps-3">
                  <div class="tankValues">
                    <table>
                      <tr>
                        <td><strong>Actual Level</strong></td>
                        <td>: 100 cm</td>
                      </tr>
                      <tr>
                        <td><strong>Actual Input</strong></td>
                        <td>: 4500 kg</td>
                      </tr>
                      <tr>
                        <td><strong>Actual Output</strong></td>
                        <td>: 5500 kg</td>
                      </tr>
                      <tr>
                        <td><strong>Input Flowrate</strong></td>
                        <td>: 5000 kg/hr</td>
                      </tr>
                      <tr>
                        <td><strong>Output Flowrate</strong></td>
                        <td>: 6000 kg/hr</td>
                      </tr>
                      <tr>
                        <td><strong>Stock</strong></td>
                        <td>: 6000 kg</td>
                      </tr>
                    </table>

                  </div>

                </div>
              </div>
            </div>

          </div>
        </div><!-- End Toluene Card -->

        <!-- Toluene -->
        <div class="col-xxl-3 col-md-4 col-sm-6">
          <div class="card info-card sales-card">

            <div class="card-body">
              <h5 class="card-title">50004 <span>| readings</span></h5>

              <div class="d-flex align-items-center">
                <div class="d-flex align-items-center justify-content-center">
                  <div class="tank-wrapper">
                    <div class="tank">
                      <div class="tank-fill" style="--fill: 60;"></div>
                      <div class="tank-label">6000KG</div>
                    </div>
                  </div>
                </div>
                <div class="ps-3">
                  <div class="tankValues">
                    <table>
                      <tr>
                        <td><strong>Actual Level</strong></td>
                        <td>: 100 cm</td>
                      </tr>
                      <tr>
                        <td><strong>Actual Input</strong></td>
                        <td>: 4500 kg</td>
                      </tr>
                      <tr>
                        <td><strong>Actual Output</strong></td>
                        <td>: 5500 kg</td>
                      </tr>
                      <tr>
                        <td><strong>Input Flowrate</strong></td>
                        <td>: 5000 kg/hr</td>
                      </tr>
                      <tr>
                        <td><strong>Output Flowrate</strong></td>
                        <td>: 6000 kg/hr</td>
                      </tr>
                      <tr>
                        <td><strong>Stock</strong></td>
                        <td>: 6000 kg</td>
                      </tr>
                    </table>

                  </div>

                </div>
              </div>
            </div>

          </div>
        </div><!-- End Toluene Card -->

        <!-- Toluene -->
        <div class="col-xxl-3 col-md-4 col-sm-6">
          <div class="card info-card sales-card">

            <div class="card-body">
              <h5 class="card-title">50005 <span>| readings</span></h5>

              <div class="d-flex align-items-center">
                <div class="d-flex align-items-center justify-content-center">
                  <div class="tank-wrapper">
                    <div class="tank">
                      <div class="tank-fill" style="--fill: 60;"></div>
                      <div class="tank-label">6000KG</div>
                    </div>
                  </div>
                </div>
                <div class="ps-3">
                  <div class="tankValues">
                    <table>
                      <tr>
                        <td><strong>Actual Level</strong></td>
                        <td>: 100 cm</td>
                      </tr>
                      <tr>
                        <td><strong>Actual Input</strong></td>
                        <td>: 4500 kg</td>
                      </tr>
                      <tr>
                        <td><strong>Actual Output</strong></td>
                        <td>: 5500 kg</td>
                      </tr>
                      <tr>
                        <td><strong>Input Flowrate</strong></td>
                        <td>: 5000 kg/hr</td>
                      </tr>
                      <tr>
                        <td><strong>Output Flowrate</strong></td>
                        <td>: 6000 kg/hr</td>
                      </tr>
                      <tr>
                        <td><strong>Stock</strong></td>
                        <td>: 6000 kg</td>
                      </tr>
                    </table>

                  </div>

                </div>
              </div>
            </div>

          </div>
        </div><!-- End Toluene Card -->

      </div>
    </div><!-- End Left side columns -->

    <!-- Right side columns -->


  </div>

</section>