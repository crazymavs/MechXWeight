const currentView = window.location.pathname.split('variance/');
$(document).ready(function() {

    if(currentView.length > 1){
        switch (currentView[1]) {
            case 'usermanagement':
                
                break;
            case 'dashboard':
                createLiveToggle();
                break;
            default:
                break;
        }
    }
    else{
        // getDashboardData();
    }
    $('.btnLogout').click(function (e) { 
        e.preventDefault();
        logout();
    });
    $('a.nav-link[href="' + window.location.pathname + '"]').addClass('active');
});

function logout() {
    $.ajax({
        url: ajaxBase + 'knplAPI.php',
        type: 'POST',
        data : {
            action_method : 'logout'
        },
        success: function(response) {
            console.log(response);
            if (response.status == 'success') {
                window.location.href = ajaxBase + response.redirect;
            } else {
                alert('Unable to logout!');
            }
        },
        error: function(xhr, error, message) {
            console.log(message);
        }
    });
}



function createLiveToggle() {
    $('#liveModeCheck').on('change', function (e) { 
        e.preventDefault();
        checkForLiveMode();
    });

    $('input[name="reportRange"]').on('change', function(e){
        e.preventDefault();
        if($('input[name="reportRange"]').is(':checked')){
            $('#liveModeCheck').prop('checked', false);
        }
        checkForLiveMode();
    });
}

function checkForLiveMode() {
    if($('#liveModeCheck').is(':checked')){
        $('#liveLabel').addClass('blink-label');
        $('#dashMode').text('(Live Mode)');
        $('input[name="reportRange"]').prop('checked', false);
    }else{
        $('#liveLabel').removeClass('blink-label');
        $('#dashMode').text('(Report Mode)');
        if(!$('input[name="reportRange"]').is(':checked')){
            $('#rdYesterday').prop('checked', true);
        }
        
    }
}




// let currentAction = ''; // create, edit, delete, disable
// let currentUserId = null;

// $(document).on('click', '.user-action', function () {
//     const action = $(this).data('action');
//     const userId = $(this).data('id');
//     currentUserId = userId;
//     currentAction = action;

//     if (action === 'edit') {
//         $('#mdUserUpdateTitle').text('Edit User');
//         $.ajax({
//             url: 'get_user.php',
//             method: 'POST',
//             data: { user_id: userId },
//             dataType: 'json',
//             success: function (user) {
//                 $('#user_id').val(user.id);
//                 $('#user_name').val(user.name);
//                 $('#user_username').val(user.username);
//                 $('#user_email').val(user.email);
//                 $('#user_is_admin').val(user.is_admin);
//                 $('#user_is_active').val(user.is_active);
//                 $('#btnSaveUserEdit').text('Save Changes');
//                 $('#mdUserUpdate').modal('show');
//             }
//         });
//     } else if (action === 'delete') {
//         if (confirm('Are you sure you want to delete this user?')) {
//             $.post('delete_user.php', { user_id: userId }, function (res) {
//                 alert(res);
//                 location.reload();
//             });
//         }
//     } else if (action === 'disable') {
//         $.post('toggle_user_status.php', { user_id: userId }, function (res) {
//             alert(res);
//             location.reload();
//         });
//     }
// });

// // Handle Save (Create or Edit)
// $('#btnSaveUserEdit').click(function () {
//     const data = {
//         user_id: $('#user_id').val(),
//         user_name: $('#user_name').val(),
//         user_username: $('#user_username').val(),
//         user_email: $('#user_email').val(),
//         user_is_admin: $('#user_is_admin').val(),
//         user_is_active: $('#user_is_active').val()
//     };

//     let url = currentAction === 'create' ? 'create_user.php' : 'update_user.php';

//     $.post(url, data, function (res) {
//         alert(res);
//         $('#mdUserUpdate').modal('hide');
//         location.reload();
//     });
// });
