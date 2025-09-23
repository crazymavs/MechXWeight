<section class="col-12">
    <div class="d-flex justify-content-between">
        <h5><strong>All Vehicles</strong></h5>
        <div>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addvehiclemodal">
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
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
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
    const form = document.querySelector('#add_vehicle_form')
    form.addEventListener('submit', async (e) => {
        e.preventDefault()
        const formData = new FormData(e.target)
        const data = {};
        for (const [name, value] of formData.entries()) {
            data[name] = value;
        }
        console.log(data)

        const res = await inserNewVehicle(data)
        console.log(res)
    })

    async function fetchAndDisplayVehicles() {
        try {
            const response = await getAllVehicles()
            console.log(response)
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }

            const result = await response.json();

            if (result.status && result.data) {
                const vehicles = result.data;
                const tbody = document.getElementById('vehicletableBody');
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
                        <select id="actions"  class="form-select" onchange="handleSelect(this)">
                            <option value="choose" class="d-none" >Choose</option>
                            <option value="add">Edit</option>
                            <option value="print">Delete</option>
                        </select>
                    </td>
                `;

                    tbody.appendChild(tr);
                });
            } else {
                console.error('Error fetching vehicles:', result.message || 'Unknown error');
            }
        } catch (error) {
            console.error('Fetch error:', error);
        }
    }

    // Example usage: Call the function to populate the table on page load
    fetchAndDisplayVehicles();
</script>