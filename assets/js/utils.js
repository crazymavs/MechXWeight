if (typeof getLabelConfiguration === "undefined") {
  const getLabelConfiguration = async () => {
    const res = await getLabelConfigAPI();
    let newLables = {};
    if (res.status) {
      newLables = res.data.reduce((acc, item) => {
        acc[item.column_name] = {
          name: item.label_name,
          enabled: item.enabled,
        };
        return acc;
      }, {});
    }
    return {
      data: res.data,
      newLables,
    };
  };
  window.getLabelConfiguration = getLabelConfiguration; // export globally
}

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

function handleAddItemClick(e) {
  const original = e.target.closest("form").querySelector(".material_detail");
  const clone = original.cloneNode(true); // Deep clone including children
  // Clear input values in cloned node
  clone.querySelectorAll("input").forEach((input) => {
    input.value = "";
  });
  const materialDetail_container = e.target
    .closest("form")
    .querySelector(".material_detail").parentNode;
  materialDetail_container.appendChild(clone);
  // Update all material index labels and IDs
  const allMaterials =
    materialDetail_container.querySelectorAll(".material_detail");

  allMaterials.forEach((materialDiv, index) => {
    const label = materialDiv.querySelector(".material-indexed-label");
    if (label) {
      const materialLabel = newLabels["material"].name || "Material";
      label.innerHTML = `<strong>${materialLabel}_${index + 1}</strong>`;
    }
    const label2 = materialDiv.querySelector(".weight-indexed-label");
    if (label2) {
      const weightLabel = newLabels["weight"].name || "Weight";
      label2.innerHTML = `<strong>${weightLabel}_${index + 1}</strong>`;
    }
    const label3 = materialDiv.querySelector(".charges-indexed-label");
    if (label3) {
      const chargesLabel = newLabels["charges"].name || "Charges";
      label3.innerHTML = `<strong>${chargesLabel}_${index + 1}</strong>`;
    }

    // Update IDs of inputs inside this materialDiv
    materialDiv.querySelectorAll("input").forEach((input) => {
      if (input.id) {
        // Remove any existing trailing index part and append new index
        // const baseId = input.id.replace(/-\d+$/, "");
        const baseId = input.id.replace(/_[^_]*$/, "");
        const basename = input.name.replace(/_[^_]*$/, "");
        input.id = `${baseId}_${index + 1}`;
        input.name = `${basename}_${index + 1}`;
      }
    });
  });

  // Optionally setup autocomplete for the newly cloned input with updated id
  const clonedInput = clone.querySelectorAll("input")[0];
  setupAutocomplete(clonedInput, materials, fuzzySearch);
}

function updateLabelInputs(labelData) {
  // console.log({ labelData });
  for (const [field, data] of Object.entries(labelData)) {
    let inputElem = document.querySelector(`input[name="${field}"]`);
    if (inputElem) {
      const closestGroup = inputElem.closest(".input-group");
      const firstStrong = closestGroup.querySelector("strong");
      if (firstStrong) firstStrong.innerText = data.name; // Show/hide input group based on enabled
      closestGroup.style.display = data.enabled ? "" : "none";
    } else {
      // Fallback for indexed fields
      let inputElem2 = document.querySelector(`input[name^="${field}_"]`);
      if (inputElem2) {
        const closestGroup = inputElem2.closest(".input-group");
        const firstStrong = closestGroup.querySelector("strong");
        if (firstStrong) firstStrong.innerText = data.name + "_1";
        closestGroup.style.display = data.enabled ? "" : "none";
      }
    }
  }
}

function updateModlaLabelInputs(labelData) {
  console.log({ labelData });
  for (const [field, data] of Object.entries(labelData)) {
    let modalFrom = document.querySelector("#add_material_form_modal");
    let inputElem = modalFrom.querySelector(`input[name="${field}"]`);
    if (inputElem) {
      const closestGroup = inputElem.closest(".input-group");
      const firstStrong = closestGroup.querySelector("strong");
      if (firstStrong) firstStrong.innerText = data.name; // Show/hide input group based on enabled
      closestGroup.style.display = data.enabled ? "" : "none";
    } else {
      // Fallback for indexed fields
      let inputElem2 = modalFrom.querySelector(`input[name^="${field}_"]`);
      if (inputElem2) {
        const closestGroup = inputElem2.closest(".input-group");
        const firstStrong = closestGroup.querySelector("strong");
        if (firstStrong) firstStrong.innerText = data.name + "_1";
        closestGroup.style.display = data.enabled ? "" : "none";
      }
    }
  }
}

if (typeof updateLables === "undefined") {
  const updateLables = async () => {
    const d = await getLabelConfiguration();
    // console.log({ d });
    updateLabelInputs(d.newLables);

    newLabels = d.newLables || {};
  };
  window.updateLables = updateLables; // export globally
}
updateLables();

function clearForm(e) {
  const form = e.target.closest("form");
  const materialDetail_container = form.querySelector(
    ".material_detials_container"
  );
  const allMaterials =
    materialDetail_container.querySelectorAll(".material_detail");

  // If there's more than one, remove extras
  if (allMaterials.length > 1) {
    for (let i = allMaterials.length - 1; i > 0; i--) {
      allMaterials[i].remove();
    }
  }

  // Clear inputs in the first material_detail
  const firstMaterial = allMaterials[0];
  firstMaterial.querySelectorAll("input").forEach((input) => {
    input.value = "";
  });

  // Update label and input IDs/names to index 1
  const label = firstMaterial.querySelector(".material-index-label");
  if (label) {
    label.innerHTML = `<strong>Material 1</strong>`;
  }
  firstMaterial.querySelectorAll("input").forEach((input) => {
    if (input.id) {
      const baseId = input.id.replace(/_[^_]*$/, "");
      const baseName = input.name.replace(/_[^_]*$/, "");
      input.id = `${baseId}_1`;
      input.name = `${baseName}_1`;
    }
  });
}

async function handleWeighmentFormSubmit(e, pressedButton, ticket_no) {
  e.preventDefault();
  console.log("Button pressed :", pressedButton);
  console.log("ticket_no :", ticket_no);
  const resetBtn = e.target.querySelector('button[type="reset"]');
  const formData = new FormData(e.target);

  const data = {};
  for (const [name, value] of formData.entries()) {
    data[name] = value;
  }
  console.log(data);
  if (pressedButton === "keep_pending") {
    data["status"] = 1;
  } else if (pressedButton === "save_transaction") {
    data["status"] = 2;
  }
  data["ticket_no"] = ticket_no == "New" ? Math.random() * 1000000 : ticket_no;
  data["company_id"] = company_id;

  // Compute net weights dynamically
  const weights = [];
  for (let i = 1; i <= 4; i++) {
    const w = parseFloat(data[`weight_${i}`]);
    if (!isNaN(w)) weights.push(w);
  }

  // Add calculated net weights
  for (let i = 0; i < weights.length; i++) {
    if (i === 0) {
      data[`netweight_${i + 1}`] = weights[i]; // first stays same
    } else {
      data[`netweight_${i + 1}`] = weights[i] - weights[i - 1]; // subsequent differences
    }
  }

  const res = await insertRecordAPI(data);
  console.log({
    res,
  });
  handleResponse(res);

  resetBtn.click();
}
