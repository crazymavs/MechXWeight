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
			<div class="d-flex gap-3">
				<div class="input-group mb-3 ">
					<span class="input-group-text"><strong>Party Name</strong></span>
					<input type="text" class="form-control" id="weighment_form_party_name" name="party_name" value="">
					<div class="suggestionList" id="party_suggestions"></div>
				</div>
				<div class="input-group mb-3">
					<span class="input-group-text"><strong>Vehicle_no No.</strong></span>
					<input type="text" class="form-control" id="weighment_form_vehicle_no" name="vehicle_no" value="">
					<div class="suggestionList" id="vehicle_number_suggestions"></div>
				</div>
				<div class="input-group mb-3">
					<span class="input-group-text"><strong>Ticket No.</strong></span>
					<input type="text" class="form-control" id="weighment_form_ticket_no" name="ticket_no" value="">

				</div>
			</div>
			<div class="material_detials_container">
				<div class="d-flex gap-3 material_detail mb-3">
					<div class="input-group">
						<span class="input-group-text material-index-label"><strong>Material 1</strong></span>
						<input type="text" class="form-control" id="weighment_form_material_1" name="material_1" value="Empty">
						<div class="suggestionList" calss="materials_suggestions"></div>
					</div>
					<div class="input-group ">
						<span class="input-group-text"><strong>Weight</strong></span>
						<input type="text" class="form-control" id="weighment_form_weight_1" name="weight_1" value="">
						<span class="input-group-text"><strong>kg</strong></span>
					</div>
					<div class="input-group h-fit">
						<span class="input-group-text"><strong>Charges</strong></span>
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
			<div class="col-md-6 net_weight_wrapper">
				<div class="input-group mb-3 net_weight_input">
					<span class="input-group-text"><strong>Material 1 Net Weight</strong></span>
					<input type="text" class="form-control" id="weighment_form_new_weight" disabled name="net_weight" value="0">
					<span class="input-group-text"><strong>kg</strong></span>
				</div>
			</div>
		</div>
		<div class="col-md-12 mt-3 text-end">
			<button type="reset" class="btn btn-secondary reset_button">Clear</button>
			<button type="submit" class="btn btn-primary">Save</button>
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


<script>
	const weighment_type = document.querySelector('#weighment_type')
	const weightment_form = document.querySelector('#weightment_form')
	const addMaterialButton = document.querySelector('#add_material_button')
	const materialDetail_container = document.querySelector(".material_detail").parentNode;

	const reset_button = document.querySelector('.reset_button');

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
			// Update label text
			const label = materialDiv.querySelector(".material-index-label");
			if (label) {
				label.innerHTML = `<strong>Material ${index + 1}</strong>`;
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
	weightment_form.addEventListener('submit', (e) => {
		e.preventDefault()
		const formData = new FormData(event.target);
		formData.append('actionMethod', 'addfirstweight')

		const data = {};
		for (const [name, value] of formData.entries()) {
			data[name] = value;
		}
		console.log({
			formData,
			data
		})
		fetch(apiBase, {
				method: 'POST',
				headers: {
					"Content-Type": "application/json"
				},
				body: JSON.stringify(data) // Just pass FormData—do NOT set headers
			})
			.then(response => response.json())
			.then(result => {
				// console.log('Success:', result);
				// Add any further handling here
				if (result.status) {
					// alert("success")
					const toastLiveExample = document.getElementById('successToast');
					$('.success-toast-body').text(result.message)
					const toastBootstrap = new bootstrap.Toast(toastLiveExample, {
						delay: 3000,
						autohide: true
					});
					toastBootstrap.show();
				} else {
					// alert('error')
					const toastLiveExample = document.getElementById('errorToast');
					$('.error-toast-body').text(result.message)
					const toastBootstrap = new bootstrap.Toast(toastLiveExample, {
						delay: 3000,
						autohide: true
					});
					toastBootstrap.show();
				}
			})
			.catch(error => {
				console.error('Error:', error);
			});
		reset_button.click()
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
	getAllVehicleNumbers()
	getAllparties()
	getAllMaterials()
</script>