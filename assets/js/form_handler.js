function getUsersFromPhone(phoneNo) {
    $.ajax({
        url: 'ajax_handler.php',
        type: 'POST',
        data : {
            // action_method : 'getUserFromPhone',
            action_method : 'getfeedBackFromPhone',
            phone_no : phoneNo
        },
        success: function(response) {
            $('.preloader').hide();
            let user = JSON.parse(response);
            if(user.length > 0){
                populateUserData(user[0]);
            }else{
                $('#feedback').val('');
                $('#feedbackFullName').val('');
            }
        },
        error: function(xhr, error, message) {
            console.log(message);
            $('.preloader').hide();
        }
    });
}

// function populateUserData(user) {
//     $("#frmRegister")[0].reset();
//     $('#imageInfo').hide();

//     //Update all form  fields
//     $('#tel').val(user.tel);
//     $('#carRegNo').val(user.carRegNo);
//     $('#occupation').val(user.occupation);
//     $('#location').val(user.location);
//     $('#orgName').val(user.orgName);
//     $('#hobby').val(user.hobby);
//     $('#aboutYourself').val(user.aboutYourself);

//     //Show image and disclaimer if image is already uploaded
//     if(user.elitePhoto !== null){
//         const imgUrl = window.location.href + 'assets/img/photoUploads/' +  user.elitePhoto;
//     $('#uploadedImage').attr('src', imgUrl);
//     $('#imageInfo').show();
//     }
    
//     //Focus on name.
//     $('#fullName').val(user.fullName).focus();
// }

// function saveUserDataForm(formData) {
//     $.ajax({
//         type: 'POST',
//         url: 'ajax_handler.php',
//         data: {
//             userData: formData
//         },
//         cache: false,
//         contentType: false,
//         processData: false,
//         success: function (data) {
//             alert(data);
//             $("#frmRegister")[0].reset();
//         },
//         error: function (data) {
//             alert("Error: " + data);
//         }
//     });
// }

function saveUserData() {
    var formData = new FormData();
    formData.append('action_method', 'createUser');
    formData.append('tel', $('#tel').val());
    formData.append('fullName', $('#fullName').val());
    formData.append('carRegNo', $('#carRegNo').val());
    formData.append('occupation', $('#occupation').val());
    formData.append('location', $('#location').val());
    formData.append('orgName', $('#orgName').val());
    formData.append('hobby', $('#hobby').val());
    formData.append('aboutYourself', $('#aboutYourself').val());
    formData.append('elitePhoto', $('#elitePhoto')[0].files[0]);
    $.ajax({
        url: 'ajax_handler.php', 
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            alert(response);
            $("#frmRegister")[0].reset();
            $('#imageInfo').hide();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert('File upload failed!');
        }
    });
}

function populateUserData(user) {
    $("#frmEliteFeedback")[0].reset();

    //Update all form  fields
    $('#feedbackTel').val(user.tel);
    $('#feedback').val(user.feedback);
    
    //Focus on name.
    $('#feedbackFullName').val(user.fullName).focus();
}

function saveFeedback() {
    var formData = new FormData();
    formData.append('action_method', 'createFeedback');
    formData.append('tel', $('#feedbackTel').val());
    formData.append('feedback', $('#feedback').val());
    $.ajax({
        url: 'ajax_handler.php', 
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            alert(response);
            $("#frmEliteFeedback")[0].reset();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert('Feedback failed!');
        }
    });
}
    