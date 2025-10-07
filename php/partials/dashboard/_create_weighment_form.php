<?php

?>
<form action="" id="weightment_form">
	<div class=" row">
		<div class="col-md-12">
			<!-- <div class="input-group mb-3">
				<span class="input-group-text"><strong>Weighment Type</strong></span>
				<select name="weighment_type" class="form-select">
					<option selected="0">Choose...</option>
					<option value="1">First</option>
					<option value="2">Second</option>
					<option value="3">Single</option>
					<option value="4">Multipart</option>
					<option value="5">Preloaded</option>
				</select>
			</div> -->


			<div class="d-flex gap-3 ">
				<div class="row my-3 col-md-6">
					<h5 class="card-title m-0 p-0 ps-2 pb-2"><strong>Create Weignment</strong> <strong> Ticket No: </strong>
						<span id="ticket_number">New</span>
					</h5>
					<h5 class="fs-6"><strong>Date&Time: </strong><?= $toDate ?> <?= date('H:i') ?> </h5>
					<div class="input-group mb-3 mt-3 ">
						<span class="input-group-text"><strong>Party Name</strong></span>
						<input type="text" class="form-control" id="weighment_form_party_name" name="party_name" value="">
						<div class="suggestionList" id="party_suggestions"></div>
					</div>
					<div class="input-group mb-3">
						<span class="input-group-text"><strong>Vehicle No.</strong></span>
						<input type="text" class="form-control" id="weighment_form_vehicle_no" name="vehicle_number" value="">
						<div class="suggestionList" id="vehicle_number_suggestions"></div>
					</div>
					<div class="input-group mb-3 d-none">
						<span class="input-group-text"><strong>Ticket No.</strong></span>
						<input type="text" class="form-control" id="weighment_form_ticket_no" name="ticket_no" value="">

					</div>
				</div>

				<div class="row my-3 col-md-6">
					<div class="input-group">
						<input type="text" class="form-control text-light bg-dark text-center" name="" id="indicatorWeight" readonly value="14,980">
						<span class="input-group-text text-light bg-dark"><strong>kg</strong></span>
					</div>
				</div>
			</div>
			<div class="additional_fields_container d-flex gap-3 mb-3">
				<div class="input-group">
					<span class="input-group-text material-index-label"><strong>Field 1</strong></span>
					<input type="text" class="form-control" id="weighment_form_material_1" name="field1" value="Empty">
					<!-- <div class="suggestionList" calss="materials_suggestions"></div> -->
				</div>
				<div class="input-group">
					<span class="input-group-text material-index-label"><strong>Field 2</strong></span>
					<input type="text" class="form-control" id="weighment_form_material_1" name="field2" value="Empty">
					<!-- <div class="suggestionList" calss="materials_suggestions"></div> -->
				</div>
			</div>
			<div class="material_detials_container">
				<div class="d-flex gap-3 material_detail mb-3">
					<div class="input-group">
						<span class="input-group-text material-indexed-label"><strong>Material 1</strong></span>
						<input type="text" class="form-control" id="weighment_form_material_1" name="material_1" value="Empty">
						<div class="suggestionList" calss="materials_suggestions"></div>
					</div>
					<div class="input-group ">
						<span class="input-group-text weight-indexed-label"><strong>Weight</strong></span>
						<input type="text" class="form-control" id="weighment_form_weight_1" name="weight_1" value="">
						<span class="input-group-text"><strong>kg</strong></span>
					</div>
					<div class="input-group h-fit">
						<span class="input-group-text charges-indexed-label"><strong>Charges</strong></span>
						<input type="text" class="form-control" id="weighment_form_charges_1" name="charges_1" value="">
						<span class="input-group-text"><strong>₹</strong></span>
					</div>
					<button type="button" class="btn btn-danger btn-sm ms-2 delete-material-btn">Delete</button>
				</div>
			</div>

		</div>
		<div class="d-flex justify-content-between">

			<div>
				<button type="button" class="btn btn-secondary" id="add_material_button">Add Item</button>

			</div>
			<div class="col-md-6 net_weight_wrapper d-none">
				<div class="input-group mb-3 net_weight_input">
					<span class="input-group-text"><strong>Material 1 Net Weight</strong></span>
					<input type="text" class="form-control" id="weighment_form_new_weight" disabled name="net_weight" value="0">
					<span class="input-group-text"><strong>kg</strong></span>
				</div>
			</div>
		</div>
		<div class="col-md-12 mt-3 text-end">
			<button type="reset" class="btn btn-secondary reset_button">Clear</button>
			<button type="submit" class="btn btn-primary reset_button" name="keep_pending">Keep Pending</button>
			<button type="submit" class="btn btn-success" name="save_transaction">Save Transaction</button>
		</div>
	</div>
	<style>
		.suggestionList {
			position: absolute;
			left: 0;
			right: 0;
			top: 100%;
			z-index: 99;
			/* border: 1px solid #ddd; */
			background: #fff;
			border-top: none;
			border-radius: 0 0 4px 4px;
			box-shadow: 0 4px 8px rgba(0, 0, 0, 0.06);
			max-height: 180px;
			overflow-y: auto;
		}

		.suggestionList div {
			padding: 10px;
			cursor: pointer;
			border-bottom: 1px solid #eee;
			transition: background 0.3s;
		}

		.suggestionList div:last-child {
			border-bottom: none;
		}

		.suggestionList div:hover,
		.suggestionList .active {
			background: #f4f4f4;
			color: #222;
		}
	</style>
</form>

<script src="<?php echo $asset_base ?>assets/js/fussySearch.js"></script>
<script src="<?php echo $asset_base ?>assets/js/setupAutoComplete.js"></script>
<script src="<?php echo $asset_base ?>assets/js/utils.js"></script>


<script>
	const weighment_type = document.querySelector('#weighment_type')
	const weightment_form = document.querySelector('#weightment_form')
	const addMaterialButton = document.querySelector('#add_material_button')
	const materialDetail_container = document.querySelector(".material_detail").parentNode;

	const reset_button = document.querySelector('.reset_button');

	function updateLabelInputs(labelData) {
		for (const [field, value] of Object.entries(labelData)) {
			let inputElem = document.querySelector(`input[name="${field}"]`);
			if (inputElem) {
				const closest = inputElem.parentNode;
				const firstStrong = closest.querySelector('strong');
				if (firstStrong) firstStrong.innerText = value;
			} else {
				inputElem2 = document.querySelector(`input[name^="${field}_"]`);
				const closest = inputElem2.parentNode;
				const firstStrong = closest.querySelector('strong');
				if (firstStrong) firstStrong.innerText = value + "_1"
			}
		}
	}

	const fetchAll = async () => {
		const d = await getLabelConfiguration()
		updateLabelInputs(d.newLables)
	}
	fetchAll()

	reset_button.addEventListener('click', () => {
		const allMaterials = materialDetail_container.querySelectorAll('.material_detail');

		// If there's more than one, remove extras
		if (allMaterials.length > 1) {
			for (let i = allMaterials.length - 1; i > 0; i--) {
				allMaterials[i].remove();
			}
		}

		// Clear inputs in the first material_detail
		const firstMaterial = allMaterials[0];
		firstMaterial.querySelectorAll('input').forEach(input => {
			input.value = '';
		});

		// Update label and input IDs/names to index 1
		const label = firstMaterial.querySelector('.material-index-label');
		if (label) {
			label.innerHTML = `<strong>Material 1</strong>`;
		}
		firstMaterial.querySelectorAll('input').forEach(input => {
			if (input.id) {
				const baseId = input.id.replace(/_[^_]*$/, "");
				const baseName = input.name.replace(/_[^_]*$/, "");
				input.id = `${baseId}_1`;
				input.name = `${baseName}_1`;
			}
		});
	});

	addMaterialButton.addEventListener("click", () => {
		const original = document.querySelector(".material_detail");
		const clone = original.cloneNode(true); // Deep clone including children
		// Clear input values in cloned node
		clone.querySelectorAll("input").forEach(input => {
			input.value = "";
		});
		materialDetail_container.appendChild(clone);
		// Update all material index labels and IDs
		const allMaterials = materialDetail_container.querySelectorAll(".material_detail");

		allMaterials.forEach((materialDiv, index) => {
			console.log({
				materialDiv,
				index,
				newLabels
			});

			// // Update label text
			const label = materialDiv.querySelector(".material-indexed-label");
			if (label) {
				const materialLabel = newLabels['material'] || 'Material';
				console.log({
					materialLabel,
					label
				});
				label.innerHTML = `<strong>${materialLabel}_${index + 1}</strong>`;
			}
			const label2 = materialDiv.querySelector(".weight-indexed-label");
			if (label2) {
				const weightLabel = newLabels['weight'] || 'Weight';
				console.log({
					weightLabel,
					label2
				});
				label2.innerHTML = `<strong>${weightLabel}_${index + 1}</strong>`;
			}
			const label3 = materialDiv.querySelector(".charges-indexed-label");
			if (label3) {
				const chargesLabel = newLabels['charges'] || 'Charges';
				console.log({
					chargesLabel,
					label3
				});
				label3.innerHTML = `<strong>${chargesLabel}_${index + 1}</strong>`;
			}

			// Update IDs of inputs inside this materialDiv
			materialDiv.querySelectorAll("input").forEach(input => {
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
	});

	// Delegate delete button clicks using Event Delegation for dynamically cloned nodes
	materialDetail_container.addEventListener("click", (e) => {
		if (e.target.classList.contains("delete-material-btn")) {
			const allMaterials = materialDetail_container.querySelectorAll(".material_detail");
			if (allMaterials.length > 1) {
				const materialDiv = e.target.closest(".material_detail");
				if (materialDiv) {
					materialDiv.remove();
				}
			} else {
				const toastLiveExample = document.getElementById('errorToast');
				$('.error-toast-body').text('At least one material detail must be present.')
				const toastBootstrap = new bootstrap.Toast(toastLiveExample, {
					delay: 3000,
					autohide: true
				});
				toastBootstrap.show();
			}
		}
	});

	let pressedButton = null;

	weightment_form.querySelectorAll('button[type="submit"]').forEach(button => {
		button.addEventListener('click', (e) => {
			pressedButton = e.target.value || e.target.name;
		});
	});

	weightment_form.addEventListener('submit', async (e) => {
		e.preventDefault()
		console.log('Button pressed:', pressedButton);

		const formData = new FormData(event.target);

		const data = {};
		for (const [name, value] of formData.entries()) {
			data[name] = value;
		}
		console.log({
			formData,
			data
		})
		if (pressedButton === 'keep_pending') {
			data['status'] = 1
		} else if (pressedButton === 'save_transaction') {
			data['status'] = 2
		}
		data['ticket_no'] = Math.random() * 1000000
		const res = await insertRecordAPI(data);
		console.log({
			res
		})
		if (res.status) {
			// alert("success")
			const toastLiveExample = document.getElementById('successToast');
			$('.success-toast-body').text(res.message)
			const toastBootstrap = new bootstrap.Toast(toastLiveExample, {
				delay: 3000,
				autohide: true
			});
			toastBootstrap.show();
		} else {
			// alert('error')
			const toastLiveExample = document.getElementById('errorToast');
			$('.error-toast-body').text(res.message)
			const toastBootstrap = new bootstrap.Toast(toastLiveExample, {
				delay: 3000,
				autohide: true
			});
			toastBootstrap.show();
		}

		reset_button.click()
		console.log(fetchAllTransactions);
		fetchAllTransactions()
	})
	let allParties = [];
	const input = document.getElementById("weighment_form_party_name");
	const {
		updateSuggstionList
	} = setupAutocomplete(input, allParties, fuzzySearch);

	async function getAllparties() {
		const res = await getAllParties();
		const partyNameArr = res.data.map(item => item.party_name)
		allParties = partyNameArr
		updateSuggstionList(partyNameArr)
	}

	let vehicleNumbers = [];
	const vehicleInput = document.getElementById("weighment_form_vehicle_no");
	const {
		updateSuggstionList: updateVehicleSuggestionList
	} = setupAutocomplete(vehicleInput, vehicleNumbers, fuzzySearch);

	async function getAllVehicleNumbers() {
		const res = await getAllVehiclesAPI(); // Adjust API to get vehicle data
		const vehicleNumberArr = res.data.map(item => item.vehicle_number);
		vehicleNumbers = vehicleNumberArr;
		updateVehicleSuggestionList(vehicleNumberArr);
	}

	// let ticketNumbers = [];
	// const ticketInput = document.getElementById("weighment_form_ticket_no");
	// const {
	// 	updateSuggstionList: updateTicketSuggestionList
	// } = setupAutocomplete(ticketInput, ticketNumbers, fuzzySearch);

	// async function getAllTicketNumbers() {
	// 	const res = await getAllTickets(); // Adjust API to get ticket data
	// 	const ticketNumberArr = res.data.map(item => item.ticket_number);
	// 	ticketNumbers = ticketNumberArr;
	// 	updateTicketSuggestionList(ticketNumberArr);
	// }

	let materials = [];
	const materialInput = document.getElementById("weighment_form_material_1");
	const {
		updateSuggstionList: updateMaterialSuggestionList
	} = setupAutocomplete(materialInput, materials, fuzzySearch);

	async function getAllMaterials() {
		const res = await getAllMaterialsAPI(); // Replace with your API call to fetch materials
		const materialNameArr = res.data.map(item => item.material_name);
		materials = materialNameArr;
		updateMaterialSuggestionList(materialNameArr);
	}
	getLabelConfiguration()
	getAllVehicleNumbers()
	getAllparties()
	getAllMaterials()
</script>