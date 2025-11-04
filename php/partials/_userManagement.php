<section class="section">
    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Mecho-Tronix Users</h5>
                    <p>
                    <div class="row">
                        <div class="col-md-8">
                            Editing of users is to the end of each row.
                        </div>
                        <div class="col-md-2 text-end">
                            <button class="btn btn-info" id="btnExportUsers">Export&nbsp;&nbsp;<i class="fa-duotone fa-solid fa-download"></i></button>
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-primary" id="btnCreateNewUser" data-bs-toggle="modal" data-bs-target="#mdUserUpdate">Create New User&nbsp;&nbsp;<i class="fa-duotone fa-solid fa-user-plus"></i></button>
                        </div>

                    </div>
                    </p>

                    <div class="table-responsive">
                        <!-- Table with stripped rows -->
                        <table class="table" id="tblUser">
                            <thead>
                                <tr>
                                    <th>Sl. No.</th>
                                    <th>Full Name</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>User Type</th>
                                    <th>User Status</th>
                                    <th>User Created On</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="userTable">

                            </tbody>
                        </table>
                        <!-- End Table with stripped rows -->
                    </div>

                </div>
            </div>

        </div>
    </div>
</section>

<div class="modal fade" id="mdUserUpdate" tabindex="-1" aria-labelledby="mdUserUpdateTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="mdUserUpdateTitle"><i class="fa-duotone fa-solid fa-user-plus"></i>&nbsp;&nbsp;Create User</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formUserEdit">
                    <input type="hidden" id="user_id">
                    <div class="mb-3">
                        <label for="user_name" class="form-label">Full Name</label>
                        <input type="text" class="form-control" required id="user_name" required>
                    </div>
                    <div class="mb-3" id="userNameField">
                        <label for="user_username" class="form-label">Username</label>
                        <input type="text" class="form-control" required id="user_username">
                    </div>
                    <div class="mb-3" id="emailField">
                        <label for="user_email" class="form-label">Email</label>
                        <input type="email" class="form-control" required id="user_email" required>
                    </div>
                    <div class="mb-3" id="passwordField">
                        <label for="user_password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="user_password">
                    </div>
                    <div class="mb-3">
                        <label for="user_is_admin" class="form-label">User Type</label>
                        <select class="form-select" id="user_is_admin">
                            <option value="1">Super Admin</option>
                            <option value="2">Admin</option>
                            <option value="3">Supervisor</option>
                            <option value="4">Operator</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="user_is_active" class="form-label">Status</label>
                        <select class="form-select" id="user_is_active">
                            <option value="1">Active</option>
                            <option value="0">Disabled</option>
                        </select>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary close_user_form" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="btnSaveUserEdit">Save changes</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="mdlDeleteUser" tabindex="-1" aria-labelledby="mdlDeleteUserTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h1 class="modal-title fs-5" id="mdlDeleteUserTitle"><i class="fa-duotone fa-solid fa-user-slash"></i> Delete User</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="user_name" class="form-label">Are you Sure you want to delete user with following details? </label>
                </div>
                <div class="mb-3 d-flex justify-content-center align-items-center">
                    <table class="table table-striped">
                        <tbody>
                            <tr>
                                <td scope="col"><strong>Name</strong></td>
                                <td id="deleteUserFullName"></td>
                            </tr>
                            <tr>
                                <td scope="col"><strong>Username</strong></td>
                                <td id="deleteUserName"></td>
                            </tr>
                            <tr>
                                <td scope="col"><strong>User Email</strong></td>
                                <td id="deleteUserEmail"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="mb-3">
                    <span class="text-danger"><i class="fa-duotone fa-solid fa-triangle-exclamation"></i>&nbsp;&nbsp;Please note that this action is irriversible and cannot bring this user or user data back once deleted.</span>
                </div>
            </div>


            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No, Don't Delete</button>
                <button type="button" class="btn btn-danger" id="btnConfirmDelete">Confirm Delete</button>
            </div>
        </div>
    </div>
</div>

<input type="hidden" id="loggedInUserEmail" value="<?= $_SESSION['user_email']; ?>" name="">
<input type="hidden" id="loggedInUserCompany" value="<?= $_SESSION['user_company']; ?>" name="">