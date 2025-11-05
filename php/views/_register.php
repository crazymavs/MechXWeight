<div class="container">

    <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-8 d-flex flex-column align-items-center justify-content-center">

                    <div class="logo d-flex justify-content-between align-items-center py-4 w-100">
                        <img src="assets/img/logo.png" alt="">
                        <img src="assets/img/crazymavericks.png" alt="">
                    </div>

                    <div class="card pb-4 mb-3">
                        <div class="card-body">

                            <div class="pt-4 pb-2">
                                <h5 class="card-title text-center pb-0 fs-4">Create an Account</h5>
                                <p class="text-center small">Enter your details to register</p>
                            </div>

                            <form class="row g-3 needs-validation" novalidate id="formRegister">
                                <div class="row col-12 ">
                                    <div class="col-6">
                                        <label for="regFullName" class="form-label">Full Name</label>
                                        <div class="input-group has-validation">
                                            <span class="input-group-text"><i class="fa-duotone fa-solid fa-user"></i></span>
                                            <input type="text" name="user_name" class="form-control" id="regFullName" required>
                                            <div class="invalid-feedback">Please enter your full name.</div>
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <label for="regEmail" class="form-label">Email</label>
                                        <div class="input-group has-validation">
                                            <span class="input-group-text"><i class="fa-duotone fa-solid fa-envelope"></i></span>
                                            <input type="email" name="user_email" class="form-control" id="regEmail" required>
                                            <div class="invalid-feedback">Please enter a valid email.</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <label for="regUserName" class="form-label">Username</label>
                                    <div class="input-group has-validation">
                                        <span class="input-group-text"><i class="fa-duotone fa-solid fa-user-gear"></i></span>
                                        <input type="text" name="user_username" class="form-control" id="regUserName" required>
                                        <div class="invalid-feedback">Please choose a username.</div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <label for="regPassword" class="form-label">Password</label>
                                    <div class="input-group has-validation">
                                        <span class="input-group-text"><i class="fa-duotone fa-solid fa-key"></i></span>
                                        <input type="password" name="user_password" class="form-control" id="regPassword" required>
                                        <div class="invalid-feedback">Please enter a password.</div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <label for="regConfirmPassword" class="form-label">Confirm Password</label>
                                    <div class="input-group has-validation">
                                        <span class="input-group-text"><i class="fa-duotone fa-solid fa-lock"></i></span>
                                        <input type="password" name="confirm_password" class="form-control" id="regConfirmPassword" required>
                                        <div class="invalid-feedback">Please confirm your password.</div>
                                    </div>
                                </div>

                                <div class="col-12 mt-5">
                                    <button class="btn btn-primary btn-lg w-100" id="btnRegister">Register</button>
                                </div>

                                <div class="col-12 text-center mt-3">
                                    <p class="small mb-0">Already have an account?
                                        <a href="<?= $asset_base ?>login">Login here</a>
                                    </p>
                                </div>

                            </form>
                        </div>
                    </div>

                    <div class="credits pb-4">
                        Developed by Digitelligence Technologies Pvt. Ltd.
                    </div>

                </div>
            </div>
        </div>
    </section>
    <script>
        document.getElementById('formRegister').addEventListener('submit', async (event) => {
            console.log('Register form submitted');
            event.preventDefault();
            const form = document.getElementById('formRegister');

            if (!form.checkValidity()) {
                event.stopPropagation();
                form.classList.add('was-validated');
                return;
            }
            const password = document.getElementById('regPassword').value;
            const confirmPassword = document.getElementById('regConfirmPassword').value;

            if (password !== confirmPassword) {
                alert('Passwords do not match!');
                return;
            }

            // Proceed with form submission (e.g., AJAX request)
            alert('Form is valid and ready for submission!');
            // Extract form data automatically
            const formData = new FormData(form);
            const data = Object.fromEntries(formData.entries());

            // Add the actionMethod field
            data.actionMethod = 'registerUser';
            try {
                const response = await fetch('<?= $asset_base ?>api', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(data)
                });

                const result = await response.json();

                if (result.status === "success") {
                    alert('Registration successful!');
                    form.reset();
                    form.classList.remove('was-validated');
                    window.location.href = '<?= $asset_base ?>dashboard';
                } else {
                    alert('Registration failed: ' + (result.message || 'Unknown error'));
                }
            } catch (error) {
                alert('Error submitting form: ' + error.message);
                console.error(error);
            }
        });
    </script>
</div>