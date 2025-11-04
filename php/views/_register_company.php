<div class="container vh-100 d-grid align-items-center">

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Register Company</h5>
                        <form id="companyRegForm" class="company-config-form d-flex flex-column gap-4">

                            <div class="form-group">
                                <label for="company_name">Company Name</label>
                                <input type="text" id="company_name" name="company_name" class="form-control" required />
                            </div>

                            <div class="form-group">
                                <label for="company_addr">Company Address</label>
                                <textarea id="company_addr" name="company_addr" class="form-control" rows="3" required></textarea>
                            </div>

                            <div class="form-group">
                                <label for="company_phone">Company Phone</label>
                                <input type="tel" id="company_phone" name="company_phone" class="form-control" required />
                            </div>

                            <div class="form-group">
                                <label for="company_type">Company Type</label>
                                <select id="company_type" name="company_type" class="form-control" required>
                                    <option value="" disabled selected>Select type</option>
                                    <option value="1">Private</option>
                                    <option value="2">Public</option>
                                    <option value="3">Non-profit</option>
                                    <option value="4">Government</option>
                                    <!-- Add other company types as needed -->
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary">Save Company Config</button>
                        </form>


                    </div>
                </div>

            </div>
        </div>
    </section>
</div>

<script src="<?php echo $asset_base ?>assets/js/utils.js"></script>

<script>
    const saveCompanyForm = document.querySelector('#companyRegForm')
    let curCompany = null

    saveCompanyForm.addEventListener('submit', async (e) => {
        e.preventDefault()
        const formData = new FormData(e.target);

        const data = {};
        for (const [name, value] of formData.entries()) {
            data[name] = value;
        }
        data.user_id = <?= $user_id ?? 0 ?>;
        console.log(data);
        const res = await saveCompanyAPI(data);
        console.log({
            res,
        });
        handleResponse(res);
        window.location.href = '<?= $asset_base ?>dashboard';
    })
</script>