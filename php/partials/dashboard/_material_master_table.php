<section class="col-12" id="material_table_section">
    <div class="d-flex justify-content-between">
        <h5><strong>All Materials</strong></h5>
        <div>
            <button type="button" class="btn btn-primary add_material_btn" data-bs-toggle="modal" data-bs-target="#addmaterialmodal">
                Add New
            </button>
        </div>
    </div>

    <div class="modal fade" id="addmaterialmodal" tabindex="-1" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Material</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="row g-3" id="add_material_form">
                    <div class="modal-body">
                        <div class="col-12">
                            <label for="inp_material_name" class="form-label">Material Name</label>
                            <input type="text" class="form-control" name="material_name" id="inp_material_name" required>
                        </div>
                        <div class="col-12">
                            <label for="inp_is_active" class="form-label">Active</label>
                            <select name="is_active" class="form-control" id="inp_is_active" required>
                                <option value="1" selected>Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="d-flex p-4 gap-2 justify-content-end">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="addmaterialmodalclosebtn">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <table class="table datatable">
        <thead>
            <tr>
                <th>Material Id</th>
                <th>Material Name</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="materialstableBody">
            <tr>
                <td colspan="4" class="text-center">Loading materials...</td>
            </tr>
        </tbody>
    </table>
</section>

<script>
    let materialModalCloseBtn = document.querySelector('#addmaterialmodalclosebtn')
    let materialModalAddBtn = document.querySelector('.add_material_btn')
    const materialForm = document.querySelector('#add_material_form');
    let isEdit = false
    let material_id = 0
    const company_id = <?= $_SESSION['user_company'] ?? 0 ?>;
    materialForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = new FormData(e.target)
        const data = {};
        for (const [name, value] of formData.entries()) {
            data[name] = value;
        }
        data['company_id'] = company_id;
        if (isEdit) {
            data['material_id'] = material_id;
            isEdit = false;
        }

        const res = await insertNewMaterialAPI(data);
        if (res.status) {
            const toastLiveExample = document.getElementById('successToast');
            $('.success-toast-body').text(res.message)
            const toastBootstrap = new bootstrap.Toast(toastLiveExample, {
                delay: 3000,
                autohide: true
            });
            toastBootstrap.show();
            fetchAndDisplayMaterials();
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
        materialModalCloseBtn.click();
        isEdit = false;
    });

    const deleteMaterialById = async (material_id) => {
        try {
            const res = await deleteMaterialAPI({
                material_id
            })
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
            console.error("Delete API error:", error);
        }
    };

    async function fetchAndDisplayMaterials() {
        try {
            const res = await getAllMaterialsAPI({
                company_id
            });
            if (res.status && res.data) {
                const materials = res.data;
                const tbody = document.querySelector('#material_table_section').querySelector('tbody');
                tbody.innerHTML = ''; // Clear existing table data
                materials.forEach(material => {
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td>${material.material_id || ''}</td>
                        <td>${material.material_name || ''}</td>
                        <td>${material.is_active == 1 ? 'active' : 'inactive'}</td>
                        <td>
                            <select class="form-select" id="material_actions" onchange="handleMaterialAction(this, ${material.material_id})">
                                <option value="choose" hidden>Choose</option>
                                <option value="edit">Edit</option>
                                <option value="delete">Delete</option>
                            </select>
                        </td>
                    `;
                    tbody.appendChild(tr);
                });
            } else {
                console.error('Error fetching materials:', res.message || 'Unknown error');
            }
        } catch (error) {
            console.error('Fetch error:', error);
        }
    }

    // Call this function on page load to populate the table
    fetchAndDisplayMaterials();

    async function handleEdit(materialId) {
        isEdit = true
        const res = await getMaterialByIdAPI(materialId);
        material_id = res.data.material_id
        materialModalAddBtn.click();
        document.getElementById('inp_material_name').value = res.data.material_name;

    }

    function handleMaterialAction(selectElem, materialId) {
        const action = selectElem.value;
        if (action === "delete") {
            deleteMaterialById(materialId);
        } else if (action === "edit") {
            // Implement edit functionality as needed
            handleEdit(materialId)
        }
        selectElem.value = 'choose'; // Reset select after action
    }
</script>