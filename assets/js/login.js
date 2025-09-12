$(document).ready(function() {
    $('#frmLogin').on('submit', function (e) {
        e.preventDefault();
        e.stopPropogation();
        getLogin();
    })
    $('#btnLogin').click(function (e) { 
        e.preventDefault();
        $('.has-validation').removeClass('was-validated');
        if($.trim($('#opUserName').val()).length == 0){
            $('#opUserName').parent('.has-validation').addClass('was-validated');
        }
        if($.trim($('#opPassword').val()).length == 0){
            $('#opPassword').parent('.has-validation').addClass('was-validated');
        }
        if($('.was-validated').length === 0){
            getLogin();
        }
        
    });
});

function getLogin() {
    $('#invalidUnPwd').removeClass('show');

    $.ajax({
        url: 'knplAPI.php',
        type: 'POST',
        data : {
            action_method : 'login',
            user_identifier : $('#opUserName').val(),
            user_password : $('#opPassword').val()
        },
        success: function(response) {
            console.log(response);
            if (response.status == 'success') {
                window.location.href = ajaxBase + response.redirect;;
            } else {

                const toastLiveExample = document.getElementById('errorToast');
                $('.error-toast-body').text("Invalid Username / Password")
                const toastBootstrap = new bootstrap.Toast(toastLiveExample, { delay: 3000, autohide: true });
                toastBootstrap.show();
            }
        },
        error: function(xhr, error, message) {
            console.log(message);
        }
    });
}