<section class="col-12" id="party_table_section">
    <div class=" d-flex justify-content-between">
        <h5><strong>All Parties</strong></h5>
        <div>
            <button type="button" class="btn btn-primary addpartymodal" data-bs-toggle="modal" data-bs-target="#addpartymodal">
                Add New
            </button>
        </div>
    </div>

    <div class="modal fade" id="addpartymodal" tabindex="-1" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Party</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="row g-3" id="add_party_form">
                    <div class="modal-body">
                        <div class="col-12">
                            <label for="inp_party_name" class="form-label">Party Name</label>
                            <input type="text" class="form-control" name="party_name" id="inp_party_name" required>
                        </div>
                        <div class="col-12">
                            <label for="inp_party_email" class="form-label">Party Email</label>
                            <input type="email" class="form-control" name="party_email" id="inp_party_email" required>
                        </div>
                        <div class="col-12">
                            <label for="inp_party_phone" class="form-label">Party Phone</label>
                            <input type="tel" class="form-control" name="party_phone" id="inp_party_phone" required>
                        </div>
                    </div>
                    <div class="d-flex p-4 gap-2 justify-content-end">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="addpartymodalclosebtn">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <table class="table datatable">
        <thead>
            <tr>
                <th>Id</th>
                <th>Party Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Created At</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="partiestableBody">
            <tr>
                <td colspan="7" class="text-center">Loading parties...</td>
            </tr>
        </tbody>
    </table>
</section>

<script>
    modalCloseBtn = document.querySelector('#addpartymodalclosebtn')
    const addPartyBtn = document.querySelector('.addpartymodal')
    const partyForm = document.querySelector('#add_party_form');
    let isEdit = false
    let party_id = 0
    partyForm.addEventListener('submit', async (e) => {
        e.preventDefault()
        const formData = new FormData(e.target)
        const data = {};
        for (const [name, value] of formData.entries()) {
            data[name] = value;
        }
        if (isEdit) {
            data['party_id'] = party_id;
            isEdit = false;
        }

        const res = await insertNewParty(data);
        if (res.status) {
            const toastLiveExample = document.getElementById('successToast');
            $('.success-toast-body').text(res.message)
            const toastBootstrap = new bootstrap.Toast(toastLiveExample, {
                delay: 3000,
                autohide: true
            });
            toastBootstrap.show();
            fetchAndDisplayParties();
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
    });

    const deletePartyById = async (party_id) => {
        try {
            const res = await deleteParty({
                party_id
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
    };

    async function fetchAndDisplayParties() {
        try {
            const res = await getAllParties();
            if (res.status && res.data) {
                const parties = res.data;
                const tbody = document.querySelector('#party_table_section').querySelector('tbody');
                tbody.innerHTML = ''; // Clear existing table data

                parties.forEach(party => {
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td>${party.party_id || ''}</td>
                        <td>${party.party_name || ''}</td>
                        <td>${party.party_email || ''}</td>
                        <td>${party.party_phone || ''}</td>
                        <td>${party.party_created_at || ''}</td>
                        <td>${party.party_status ? 'active' : 'inactive'}</td>
                        <td>
                            <select class="form-select" id="party_actions" onchange="handlePartyAction(this, ${party.party_id})">
                                <option value="choose" hidden>Choose</option>
                                <option value="edit">Edit</option>
                                <option value="delete">Delete</option>
                            </select>
                        </td>
                    `;
                    tbody.appendChild(tr);
                });
            } else {
                console.error('Error fetching parties:', result.message || 'Unknown error');
            }
        } catch (error) {
            console.error('Fetch error:', error);
        }
    }

    async function handleEdit(partyId) {
        isEdit = true
        const res = await getPartyByIdAPI(partyId);
        party_id = res.data.party_id
        addPartyBtn.click();
        document.getElementById('inp_party_name').value = res.data.party_name;
        document.getElementById('inp_party_email').value = res.data.party_email;
        document.getElementById('inp_party_phone').value = res.data.party_phone;

    }

    function handlePartyAction(selectElem, partyId) {
        const action = selectElem.value;
        // Implement edit/delete actions as needed
        if (action === "delete") {
            deletePartyById(partyId);
        } else if (action === "edit") {
            // handle edit
            handleEdit(partyId);
        }
        selectElem.value = 'choose'; // Reset select after action
    }
    fetchAndDisplayParties();
</script>