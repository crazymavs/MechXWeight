<section class="col-12">
    <h5><strong>Pending Records</strong></h5>
    <table class="table datatable">
        <thead>
            <tr>
                <th>Ticket No.</th>
                <th>Date</th>
                <th>Time</th>
                <!-- <th>Weighment Type</th> -->
                <th>Vehicle No.</th>
                <th>Party Name</th>
                <th>Material</th>
                <th>Weight</th>
                <th>Charges</th>
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
</section>

<script>
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
        }
        elem.value = 'choose'
    }

    // const addMaterialButton = document.querySelector('#add_material_button')

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
            console.log({
                data
            })
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
                // You can add more logic if you want to display netWeight as well
                // const netWeightField = document.getElementById(`weighment_form_new_weight_${idx + 1}`);
                // if (netWeightField && netWeights[idx] !== undefined) netWeightField.value = netWeights[idx];
            });

            // Example: assuming your form fields have these IDs
            document.getElementById('weighment_form_ticket_no').value = data.ticket_no || '';
            document.getElementById('weighment_form_vehicle_no').value = data.vehicle_number || '';
            document.getElementById('weighment_form_party_name').value = data.party_name || '';
            // document.getElementById('weighment_form_material').value = data.material || '';
            // document.getElementById('weighment_form_charges').value = data.charges || '';
            // document.getElementById('weighment_form_weight_1').value = w1;
            // document.getElementById('weighment_form_weight_2').value = w2;
            // document.getElementById('weighment_form_new_weight').value = nw;
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
            // Example: populate form fields
            // document.getElementById('someField').value = data.someField;
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
            <td>${record.is_pending ? "Pending" :"Completed"}</td>
            <td>
                <select id="actions"  class="form-select" onchange="handleSelect(this)">
                    <option value="choose" class="d-none" >Choose</option>
                    <option value="add">Add Record</option>
                    <option value="print">Print</option>
                </select>
            </td>
        `;
        return tr;
    }

    // Clear existing rows if any

    tbody.innerHTML = '';
    fetch(apiBase, {
            method: 'POST',
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(data) // Just pass FormData—do NOT set headers
        })
        .then(response => response.json()).then(result => {
            console.log(result)

            // Loop through array and append rows
            result.data.forEach(record => {
                tbody.appendChild(createRow(record));
            });
        })
</script>