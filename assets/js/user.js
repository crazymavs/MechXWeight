$(function () {
    $('#changePasswordForm').on('submit', function (e) {
        e.preventDefault(); // stop form from submitting normally
        e.stopPropagation(); // stop form from submitting normally
    
        const successToast = document.getElementById('successToast');
        const errorToast = document.getElementById('errorToast');
        let currentPassword = $('#currentPassword').val().trim();
        let newPassword = $('#newPassword').val().trim();
        let renewPassword = $('#renewPassword').val().trim();
    
        // Basic validation
        if (!currentPassword || !newPassword || !renewPassword) {
            $('.error-toast-body').text('All fields are required.')
            const toastBootstrap = new bootstrap.Toast(errorToast, { delay: 3000, autohide: true });
            toastBootstrap.show();
            return;
        }
    
        if (newPassword.length < 6) {
            $('.error-toast-body').text('New password must be at least 6 characters.')
            const toastBootstrap = new bootstrap.Toast(errorToast, { delay: 3000, autohide: true });
            toastBootstrap.show();
            return;
        }
    
        if (newPassword !== renewPassword) {
            $('.error-toast-body').text('New password and confirm password do not match.')
            const toastBootstrap = new bootstrap.Toast(errorToast, { delay: 3000, autohide: true });
            toastBootstrap.show();
            return;
        }
    
        // Proceed with AJAX call
        $.ajax({
            url: 'knplAPI.php',
            type: 'POST',
            dataType: 'json',
            data: {
                "action_method": 'changePassword',
                "current_password": currentPassword,
                "new_password": newPassword
            },
            success: function (response) {
                if (response.status) {
                    $('#changePasswordForm')[0].reset();
                    $('.success-toast-body').text(response.message || 'Password successfully changed.')
                    const toastBootstrap = new bootstrap.Toast(successToast, { delay: 3000, autohide: true });
                    toastBootstrap.show();
                } else {
                    $('.error-toast-body').text(response.message || 'Failed to update password.')
                    const toastBootstrap = new bootstrap.Toast(errorToast, { delay: 3000, autohide: true });
                    toastBootstrap.show();
                }
            },
            error: function (xhr, status, error) {
                console.log('AJAX error:', error);
                console.log('Server response:', xhr.responseText);
                $('.error-toast-body').text('Unknown technical error!')
                const toastBootstrap = new bootstrap.Toast(errorToast, { delay: 3000, autohide: true });
                toastBootstrap.show();
            }
        });
    });
    
});