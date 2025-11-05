<div class="container">
    <div class="pagetitle">
        <h1>Label Configurator</h1>
        <form action="" id="label_config_form">
            <div class="d-flex gap-3 ">
                <div class="row my-3 col-md-6">
                    <div class="input-group mb-3 mt-3 ">
                        <span class="input-group-text"><strong>party_name</strong></span>
                        <input type="text" class="form-control" id="label_config_party_name" name="party_name" value="">
                        <div class="form-check form-switch enable-switch">
                            <input class="form-check-input fs-4" type="checkbox" id="label_config_party_name_chk">
                            <label class="form-check-label" for="label_config_party_name_chk"></label>
                        </div>
                    </div>
                    <div class="input-group mb-3 mt-3 ">
                        <span class="input-group-text"><strong>vehicle_number</strong></span>
                        <input type="text" class="form-control" id="label_config_vehicle_number" name="vehicle_number" value="">
                        <div class="form-check form-switch enable-switch">
                            <input class="form-check-input fs-4" type="checkbox" id="label_config_vehicle_number_chk">
                            <label class="form-check-label" for="label_config_vehicle_number_chk"></label>
                        </div>
                    </div>
                    <div class="input-group mb-3 mt-3 ">
                        <span class="input-group-text"><strong>material</strong></span>
                        <input type="text" class="form-control" id="label_config_material" name="material" value="">
                        <div class="form-check form-switch enable-switch">
                            <input class="form-check-input fs-4" type="checkbox" id="label_config_material_chk">
                            <label class="form-check-label" for="label_config_material_chk"></label>
                        </div>
                    </div>
                    <div class="input-group mb-3 mt-3 ">
                        <span class="input-group-text"><strong>weight</strong></span>
                        <input type="text" class="form-control" id="label_config_weight" name="weight" value="">
                        <div class="form-check form-switch enable-switch">
                            <input class="form-check-input fs-4" type="checkbox" id="label_config_weight_chk">
                            <label class="form-check-label" for="label_config_weight_chk"></label>
                        </div>
                    </div>
                    <div class="input-group mb-3 mt-3 ">
                        <span class="input-group-text"><strong>charges</strong></span>
                        <input type="text" class="form-control" id="label_config_charges" name="charges" value="">
                        <div class="form-check form-switch enable-switch">
                            <input class="form-check-input fs-4" type="checkbox" id="label_config_charges_chk">
                            <label class="form-check-label" for="label_config_charges_chk"></label>
                        </div>
                    </div>
                    <div class="input-group mb-3 mt-3 ">
                        <span class="input-group-text"><strong>field_1</strong></span>
                        <input type="text" class="form-control" id="label_config_field1" name="field1" value="">
                        <div class="form-check form-switch enable-switch">
                            <input class="form-check-input fs-4" type="checkbox" id="label_config_field1_chk">
                            <label class="form-check-label" for="label_config_field_1_chk"></label>
                        </div>
                    </div>
                    <div class="input-group mb-3 mt-3 ">
                        <span class="input-group-text"><strong>field_2</strong></span>
                        <input type="text" class="form-control" id="label_config_field2" name="field2" value="">
                        <div class="form-check form-switch enable-switch">
                            <input class="form-check-input fs-4" type="checkbox" id="label_config_field2_chk">
                            <label class="form-check-label" for="label_config_field_2_chk"></label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 mt-3 text-end">
                <button type="reset" class="btn btn-secondary reset_button">Clear</button>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>
</div>
<style>
    .enable-switch {
        width: 100px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        margin-left: 10px;
    }
</style>
<script src="<?php echo $asset_base ?>assets/js/utils.js"></script>
<script>
    const label_config_form = document.querySelector('#label_config_form')



    function updateLabelInputs(labelData) {
        for (const [field, obj] of Object.entries(labelData)) {
            // Update the value input
            const inputElem = document.querySelector(`input[name="${field}"]`);
            if (inputElem) {
                inputElem.value = obj.value || ""; // Handle missing .value case
            } else {
                console.log(`No input found with name: ${field}`);
            }

            // Update the enabled checkbox
            // Assume checkbox has id of 'label_config_<field>_chk'
            const checkboxId = `label_config_${field}_chk`;
            const checkboxElem = document.getElementById(checkboxId);
            if (checkboxElem) {
                checkboxElem.checked = !!obj.enabled; // Set checkbox state
            } else {
                console.log(`No checkbox found with id: ${checkboxId}`);
            }
        }
    }


    const getLabelConfiguration = async () => {
        console.log('getting label config');
        const res = await getLabelConfigAPI();
        if (res.status) {
            const labelData = res.data.reduce((acc, item) => {
                acc[item.column_name] = {
                    value: item.label_name,
                    enabled: !!item.enabled // Convert to boolean
                };
                return acc;
            }, {});
            updateLabelInputs(labelData); // updates input values and checkbox states
        }
    };

    label_config_form.addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = new FormData(label_config_form);
        const data = {};
        for (const [name, value] of formData.entries()) {
            data[name] = {
                value,
                enabled: document.getElementById(`label_config_${name}_chk`).checked
            };
        }
        try {
            const res = await saveLabelConfigAPI(data);
            console.log(res)
            handleResponse(res)
        } catch (error) {
            console.error('Error:', error);
            alert('An error occurred while saving the label configuration.');
        }
    });
    getLabelConfiguration()
</script>