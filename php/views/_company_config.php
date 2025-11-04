<section class="section">
    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Mecho-Tronix Company</h5>
                    <form id="companyConfigForm" class="company-config-form d-flex flex-column gap-4">

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
                            <label for="company_logo">Company Logo</label>
                            <input type="file" id="company_logo" name="company_logo" class="form-control" required />
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

<script src="<?php echo $asset_base ?>assets/js/utils.js"></script>

<script>
    const saveCompanyForm = document.querySelector('#companyConfigForm')
    let curCompany = null

    saveCompanyForm.addEventListener('submit', async (e) => {
        e.preventDefault()
        const formData = new FormData(e.target);
        // const data = {};
        // for (const [name, value] of formData.entries()) {
        //     data[name] = value;
        // }
        // const userid = <?= $_SESSION['user_id'] ?? 0 ?>;
        const companyid = <?= $_SESSION['user_company'] ?? 0 ?>;
        formData.append('company_id', companyid);
        formData.append('company_logo', document.getElementById('company_logo').files[0]);
        formData.append('actionMethod', 'savecompany');

        const res = await saveCompanyAPI(formData);
        console.log({
            res,
        });
        handleResponse(res);
    })

    async function getdata() {
        const userid = <?= $_SESSION['user_id'] ?? 0 ?>;
        const companyid = <?= $_SESSION['user_company'] ?? 0 ?>;

        const res = await getUserCompany({
            user_id: userid,
            company_id: companyid
        })
        // Assuming res.data contains the company object or first company in array
        let company = null;

        if (res.status) {
            if (Array.isArray(res.data)) {
                company = res.data[0] || null; // first company from list
            } else {
                company = res.data; // single company object
            }
        }

        if (company) {
            curCompany = company
            // Fill form fields by ID
            document.getElementById('company_name').value = company.company_name || '';
            document.getElementById('company_addr').value = company.company_addr || '';
            document.getElementById('company_phone').value = company.company_phone || '';
            document.getElementById('company_type').value = company.company_type || '';
        } else {
            console.warn('No company data to fill form');
        }

    }
    getdata()
</script>