<section class="col-12">
    <h5><strong>Pending Records</strong></h5>
    <table class="table datatable">
        <thead>
            <tr>
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
                <td>90809</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>

            </tr>

        </tbody>
    </table>
    <button id="export-csv">Export CSV</button>
</section>
<script src="<?php echo $asset_base ?>assets/js/utils.js"></script>
<?php
$parts = explode('/', $url);
$subRoute = $parts[1];
?>
<script>
    let recordStatuses = [];
    const data = {
        "actionMethod": "getPendingWeights"
    }
    const tbody = document.getElementById('pendingWeightsBody');
    const form = document.querySelector('#weightment_form')

    function handleSelect(elem) {
        const ticketNo = elem.closest('tr').querySelector('.ticketNo').innerText
        if (elem.value === "add") {
            // Call your 'add record' function here
            fetchExistingData(ticketNo)
            // addRecord(ticketNo);
        } else if (elem.value === "print") {
            // Call your 'print' function here
            printRecord();
        } else if (elem.value === "complete") {
            // Call your 'print' function here
            updateTransaction(ticketNo, 2);
        } else if (elem.value === "delete") {
            // Call your 'print' function here
            updateTransaction(ticketNo, 3);
        } else if (elem.value === "pending") {
            // Call your 'print' function here
            updateTransaction(ticketNo, 1);
        }
        elem.value = 'choose'
    }


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
            "th_vehicle_number": labelNames.vehicle_number || "Vehicle No.",
            "th_party_name": labelNames.party_name || "Party Name",
            "th_material": labelNames.material || "Material",
            "th_weight": labelNames.weight || "Weight",
            "th_charges": labelNames.charges || "Charges"
        };

        Object.entries(mappings).forEach(([id, label]) => {
            const el = document.getElementById(id);
            if (el) {
                el.textContent = label;
            }
        });
    }

    const fetchData = async () => {
        const d = await getLabelConfiguration()

        updateTableHeaderLabels(d.newLables);
        const record_statuses = await getRecordStatusAPI();

        recordStatuses = record_statuses.data;

        tbody.innerHTML = '';
        let allRecords;
        const route = <?= json_encode($subRoute) ?>;


        if (route === 'pendingtransactions') {
            allRecords = await getPendingweingRecordsAPI();
        } else if (route === 'completedtransactions') {
            allRecords = await getCompletedweingRecordsAPI();
        } else {
            allRecords = await getAllweingRecordsAPI();
        }
        allRecords.data.forEach(record => {
            tbody.appendChild(createRow(record));
        });
    }
    fetchData()

    async function fetchAllTransactions() {
        allRecords = await getAllweingRecordsAPI();
        allRecords.data.forEach(record => {
            tbody.appendChild(createRow(record));
        });
    }
    async function fetchExistingData(ticketNo) {
        try {
            const response = await fetch("http://localhost/mechxweight/api", {
                method: 'POST',
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    "actionMethod": "getsinglerecordbyid",
                    "ticket_no": ticketNo
                })
            });
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            const Fetcheddata = await response.json();
            // Handle the fetched data here
            const data = Fetcheddata.data

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
        } catch (error) {
            console.error('There was a problem fetching the data:', error);
        }
    }

    function createRow(record) {
        const tr = document.createElement('tr');
        const firstWeight = record.weights ? record.weights.split(',')[0] : 0
        const secondWeight = record.weights ? record.weights.split(',')[1] : 0
        const netweight = secondWeight ? firstWeight - secondWeight : 0
        const weight = record.weight ?? 0
        const charges = record.charges ?? 0
        tr.innerHTML = `
            <td class="ticketNo">${record.ticket_no}</td>
            <td>${record.created_at.split(' ')[0]}</td>
            <td>${record.created_at.split(' ')[1]}</td>
            <td>${record.vehicle_number}</td>
            <td>${record.party_name}</td>
            <td>${record.material}</td>
            <td>${weight}</td>
            <td>${charges}</td>
            <td>${Math.abs(netweight)}</td>
            <td>${recordStatuses.find(item=>item.status_id === record.status)?.label || "Unknown"}</td>
            <td>
                <select id="actions"  class="form-select" onchange="handleSelect(this)">
                    <option value="choose" class="d-none" >Choose</option>
                    <option value="add">Add Record</option>
                    <option value="print">Print</option>
                    <option value="complete">Complete</option>
                    <option value="pending">Pending</option>
                    <option value="delete">Delete</option>
                </select>
            </td>
        `;
        return tr;
    }
</script>