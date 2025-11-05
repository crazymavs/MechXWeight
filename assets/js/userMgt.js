function handleResponse(res) {
  if (res.status) {
    // alert("success")
    const toastLiveExample = document.getElementById("successToast");
    $(".success-toast-body").text(res.message);
    const toastBootstrap = new bootstrap.Toast(toastLiveExample, {
      delay: 3000,
      autohide: true,
    });
    toastBootstrap.show();
  } else {
    // alert('error')
    const toastLiveExample = document.getElementById("errorToast");
    $(".error-toast-body").text(res.message);
    const toastBootstrap = new bootstrap.Toast(toastLiveExample, {
      delay: 3000,
      autohide: true,
    });
    toastBootstrap.show();
  }
}

let userTypes = [];
async function getUserTypes() {
  const res = await fetch("http://localhost/mechxweight/api", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({
      actionMethod: "get_user_types",
    }),
  });
  const data = await res.json();
  console.log(data);
  userTypes = data.data;
  //   handleResponse(data);
  return data.data;
}

$(function () {
  const closerUserFormBtn = document.querySelector(".close_user_form");
  function exportUserTable() {
    $("#tblUser").excelexportjs({
      containerid: "tblUser",
      datatype: "table",
    });
  }

  function onSuccessFectch(data) {
    console.log({ data, userTypes });
    let rows = "";
    let loggedInEmail = $("#loggedInUserEmail").val();

    data.forEach(function (user) {
      const usertype = userTypes.find(
        (item) => item.user_type_id === parseInt(user.user_type)
      )?.user_type;
      console.log({ usertype, user, userTypes });
      let deleteButton = "";
      if (loggedInEmail !== user.email) {
        deleteButton = `
                            &nbsp;&nbsp;|&nbsp;&nbsp;
                            <button class="btn btn-sm btn-danger deleteUser" data-id="${user.user_id}" title="Delete User">
                                <i class="fa-duotone fa-solid fa-trash"></i>
                            </button>`;
      }

      rows += `
                        <tr data-user-id="${user.user_id}" 
                            data-user-name="${user.user_name}" 
                            data-user-username="${user.user_username}" 
                            data-user-email="${user.user_email}" 
                            data-user-admin="${user.user_type}" 
                            data-user-active="${user.user_is_active ? 1 : 0}">
                            <td>${user.user_id}</td>
                            <td>${user.user_name}</td>
                            <td>${user.user_username}</td>
                            <td>${user.user_email}</td>
                            <td>${usertype ?? "NA"}</td>
                            <td>${
                              user.user_is_active ? "Active" : "Inactive"
                            }</td>
                            <td>${user.user_created_at}</td>
                            <td>
                                <button class="btn btn-sm btn-primary editUser" data-id="${
                                  user.user_id
                                }" title="Edit User">
                                    <i class="fa-duotone fa-solid fa-user-pen"></i>
                                </button>
                                ${deleteButton}
                            </td>
                        </tr>
                    `;
    });

    $("#userTable").html(rows);

    $(document).on("click", ".editUser", function () {
      let row = $(this).closest("tr");

      // Fetch data from <tr> attributes
      let id = row.data("user-id");
      let name = row.data("user-name");
      let username = row.data("user-username");
      let email = row.data("user-email");
      let isAdmin = row.data("user-admin");
      let isActive = row.data("user-active");

      // Fill modal fields
      $("#user_id").val(id);
      $("#user_name").val(name);
      $("#user_username").val(username);
      $("#user_email").val(email);
      $("#user_is_admin").val(isAdmin);
      $("#user_is_active").val(isActive);

      $("#userNameField").hide();
      $("#emailField").hide();

      // Set modal title
      $("#mdUserUpdateTitle").html(
        '<i class="fa-duotone fa-solid fa-user-pen"></i>&nbsp;&nbsp;Edit User'
      );

      // Show modal
      $("#mdUserUpdate").modal("show");
    });

    //Delete User
    $(document).on("click", ".deleteUser", function () {
      let row = $(this).closest("tr");

      $("#deleteUserFullName").text(row.data("user-name"));
      $("#deleteUserName").text(row.data("user-username"));
      $("#deleteUserEmail").text(row.data("user-email"));

      $("#mdlDeleteUser").modal("show");
    });
  }

  async function getUsers() {
    const companyid = $("#loggedInUserCompany").val();
    console.log({ companyid });
    const res = await fetch("http://localhost/mechxweight/api", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },

      body: JSON.stringify({
        actionMethod: "getUsers",
        companyid,
      }),
    });

    const data = await res.json();
    console.log(data);
    onSuccessFectch(data.data);
  }

  //Create new user
  if ($("#btnCreateNewUser")) {
    $("#btnCreateNewUser").on("click", function () {
      $("#formUserEdit")[0].reset();
      $("#user_id").val("");
      $("#mdUserUpdateTitle").html(
        '<i class="fa-duotone fa-solid fa-user-plus"></i>&nbsp;&nbsp;Create User'
      );
      $("#userNameField").show();
      $("#emailField").show();
      $("#passwordField").show();
      $(".is-invalid").removeClass("is-invalid");
      $("#mdUserUpdate").modal("show");
    });
  }

  async function saveEditUser(data) {
    console.log(data);
    const res = await fetch("http://localhost/mechxweight/api", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        actionMethod: "saveuser",
        ...data,
      }),
    });
    const response = await res.json();
    console.log(response);
    const form = document.querySelector("#formUserEdit");
    console.log({ closerUserFormBtn, form });
    form.reset();
    closerUserFormBtn.click();
    handleResponse(response);
  }

  $("#btnSaveUserEdit").on("click", function () {
    let isValid = true;

    // Loop through visible inputs/selects inside the form
    $("#formUserEdit")
      .find("input:visible, select:visible, textarea:visible")
      .each(function () {
        const $field = $(this);
        if ($field.prop("required") && !$field.val().trim()) {
          isValid = false;
          $field.addClass("is-invalid");
        } else {
          $field.removeClass("is-invalid");
        }
      });

    if (!isValid) {
      const toastLiveExample = document.getElementById("errorToast");
      $(".error-toast-body").text("Please fill all fields");
      const toastBootstrap = new bootstrap.Toast(toastLiveExample, {
        delay: 3000,
        autohide: true,
      });
      toastBootstrap.show();
      return;
    }

    let formData = {
      user_id: $("#user_id").val() ? $("#user_id").val() : 0,
      user_name: $("#user_name").val(),
      user_username: $("#user_username").val(),
      user_email: $("#user_email").val(),
      user_password: $("#user_password").val(),
      user_type: $("#user_is_admin").val(),
      user_is_active: $("#user_is_active").val(),
      action_method: $("#user_id").val() ? "createUser" : "editUser",
      user_company: $("#loggedInUserCompany").val(),
    };
    saveEditUser(formData);
  });

  async function deleteUser(user_id) {
    const res = await fetch("http://localhost/mechxweight/api", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        actionMethod: "saveuser",
        user_id,
      }),
    });
    const response = await res.json();
    console.log(response);
    handleResponse(response);
  }

  $("#btnConfirmDelete").on("click", function (e) {
    let url = "knplAPI.php";

    $.ajax({
      url: "knplAPI.php",
      type: "POST",
      dataType: "json",
      data: {
        action_method: "deleteUser",
        user_name: $("#deleteUserFullName").text(),
        user_email: $("#deleteUserEmail").text(),
      },
      success: function (response) {
        console.log(response);
        if (response.status) {
          window.location.href = window.location.href;
        } else {
          const toastLiveExample = document.getElementById("errorToast");
          $(".error-toast-body").text(response.message);
          const toastBootstrap = new bootstrap.Toast(toastLiveExample, {
            delay: 3000,
            autohide: true,
          });
          toastBootstrap.show();
        }
      },
      error: function (xhr, error, message) {
        console.log(message);
      },
    });
  });

  $("#btnExportUsers").on("click", function () {
    exportUserTable();
  });

  async function fetchAll() {
    const userTypeData = await getUserTypes();
    console.log({ userTypeData });
    userTypes = userTypeData;
    await getUsers();
  }
  fetchAll();
});
