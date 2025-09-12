$(function () {


    function exportUserTable() {
        $("#tblUser").excelexportjs({
            containerid:"tblUser",
            datatype:'table'
        });
    }

    function getUsers() {
        $.ajax({
            url: 'knplAPI.php',
            type: 'POST',
            data : {
                action_method : 'getUsers'
            },
            success: function(data) {
                let rows = '';
                let loggedInEmail = $('#loggedInUserEmail').val();

                data.forEach(function(user) {
                    let deleteButton = '';
                    if (loggedInEmail !== user.email) {
                        deleteButton = `
                            &nbsp;&nbsp;|&nbsp;&nbsp;
                            <button class="btn btn-sm btn-danger deleteUser" data-id="${user.userid}" title="Delete User">
                                <i class="fa-duotone fa-solid fa-trash"></i>
                            </button>`;
                    }

                    rows += `
                        <tr data-user-id="${user.userid}" 
                            data-user-name="${user.name}" 
                            data-user-username="${user.username}" 
                            data-user-email="${user.email}" 
                            data-user-admin="${user.type == 'Admin' ? 1 : 0}" 
                            data-user-active="${user.status == 'Active' ? 1 : 0}">
                            <td>${user.slno}</td>
                            <td>${user.name}</td>
                            <td>${user.username}</td>
                            <td>${user.email}</td>
                            <td>${user.type}</td>
                            <td>${user.status}</td>
                            <td>${user.created}</td>
                            <td>
                                <button class="btn btn-sm btn-primary editUser" data-id="${user.userid}" title="Edit User">
                                    <i class="fa-duotone fa-solid fa-user-pen"></i>
                                </button>
                                ${deleteButton}
                            </td>
                        </tr>
                    `;
                });

                $('#userTable').html(rows);

                $(document).on('click', '.editUser', function () {
                    let row = $(this).closest('tr');
                
                    // Fetch data from <tr> attributes
                    let id = row.data('user-id');
                    let name = row.data('user-name');
                    let username = row.data('user-username');
                    let email = row.data('user-email');
                    let isAdmin = row.data('user-admin');
                    let isActive = row.data('user-active');
                
                    // Fill modal fields
                    $('#user_id').val(id);
                    $('#user_name').val(name);
                    $('#user_username').val(username);
                    $('#user_email').val(email);
                    $('#user_is_admin').val(isAdmin);
                    $('#user_is_active').val(isActive);

                    $('#userNameField').hide();
                    $('#emailField').hide();
                
                    // Set modal title
                    $('#mdUserUpdateTitle').html('<i class="fa-duotone fa-solid fa-user-pen"></i>&nbsp;&nbsp;Edit User');
                
                    // Show modal
                    $('#mdUserUpdate').modal('show');
                });

                //Delete User
                $(document).on('click', '.deleteUser', function () {
                    let row = $(this).closest('tr');
                            
                    $('#deleteUserFullName').text(row.data('user-name'));
                    $('#deleteUserName').text(row.data('user-username'));
                    $('#deleteUserEmail').text(row.data('user-email'));

                    $('#mdlDeleteUser').modal('show');
                });
            },
            error: function() {
                $('#userTable').html('<tr><td colspan="7">Failed to load user data</td></tr>');
            }
        });
    }



    //Create new user
    if ($('#btnCreateNewUser')) {
        $('#btnCreateNewUser').on('click', function () {
            $('#formUserEdit')[0].reset();
            $('#user_id').val('');
            $('#mdUserUpdateTitle').html('<i class="fa-duotone fa-solid fa-user-plus"></i>&nbsp;&nbsp;Create User');
            $('#userNameField').show();
            $('#emailField').show();
            $('#passwordField').show();
            $('.is-invalid').removeClass('is-invalid');
            $('#mdUserUpdate').modal('show');
        });
    }

    $('#btnSaveUserEdit').on('click', function () {

        let isValid = true;

        // Loop through visible inputs/selects inside the form
        $('#formUserEdit').find('input:visible, select:visible, textarea:visible').each(function () {
            const $field = $(this);
            if ($field.prop('required') && !$field.val().trim()) {
                isValid = false;
                $field.addClass('is-invalid');
            } else {
                $field.removeClass('is-invalid');
            }
        });

        if (!isValid) {
            const toastLiveExample = document.getElementById('errorToast');
                    $('.error-toast-body').text("Please fill all fields")
                    const toastBootstrap = new bootstrap.Toast(toastLiveExample, { delay: 3000, autohide: true });
                    toastBootstrap.show();
            return;
        }


        let formData = {
            user_id: $('#user_id').val() ? $('#user_id').val() : 0,
            user_name: $('#user_name').val(),
            user_username: $('#user_username').val(),
            user_email: $('#user_email').val(),
            user_password: $('#user_password').val(),
            user_is_admin: $('#user_is_admin').val(),
            user_is_active: $('#user_is_active').val(),
            action_method: $('#user_id').val() ? 'createUser' : 'editUser'
        };
    
        let url= 'knplAPI.php';

        $.ajax({
            url: 'knplAPI.php',
            type: 'POST',
            dataType: 'json',
            data : {
                "action_method" : $('#user_id').val() == '' ? 'createUser' : 'editUser',
                "user_id": $('#user_id').val(),
                "user_name": $('#user_name').val(),
                "user_username": $('#user_username').val(),
                "user_email": $('#user_email').val(),
                "user_password": $('#user_password').val(),
                "user_is_admin": $('#user_is_admin').val(),
                "user_is_active": $('#user_is_active').val(),
            },
            success: function(response) {
                console.log(response);
                if (response.status) {
                    window.location.href = window.location.href;
                }else{
                    const toastLiveExample = document.getElementById('errorToast');
                    $('.error-toast-body').text(response.message)
                    const toastBootstrap = new bootstrap.Toast(toastLiveExample, { delay: 3000, autohide: true });
                    toastBootstrap.show();
                }
                window.location.href = window.location.href;
            },
            error: function(xhr, error, message) {
                console.log(message);
            }
        });
    });

    $('#btnConfirmDelete').on('click', function (e) { 
    
        let url= 'knplAPI.php';

        $.ajax({
            url: 'knplAPI.php',
            type: 'POST',
            dataType: 'json',
            data : {
                "action_method" : 'deleteUser',
                "user_name": $('#deleteUserFullName').text(),
                "user_email": $('#deleteUserEmail').text(),
            },
            success: function(response) {
                console.log(response);
                if (response.status) {
                    window.location.href = window.location.href;
                }else{
                    const toastLiveExample = document.getElementById('errorToast');
                    $('.error-toast-body').text(response.message)
                    const toastBootstrap = new bootstrap.Toast(toastLiveExample, { delay: 3000, autohide: true });
                    toastBootstrap.show();
                }
            },
            error: function(xhr, error, message) {
                console.log(message);
            }
        });
    });

    
    

    $('#btnExportUsers').on('click', function () {
        exportUserTable();
    });
    getUsers();

});