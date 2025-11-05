<div class="container">

  <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-xxl-4 col-xl-5 col-lg-6 col-md-8 d-flex flex-column align-items-center justify-content-center">

          <div class="logo d-flex justify-content-between align-items-center py-4 w-100">
            <img src="assets/img/logo.png" alt="">
            <img src="assets/img/crazymavericks.png" alt="">
          </div><!-- End Logo -->

          <div class="card pb-4 mb-3">

            <div class="card-body">

              <div class="pt-4 pb-2">
                <h5 class="card-title text-center pb-0 fs-4">Login to Your Account</h5>
                <p class="text-center small">Enter your username & password to login</p>
              </div>

              <div class="row g-3 needs-validation" novalidate id="frmLogin">

                <div class="col-12">
                  <label for="opUserName" class="form-label">Username</label>
                  <div class="input-group has-validation">
                    <span class="input-group-text" id="inputGroupPrepend"><i class="fa-duotone fa-solid fa-user"></i></span>
                    <input type="text" name="username" class="form-control" id="opUserName" required>
                    <div class="invalid-feedback">Please enter your username.</div>
                  </div>
                </div>

                <div class="col-12">
                  <label for="opPassword" class="form-label">Password</label>
                  <div class="input-group has-validation">
                    <span class="input-group-text"><i class="fa-duotone fa-solid fa-key"></i></span>
                    <input type="password" name="password" class="form-control" id="opPassword" required>
                    <div class="invalid-feedback">Please enter your password!</div>
                  </div>
                </div>

                <div class="col-12 mt-5">
                  <button class="btn btn-primary btn-lg w-100" id="btnLogin">Login</button>
                </div>
                <div class="col-12 text-center mt-3">
                  <p class="small mb-0">New User?
                    <a href="<?= $asset_base ?>register">Register here</a>
                  </p>
                </div>
              </div>

            </div>
          </div>

          <div class="credits pb-4">
            Developed by Digitelligence Technologies Pvt. Ltd.
          </div>


        </div>
      </div>
    </div>

  </section>

</div>