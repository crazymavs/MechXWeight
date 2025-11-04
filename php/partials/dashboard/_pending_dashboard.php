<section class="col-12">
    <div class="modal fade" id="editTransactionModal" tabindex="-1" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Transaction</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="row g-3 p-3" id="add_material_form_modal">
                    <div class=" row">
                        <div class="col-md-12">
                            <div class="row my-3 col-md-6">
                                <h5 class="card-title m-0 p-0 ps-2 pb-2"><strong>Ticket No: </strong>
                                    <span id="modal_ticket_number">New</span>
                                </h5>
                                <!-- <h5 class="fs-6"><strong>Date&Time: </strong><?= $toDate ?> <?= date('H:i') ?> </h5> -->
                            </div>
                            <div class="input-group mb-3 mt-3 ">
                                <span class="input-group-text"><strong>Party Name</strong></span>
                                <input type="text" class="form-control" id="modal_party_name" name="party_name" value="">
                                <div class="suggestionList" id="party_suggestions"></div>
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text"><strong>Vehicle No.</strong></span>
                                <input type="text" class="form-control" id="modal_vehicle_no" name="vehicle_number" value="">
                                <div class="suggestionList" id="vehicle_number_suggestions"></div>
                            </div>
                            <div class="input-group mb-3 d-none">
                                <span class="input-group-text"><strong>Ticket No.</strong></span>
                                <input type="text" class="form-control" id="modal_ticket_no" name="ticket_no" value="">
                            </div>


                            <div class="additional_fields_container d-flex gap-3 mb-3">
                                <div class="input-group">
                                    <span class="input-group-text material-index-label"><strong>Field 1</strong></span>
                                    <input type="text" class="form-control" id="field_1" name="field1" value="Empty">
                                    <!-- <div class="suggestionList" calss="materials_suggestions"></div> -->
                                </div>
                                <div class="input-group">
                                    <span class="input-group-text material-index-label"><strong>Field 2</strong></span>
                                    <input type="text" class="form-control" id="field_2" name="field2" value="Empty">
                                    <!-- <div class="suggestionList" calss="materials_suggestions"></div> -->
                                </div>
                            </div>
                            <div class="material_detials_container">
                                <div class="d-flex gap-3 material_detail mb-3">
                                    <div class="input-group">
                                        <span class="input-group-text material-indexed-label"><strong>Material 1</strong></span>
                                        <input type="text" class="form-control" id="modal_material_1" name="material_1" value="Empty">
                                        <div class="suggestionList" calss="materials_suggestions"></div>
                                    </div>
                                    <div class="input-group ">
                                        <span class="input-group-text weight-indexed-label"><strong>Weight</strong></span>
                                        <input type="text" class="form-control" id="modal_weight_1" name="weight_1" value="">
                                        <span class="input-group-text"><strong>kg</strong></span>
                                    </div>
                                    <div class="input-group h-fit">
                                        <span class="input-group-text charges-indexed-label"><strong>Charges</strong></span>
                                        <input type="text" class="form-control" id="modal_charges_1" name="charges_1" value="">
                                        <span class="input-group-text"><strong>₹</strong></span>
                                    </div>
                                    <button type="button" class="btn btn-danger btn-sm ms-2 delete-material-btn">Delete</button>
                                </div>
                            </div>

                        </div>
                        <div class="d-flex justify-content-between">
                            <div>
                                <button type="button" class="btn btn-secondary" id="add_material_button_in_modal">Add Item</button>
                            </div>
                            <div class="col-md-6 net_weight_wrapper d-none">
                                <div class="input-group mb-3 net_weight_input">
                                    <span class="input-group-text"><strong>Material 1 Net Weight</strong></span>
                                    <input type="text" class="form-control" id="weighment_form_new_weight" disabled name="net_weight" value="0">
                                    <span class="input-group-text"><strong>kg</strong></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mt-3 text-end">
                            <button type="reset" class="btn btn-secondary reset_button reset_button_modal">Clear</button>
                            <button type="submit" class="btn btn-primary" name="keep_pending">Keep Pending</button>
                            <button type="submit" class="btn btn-success" name="save_transaction">Save Transaction</button>
                        </div>
                    </div>
                    <style>
                        #editTransactionModal .modal-dialog {
                            max-width: 50%;
                        }

                        .suggestionList {
                            position: absolute;
                            left: 0;
                            right: 0;
                            top: 100%;
                            z-index: 99;
                            /* border: 1px solid #ddd; */
                            background: #fff;
                            border-top: none;
                            border-radius: 0 0 4px 4px;
                            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.06);
                            max-height: 180px;
                            overflow-y: auto;
                        }

                        .suggestionList div {
                            padding: 10px;
                            cursor: pointer;
                            border-bottom: 1px solid #eee;
                            transition: background 0.3s;
                        }

                        .suggestionList div:last-child {
                            border-bottom: none;
                        }

                        .suggestionList div:hover,
                        .suggestionList .active {
                            background: #f4f4f4;
                            color: #222;
                        }
                    </style>
                </form>
            </div>
        </div>
    </div>
    <div class="d-flex align-items-center gap-4">
        <h5 id="transaction_heading"><strong>Pending Records</strong></h5>
        <div class="d-flex align-items-center gap-4">
            <p class="text-nowrap my-0 me-2">
                With Selected :
            </p>
            <select id="actions" class="form-select" onchange="handleMultipleSelect(this)">
                <option value="choose" class="d-none">Choose</option>
                <option value="print">Print</option>
                <option value="complete">Complete</option>
                <option value="pending">Pending</option>
                <option value="delete">Delete</option>
            </select>
            <label for="" class="d-flex">
                SelectAll
                <input type="checkbox" id="select_all_checkbox" class="ms-3" onchange="toggleSelectAll(this)">
            </label>
            <div class="d-flex gap-3">
                <label for="" class="d-flex align-items-center gap-2">
                    From:
                    <input type="date" class="form-control" data-name="from_date" onchange="handelDataChange(this)">
                </label>
                <label for="" class="d-flex align-items-center gap-2">
                    Till:
                    <input type="date" class="form-control" data-name="till_date" onchange="handelDataChange(this)">
                </label>
            </div>
            <button class=" btn btn-info" id="btnExportRecords" onclick="exportRecords()">Export&nbsp;&nbsp;<i class="fa-duotone fa-solid fa-download"></i></button>
        </div>
    </div>
    <button type="button" class="btn btn-primary open_model_btn d-none" data-bs-toggle="modal" data-bs-target="#editTransactionModal">
        Add New
    </button>

    <table class="table datatable" id="recordTable">
        <thead>
            <tr>
                <th>Select</th>
                <th>Ticket No.</th>
                <th>Date</th>
                <th>Time</th>
                <th id="th_vehicle_number">Vehicle No.</th>
                <th id="th_party_name">Party Name</th>
                <th id="th_material">Material</th>
                <th id="th_weight">Weight</th>
                <th id="th_charges">Charges</th>
                <th>Net Weight</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="pendingWeightsBody">
            <tr>
                <td><input type="checkbox" /></td>
                <td>12345</td>
                <td>2025-11-01</td>
                <td>10:30 AM</td>
                <td>ABC1234</td>
                <td>Party Name</td>
                <td>Material X</td>
                <td>250 kg</td>
                <td>$500</td>
                <td>230 kg</td>
                <td>Completed</td>
                <td><button>Edit</button></td>
            </tr>
        </tbody>
    </table>
</section>

<style>
    .status_span {
        padding: 5px 10px;
        border-radius: 5px;
        background-color: #f0f0f0;
        font-weight: 600;
    }

    .status_span.pending {
        background-color: #ffeb3b;
        color: #000;
    }

    .status_span.completed {
        background-color: #4caf50;
        color: #fff;
    }

    .status_span.deleted {
        background-color: #f44336;
        color: #fff;
    }
</style>

<script src="<?php echo $asset_base ?>assets/js/utils.js"></script>
<?php
$parts = explode('/', $url);
$subRoute = $parts[1];
?>
<script>
    let currentCompany = {}
    let recordStatuses = [];
    const heading = document.getElementById('transaction_heading');
    const route = <?= json_encode($subRoute) ?>;
    if (route === 'pendingtransactions') {
        heading.innerHTML = '<strong>Pending Records</strong>';
    } else if (route === 'completedtransactions') {
        heading.innerHTML = '<strong>Completed Records</strong>';
    } else {
        heading.innerHTML = '<strong>All Records</strong>';
    }

    function exportRecords() {
        $("#recordTable").excelexportjs({
            containerid: "recordTable",
            datatype: "table",
        });
    }
    let tbody = document.getElementById('pendingWeightsBody');
    const editForm = document.querySelector('#add_material_form_modal')
    const openModelBtn = document.querySelector('.open_model_btn')
    let pressedButton2 = null;
    editForm.querySelectorAll('button[type="submit"]').forEach(button => {
        button.addEventListener('click', (e) => {
            console.log(e.target.value || e.target.name);
            pressedButton2 = e.target.value || e.target.name;
        });
    });
    editForm.addEventListener('submit', async (e) => {
        const ticket = document.getElementById('modal_ticket_number').innerText;
        const company_id = <?= $_SESSION['user_company'] ?? 0 ?>;
        handleWeighmentFormSubmit(e, pressedButton2, ticket, company_id);
    });

    document.querySelector('.reset_button_modal').addEventListener('click', (e) => {
        clearForm(e)
    })

    function toggleSelectAll(checkbox) {
        const isChecked = checkbox.checked;
        const checkboxes = tbody.querySelectorAll('input[type="checkbox"]');
        checkboxes.forEach(cb => {
            cb.checked = isChecked;
        });
    }

    let from_date = null
    let till_date = null

    function handelDataChange(elem) {
        const type = elem.dataset['name']
        const value = elem.value

        if (type === "from_date") {
            from_date = value
        } else {
            till_date = value
        }
        console.log({
            type,
            value,
            from_date,
            till_date
        })
        const company_id = <?= $_SESSION['user_company'] ?? 0 ?>;
        getTableData({
            from_date,
            till_date,
            company_id
        })
    }

    async function handleMultipleSelect(elem) {
        const selectedAction = elem.value;
        const checkboxes = tbody.querySelectorAll('input[type="checkbox"]:checked');
        console.log(checkboxes);
        const ticketNos = Array.from(checkboxes).map(cb => cb.closest('tr').querySelector('.ticketNo').innerText);
        console.log(ticketNos, selectedAction);
        const uniqueTicketNos = Array.from(new Set(ticketNos));
        if (selectedAction === "print") {
            printRecord();
        } else if (selectedAction === "complete") {
            await updateTransaction(uniqueTicketNos, 2);
        } else if (selectedAction === "delete") {
            await updateTransaction(uniqueTicketNos, 3);
        } else if (selectedAction === "pending") {
            await updateTransaction(uniqueTicketNos, 1);
        }
        // Reset the select dropdown
        elem.value = 'choose';
        // Uncheck all checkboxes after action
        checkboxes.forEach(cb => cb.checked = false);
        document.getElementById('select_all_checkbox').checked = false;
        fetchData()
    }

    function rerouteToBill(data) {
        // Prepare query parameters from your object
        const params = new URLSearchParams();
        console.log({
            data
        })


        params.set('weighingrecord_id', data.weighingrecord_id);
        params.set('weighment_type', data.weighment_type);
        params.set('ticket_no', data.ticket_no);
        params.set('vehicle_no', data.vehicle_number);
        params.set('party_name', data.party_name);
        params.set('charges', data.charge);
        params.set('remarks', data.remarks || '');
        params.set('date', data.created_at.split(' ')[0]);
        params.set('time', data.created_at.split(' ')[1]);
        params.set('status', data.status);

        // Extract weights and materials as comma-separated strings or assign empty strings
        params.set('weight', data.weight || '');
        params.set('material', data.material || '');

        console.log(currentCompany)

        params.set('company_name', currentCompany.company_name || '');
        params.set('company_addr', currentCompany.company_addr || '');
        params.set('company_phone', currentCompany.company_phone || '');
        params.set('company_logo', currentCompany.company_logo || '');
        // params.set('company_name', company.company_name || '');

        // Redirect to /bill page with query parameters
        window.open(`<?= $asset_base ?>/bill?${params.toString()}`, '_blank')
    }

    async function getCompData() {
        const userid = <?= $_SESSION['user_id'] ?? 0 ?>;
        const companyid = <?= $_SESSION['user_company'] ?? 0 ?>;

        const res = await getUserCompany({
            user_id: userid,
            company_id: companyid
        })
        let company = null;
        if (res.status) {
            if (Array.isArray(res.data)) {
                company = res.data[0] || null; // first company from list
            } else {
                company = res.data; // single company object
            }
        }

        if (company) {
            currentCompany = company

        } else {
            console.warn('No company data to fill form');
        }

    }
    getCompData()


    async function handleSelect(elem) {
        const ticketNo = elem.closest('tr').querySelector('.ticketNo').innerText
        if (elem.value === "add") {
            // Call your 'add record' function here
            const data = await fetchExistingData(ticketNo)
            fillFormWithData(data);
            // addRecord(ticketNo);
        } else if (elem.value === "print") {
            // printRecord();
            const data = await fetchExistingData(ticketNo)
            const material = elem.closest('tr').querySelector('.material').innerText
            const weight = elem.closest('tr').querySelector('.weight').innerText
            const charge = elem.closest('tr').querySelector('.charge').innerText
            rerouteToBill({
                ...data,
                weight,
                material,
                charge
            })
        } else if (elem.value === "complete") {
            updateTransaction([ticketNo], 2);
        } else if (elem.value === "delete") {
            updateTransaction([ticketNo], 3);
        } else if (elem.value === "pending") {
            updateTransaction([ticketNo], 1);
        } else if (elem.value === "edit") {
            document.querySelector('.reset_button_modal').click();
            const data = await fetchExistingData(ticketNo)
            // console.log({
            //     data
            // })
            fillModalwithData(data);
            openModelBtn.click();
            // console.log({
            //     newLabels
            // })
            updateModlaLabelInputs(newLabels)

        }
        elem.value = 'choose'
        fetchData()
    }

    const modal_materialDetail_container = document.querySelector("#add_material_form_modal .material_detail").parentNode;
    modal_materialDetail_container.addEventListener("click", (e) => {
        if (e.target.classList.contains("delete-material-btn")) {
            const allMaterials = modal_materialDetail_container.querySelectorAll(".material_detail");
            if (allMaterials.length > 1) {
                const materialDiv = e.target.closest(".material_detail");
                if (materialDiv) {
                    materialDiv.remove();
                }
            } else {
                const toastLiveExample = document.getElementById('errorToast');
                $('.error-toast-body').text('At least one material detail must be present.')
                const toastBootstrap = new bootstrap.Toast(toastLiveExample, {
                    delay: 3000,
                    autohide: true
                });
                toastBootstrap.show();
            }
        }
    });

    async function updateTransaction(ticketNo, newStatus) {
        const res = await updateTransactionStatusAPI({
            ticketNo: ticketNo,
            new_status: newStatus
        });
        if (res.status) {
            // alert("success")
            const toastLiveExample = document.getElementById('successToast');
            $('.success-toast-body').text(res.message)
            const toastBootstrap = new bootstrap.Toast(toastLiveExample, {
                delay: 3000,
                autohide: true
            });
            toastBootstrap.show();
        } else {
            // alert('error')
            const toastLiveExample = document.getElementById('errorToast');
            $('.error-toast-body').text(res.message)
            const toastBootstrap = new bootstrap.Toast(toastLiveExample, {
                delay: 3000,
                autohide: true
            });
            toastBootstrap.show();
        }
    }

    function updateTableHeaderLabels(labelNames) {
        const mappings = {
            "th_vehicle_number": labelNames.vehicle_number.name || "Vehicle No.",
            "th_party_name": labelNames.party_name.name || "Party Name",
            "th_material": labelNames.material.name || "Material",
            "th_weight": labelNames.weight.name || "Weight",
            "th_charges": labelNames.charges.name || "Charges"
        };

        Object.entries(mappings).forEach(([id, label]) => {
            const el = document.getElementById(id);
            if (el) {
                el.textContent = label;
            }
        });
    }

    async function getTableData(dateObj) {
        tbody.innerHTML = '';

        let allRecords;
        if (route === 'pendingtransactions') {
            allRecords = await getPendingweingRecordsAPI(dateObj);
        } else if (route === 'completedtransactions') {
            allRecords = await getCompletedweingRecordsAPI(dateObj);
        } else {
            allRecords = await getAllweingRecordsAPI(dateObj);
        }
        console.log(allRecords)
        // const tableBody = document.querySelector('#pendingWeightsBody')
        // console.log({
        //     tableBody
        // })
        tbody.innerHTML = ''
        allRecords.data.forEach((record, index) => {
            // const row = createRow(record);
            const row = document.createElement('tr');
            // row.setAttribute('data-index', index);
            const firstWeight = record.weights ? record.weights.split(',')[0] : 0
            const secondWeight = record.weights ? record.weights.split(',')[1] : 0
            const netweight = record.net_weight ? record.net_weight : 0

            const weight = record.weight ?? 0
            const charges = record.charges ?? 0
            const statusLabel = recordStatuses.find(item => item.status_id === record.status)?.label || "Unknown"
            row.innerHTML = `
            <td class="checkbox_col"><input id="checkbox_${index}" type="checkbox"></input></td>
            <td class="ticketNo">${record.ticket_no}</td>
            <td>${record.created_at.split(' ')[0]}</td>
            <td>${record.created_at.split(' ')[1]}</td>
            <td>${record.vehicle_number}</td>
            <td>${record.party_name}</td>
            <td class="material">${record.material}</td>
            <td class="weight">${weight}</td>
            <td class="charge">${charges}</td>
            <td>${Math.abs(netweight)}</td>
            <td><span class="status_span ${statusLabel.toLowerCase()}">${statusLabel}</span></td>
            <td>
                <select id="actions_${index}"  class="form-select" onchange="handleSelect(this)">
                    <option value="choose" class="d-none" >Choose</option>
                    <option value="add">Add Record</option>
                    <option value="print">Print</option>
                    <option value="complete">Complete</option>
                    <option value="pending">Pending</option>
                    <option value="delete">Delete</option>
                    <option value="edit">Edit</option>
                </select>
            </td>
        `;
            tbody.appendChild(row);
        });
    }

    const fetchData = async () => {
        const d = await getLabelConfiguration()

        updateTableHeaderLabels(d.newLables);
        const record_statuses = await getRecordStatusAPI();
        recordStatuses = record_statuses.data;
        const company_id = <?= $_SESSION['user_company'] ?? 0 ?>;
        getTableData({
            company_id
        })
    }


    function fillFormWithData(data) {
        const w1 = data.weights.split(',')[0] ?? 0;
        const w2 = data.weights.split(',')[1] ?? 0;
        const nw = Math.abs(w1 - w2);

        // Split all arrays, ensuring default to '' if undefined
        const weights = (data.weights || '').split(',');
        const materials = (data.materials || '').split(',');
        const charges = (data.charges || '').split(',');

        weights.forEach((weight, idx) => {
            if (idx > 0) addMaterialButton.click(); // Add more material fields if needed
            const weightField = document.getElementById(`weighment_form_weight_${idx + 1}`);
            if (weightField) weightField.value = weight || '';

            const materialField = document.getElementById(`weighment_form_material_${idx + 1}`);
            if (materialField) materialField.value = materials[idx] || '';

            const chargesField = document.getElementById(`weighment_form_charges_${idx + 1}`);
            if (chargesField) chargesField.value = charges[idx] || '';
        });

        // Example: assuming your form fields have these IDs
        document.getElementById('ticket_number').innerText = data.ticket_no || '';
        document.getElementById('weighment_form_vehicle_no').value = data.vehicle_number || '';
        document.getElementById('weighment_form_party_name').value = data.party_name || '';
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    }
    const addMaterialButtonInModal = document.getElementById('add_material_button_in_modal');
    addMaterialButtonInModal.addEventListener('click', (e) => {
        // console.log(handleAddItemClick)
        handleAddItemClick(e)
    });

    function fillModalwithData(data) {
        console.log(data)
        document.getElementById('modal_ticket_number').closest('form').reset();
        // Example: assuming your form fields have these IDs
        document.getElementById('modal_ticket_number').innerText = data.ticket_no || '';
        document.getElementById('modal_vehicle_no').value = data.vehicle_number || '';
        document.getElementById('modal_party_name').value = data.party_name || '';
        const weights = (data.weights || '').split(',');
        const materials = (data.materials || '').split(',');
        const charges = (data.charges || '').split(',');

        weights.forEach((weight, idx) => {
            if (idx > 0) addMaterialButtonInModal.click(); // Add more material fields if needed
            const weightField = document.getElementById(`modal_weight_${idx + 1}`);
            if (weightField) weightField.value = weight || '';

            const materialField = document.getElementById(`modal_material_${idx + 1}`);
            if (materialField) materialField.value = materials[idx] || '';

            const chargesField = document.getElementById(`modal_charges_${idx + 1}`);
            if (chargesField) chargesField.value = charges[idx] || '';
        });
    }

    async function fetchExistingData(ticketNo) {
        try {

            const res = await getSingleRecordByTicket({
                ticket_no: ticketNo
            });

            if (res.status) {
                // alert("success")
                const toastLiveExample = document.getElementById('successToast');
                $('.success-toast-body').text(res.message)
                const toastBootstrap = new bootstrap.Toast(toastLiveExample, {
                    delay: 3000,
                    autohide: true
                });
                toastBootstrap.show();
            } else {
                // alert('error')
                const toastLiveExample = document.getElementById('errorToast');
                $('.error-toast-body').text(res.message)
                const toastBootstrap = new bootstrap.Toast(toastLiveExample, {
                    delay: 3000,
                    autohide: true
                });
                toastBootstrap.show();
            }

            const data = res.data
            // fillFormWithData(data);
            return data;
        } catch (error) {
            console.error('There was a problem fetching the data:', error);
        }
    }

    function createRow(record) {
        const tr = document.createElement('tr');
        const firstWeight = record.weights ? record.weights.split(',')[0] : 0
        const secondWeight = record.weights ? record.weights.split(',')[1] : 0
        const netweight = record.net_weight ? record.net_weight : 0

        const weight = record.weight ?? 0
        const charges = record.charges ?? 0
        const statusLabel = recordStatuses.find(item => item.status_id === record.status)?.label || "Unknown"
        tr.innerHTML = `
            <td class="checkbox_col"><input type="checkbox"></input></td>
            <td class="ticketNo">${record.ticket_no}</td>
            <td>${record.created_at.split(' ')[0]}</td>
            <td>${record.created_at.split(' ')[1]}</td>
            <td>${record.vehicle_number}</td>
            <td>${record.party_name}</td>
            <td class="material">${record.material}</td>
            <td class="weight">${weight}</td>
            <td class="charge">${charges}</td>
            <td>${Math.abs(netweight)}</td>
            <td><span class="status_span ${statusLabel.toLowerCase()}">${statusLabel}</span></td>
            <td>
                <select id="actions"  class="form-select" onchange="handleSelect(this)">
                    <option value="choose" class="d-none" >Choose</option>
                    <option value="add">Add Record</option>
                    <option value="print">Print</option>
                    <option value="complete">Complete</option>
                    <option value="pending">Pending</option>
                    <option value="delete">Delete</option>
                    <option value="edit">Edit</option>
                </select>
            </td>
        `;
        return tr;
    }
    window.onload = function() {
        fetchData();
    };
</script>