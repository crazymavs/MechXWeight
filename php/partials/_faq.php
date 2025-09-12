<?php
    include_once 'php/partials/global/_globalConst.php';
?>
  
  <div class="row">
      <div class="col-lg-6">

        <!-- F.A.Q Mass Flow Meter -->
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Mass Flow Meter</h5>
                <div class="accordion accordion-flush" id="massFlowMeterFAQ">
                    <?php foreach ($massFlowMeterFAQs as $index => $faq): ?>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" data-bs-target="#faqMFM-<?php echo $index; ?>" type="button" data-bs-toggle="collapse">
                                    <?php echo $faq['question']; ?>
                                </button>
                            </h2>
                            <div id="faqMFM-<?php echo $index; ?>" class="accordion-collapse collapse" data-bs-parent="#massFlowMeterFAQ">
                                <div class="accordion-body">
                                    <?php echo $faq['answer']; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <!-- End F.A.Q Mass Flow Meter -->

      </div>

      <div class="col-lg-6">
        <!-- F.A.Q Level Transmitter -->
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Level Transmitter</h5>
                <div class="accordion accordion-flush" id="levelTransmitterFAQ">
                    <?php foreach ($levelTransmitterFAQs as $index => $faq): ?>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" data-bs-target="#faqLT-<?php echo $index; ?>" type="button" data-bs-toggle="collapse">
                                    <?php echo $faq['question']; ?>
                                </button>
                            </h2>
                            <div id="faqLT-<?php echo $index; ?>" class="accordion-collapse collapse" data-bs-parent="#levelTransmitterFAQ">
                                <div class="accordion-body">
                                    <?php echo $faq['answer']; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <!-- End F.A.Q Level Transmitter -->
      </div>

      <?php if (isset($_SESSION['user_level']) && ($_SESSION['user_level'] === 'admin' || $_SESSION['user_level'] === 'superAdmin')) : ?>
      <div class="col-lg-6">
        <!-- F.A.Q Level Transmitter -->
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Mass Flow Meter Advanced Troubleshoot</h5>
                <div class="accordion accordion-flush" id="ftmAdvancedFAQ">
                    <?php foreach ($massFlowMeterAdminFAQs as $index => $faq): ?>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" data-bs-target="#faqFA-<?php echo $index; ?>" type="button" data-bs-toggle="collapse">
                                    <?php echo $faq['question']; ?>
                                </button>
                            </h2>
                            <div id="faqFA-<?php echo $index; ?>" class="accordion-collapse collapse" data-bs-parent="#ftmAdvancedFAQ">
                                <div class="accordion-body">
                                    <?php echo $faq['answer']; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <!-- End F.A.Q Level Transmitter -->
      </div>
    <?php endif ?>

  </div>




<!-- Fullscreen Video Modal -->
<div class="modal fade" id="emersonZeroTransmission" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-fullscreen">
    <div class="modal-content bg-dark">
      <div class="modal-header border-0">
        <h5 class="modal-title text-white">Video Player</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close" onclick="pauseVideo()"></button>
      </div>
      <div class="modal-body d-flex justify-content-center align-items-center p-0">
        <video id="emersonZeroVideo" width="100%" height="100%" controls autoplay>
          <source src="<?= $asset_base ?>assets/media/Emerson_MIRCO-MOTION-transmitter-zero-calibration.mp4" type="video/mp4">
          Your browser does not support HTML5 video.
        </video>
      </div>
    </div>
  </div>
</div>

<script>
    function pauseVideo() {
    const video = document.getElementById('emersonZeroVideo');
    if (video) video.pause();
  }

  // Optional: Pause video on modal hide
  document.getElementById('emersonZeroTransmission').addEventListener('hidden.bs.modal', pauseVideo);
</script>