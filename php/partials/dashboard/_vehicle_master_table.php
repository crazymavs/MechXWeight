<section class="col-12 " id="vehicle_table_section">
    <div class="d-flex justify-content-between">
        <h5><strong>All Vehicles</strong></h5>
        <div>
            <button type="button" class="btn btn-primary addvehiclemodal" data-bs-toggle="modal" data-bs-target="#addvehiclemodal">
                Add New
            </button>
        </div>

    </div>
    <div class="modal fade" id="addvehiclemodal" tabindex="-1" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Vehicle</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="row g-3" id="add_vehicle_form">
                    <div class="modal-body">

                        <div class="col-12">
                            <label for="inp_vehicle_owner" class="form-label">Owner name</label>
                            <input type="text" class="form-control" name="owner_name" id="inp_vehicle_owner">
                        </div>
                        <div class="col-12">
                            <label for="inp_vehicle_number" class="form-label">Vehicle number</label>
                            <input type="text" class="form-control" name="vehicle_number" id="inp_vehicle_number">
                        </div>
                        <div class="col-12">
                            <label for="inp_vehicle_weight" class="form-label">Vehicle weight</label>
                            <input type="number" class="form-control" name="vehicle_weight" id="inp_vehicle_weight">
                        </div>


                        <div class="d-flex p-4 gap-2 justify-content-end">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="addvehiclemodalclosebtn">Close</button>
                            <button type=" submit" class="btn btn-primary">Save changes</button>
                        </div>
                </form>
            </div>

        </div>
    </div>
    </div>
    <table class="table datatable">
        <thead>
            <tr>
                <th>Id</th>
                <th>Owner</th>
                <th>Vehicle No.</th>
                <th>Weight</th>
                <th>Created At</th>
                <th>Status</th>
                <th>Action</th>

            </tr>
        </thead>
        <tbody id="vehicletableBody">
            <tr>
                <td>90809</td>
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
    const modalCloseBtn = document.querySelector('#addvehiclemodalclosebtn')
    const addVehicleBtn = document.querySelector('.addvehiclemodal')
    const form = document.querySelector('#add_vehicle_form')
    let isEdit = false
    let vehicle_id = 0
    const company_id = <?= $_SESSION['user_company'] ?? 0 ?>;
    form.addEventListener('submit', async (e) => {
        e.preventDefault()
        const formData = new FormData(e.target)
        const data = {};
        for (const [name, value] of formData.entries()) {
            data[name] = value;
        }
        data['company_id'] = company_id;
        if (isEdit) {
            data['vehicle_id'] = vehicle_id;
            isEdit = false;
        }

        const res = await inserNewVehicleAPI(data)

        if (res.status) {
            const toastLiveExample = document.getElementById('successToast');
            $('.success-toast-body').text(res.message)
            const toastBootstrap = new bootstrap.Toast(toastLiveExample, {
                delay: 3000,
                autohide: true
            });
            toastBootstrap.show();
            fetchAndDisplayVehicles()
        } else {
            const toastLiveExample = document.getElementById('errorToast');
            $('.error-toast-body').text(res.message)
            const toastBootstrap = new bootstrap.Toast(toastLiveExample, {
                delay: 3000,
                autohide: true
            });
            toastBootstrap.show();
        }
        e.target.reset();
        modalCloseBtn.click()
        isEdit = false;
    })

    async function fetchAndDisplayVehicles() {
        try {
            const res = await getAllVehiclesAPI({
                company_id
            })
            if (res.status) {
                const vehicles = res.data;
                const tbody = document.querySelector('#vehicle_table_section').querySelector('tbody');
                tbody.innerHTML = ''; // Clear existing table data

                vehicles.forEach(vehicle => {
                    const tr = document.createElement('tr');

                    tr.innerHTML = `
                    <td>${vehicle.vehicle_id || ''}</td>
                    <td>${vehicle.vehicle_owner || ''}</td>
                    <td>${vehicle.vehicle_number || ''}</td>
                    <td>${vehicle.vehicle_weight || ''}</td>
                    <td>${vehicle.vehicle_created_at || ''}</td>
                    <td>${vehicle.vehicle_status?'active': 'inactive'}</td>
                     <td>
                        <select id="actions"  class="form-select" onchange="handleVehicleAction(this, ${vehicle.vehicle_id})">
                            <option value="choose" class="d-none" >Choose</option>
                            <option value="edit">Edit</option>
                            <option value="delete">Delete</option>
                        </select>
                    </td>
                `;

                    tbody.appendChild(tr);
                });
            } else {
                console.error('Error fetching vehicles:');
            }
        } catch (error) {
            console.error('Fetch error:', error);
        }
    }

    const deleteVehicleById = async (vehicle_id) => {
        try {
            const res = await deleteVehicleAPI({
                vehicle_id
            })
            if (res.status) {
                const toastLiveExample = document.getElementById('successToast');
                $('.success-toast-body').text(res.message);
                const toastBootstrap = new bootstrap.Toast(toastLiveExample, {
                    delay: 3000,
                    autohide: true,
                });
                toastBootstrap.show();

                // Refresh the parties list after deletion
                fetchAndDisplayParties();
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
            console.error("Delete API error:", error);
        }
        fetchAndDisplayVehicles();
    };
    // Example usage: Call the function to populate the table on page load
    async function handleEdit(vehicleId) {
        isEdit = true
        const res = await getVehicleByIdAPI(vehicleId);
        vehicle_id = res.data.vehicle_id
        addVehicleBtn.click();
        document.getElementById('inp_vehicle_owner').value = res.data.vehicle_owner;
        document.getElementById('inp_vehicle_number').value = res.data.vehicle_number;
        document.getElementById('inp_vehicle_weight').value = res.data.vehicle_weight;

    }

    function handleVehicleAction(selectElem, vehicleId) {
        const action = selectElem.value;
        // Implement edit/delete actions as needed
        if (action === "delete") {
            deleteVehicleById(vehicleId);
        } else if (action === "edit") {
            // handle edit
            handleEdit(vehicleId);
        }
        selectElem.value = 'choose'; // Reset select after action
    }

    fetchAndDisplayVehicles();
</script>