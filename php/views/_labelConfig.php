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
                            <input class="form-check-input fs-4" type="checkbox" id="flexSwitchCheckDefault">
                            <label class="form-check-label" for="flexSwitchCheckDefault"></label>
                        </div>
                    </div>
                    <div class="input-group mb-3 mt-3 ">
                        <span class="input-group-text"><strong>vehicle_number</strong></span>
                        <input type="text" class="form-control" id="label_config_party_name" name="vehicle_number" value="">
                        <div class="form-check form-switch enable-switch">
                            <input class="form-check-input fs-4" type="checkbox" id="flexSwitchCheckDefault">
                            <label class="form-check-label" for="flexSwitchCheckDefault"></label>
                        </div>
                    </div>
                    <div class="input-group mb-3 mt-3 ">
                        <span class="input-group-text"><strong>material</strong></span>
                        <input type="text" class="form-control" id="label_config_party_name" name="material" value="">
                        <div class="form-check form-switch enable-switch">
                            <input class="form-check-input fs-4" type="checkbox" id="flexSwitchCheckDefault">
                            <label class="form-check-label" for="flexSwitchCheckDefault"></label>
                        </div>
                    </div>
                    <div class="input-group mb-3 mt-3 ">
                        <span class="input-group-text"><strong>weight</strong></span>
                        <input type="text" class="form-control" id="label_config_party_name" name="weight" value="">
                        <div class="form-check form-switch enable-switch">
                            <input class="form-check-input fs-4" type="checkbox" id="flexSwitchCheckDefault">
                            <label class="form-check-label" for="flexSwitchCheckDefault"></label>
                        </div>
                    </div>
                    <div class="input-group mb-3 mt-3 ">
                        <span class="input-group-text"><strong>charges</strong></span>
                        <input type="text" class="form-control" id="label_config_party_name" name="charges" value="">
                        <div class="form-check form-switch enable-switch">
                            <input class="form-check-input fs-4" type="checkbox" id="flexSwitchCheckDefault">
                            <label class="form-check-label" for="flexSwitchCheckDefault"></label>
                        </div>
                    </div>
                    <div class="input-group mb-3 mt-3 ">
                        <span class="input-group-text"><strong>field_1</strong></span>
                        <input type="text" class="form-control" id="label_config_field_1" name="field1" value="">
                        <div class="form-check form-switch enable-switch">
                            <input class="form-check-input fs-4" type="checkbox" id="flexSwitchCheckDefault">
                            <label class="form-check-label" for="flexSwitchCheckDefault"></label>
                        </div>
                    </div>
                    <div class="input-group mb-3 mt-3 ">
                        <span class="input-group-text"><strong>field_2</strong></span>
                        <input type="text" class="form-control" id="label_config_field_2" name="field2" value="">
                        <div class="form-check form-switch enable-switch">
                            <input class="form-check-input fs-4" type="checkbox" id="flexSwitchCheckDefault">
                            <label class="form-check-label" for="flexSwitchCheckDefault"></label>
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
<script>
    const label_config_form = document.querySelector('#label_config_form')



    function updateLabelInputs(labelData) {
        console.log({
            labelData
        })
        // labelData is an object like { field_name: newValue, ... }
        for (const [field, value] of Object.entries(labelData)) {
            // Find the input element by name attribute
            console.log({
                field,
                value
            });
            const inputElem = document.querySelector(`input[name="${field}"]`);
            if (inputElem) {
                inputElem.value = value; // Update the value on UI

            } else {
                const inputElem2 = document.querySelector(`input[name="${field}"]`);
                console.log(`No input found with name: ${field}`);
            }
            // console.log({
            // 	closest,
            // 	firstStrong
            // })
            // if (inputElem) {
            // 	inputElem.value = value; // Update the value on UI
            // }
        }
    }

    const getLabelConfiguration = async () => {
        console.log('getting label config')
        const res = await getLabelConfigAPI();
        if (res.status) {
            const labelData = res.data.reduce((acc, item) => {
                acc[item.column_name] = item.label_name;
                return acc;
            }, {});
            updateLabelInputs(labelData);
        }
        console.log({
            res
        })
    }

    label_config_form.addEventListener('submit', async (e) => {

        e.preventDefault();
        const formData = new FormData(label_config_form);

        const data = {};
        for (const [name, value] of formData.entries()) {
            data[name] = value;
        }
        console.log({
            formData,
            data,
            saveLabelConfigAPI
        })
        try {
            const res = await saveLabelConfigAPI(data);
            console.log(res)
            if (res.status) {
                const toastLiveExample = document.getElementById('successToast');
                $('.success-toast-body').text(res.message);
                const toastBootstrap = new bootstrap.Toast(toastLiveExample, {
                    delay: 3000,
                    autohide: true,
                });
                toastBootstrap.show();

                // Refresh the materials list after deletion
                fetchAndDisplayMaterials();
            } else {
                const toastLiveExample = document.getElementById('errorToast');
                $('.error-toast-body').text(res.message);
                const toastBootstrap = new bootstrap.Toast(toastLiveExample, {
                    delay: 3000,
                    autohide: true,
                });
                toastBootstrap.show();
            }

        } catch (error) {
            console.error('Error:', error);
            alert('An error occurred while saving the label configuration.');
        }
    });
    getLabelConfiguration()
</script>