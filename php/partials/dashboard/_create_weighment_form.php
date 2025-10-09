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
					<input type="text" class="form-control" id="weighment_form_field_1" name="field1" value="Empty">
					<!-- <div class="suggestionList" calss="materials_suggestions"></div> -->
				</div>
				<div class="input-group">
					<span class="input-group-text material-index-label"><strong>Field 2</strong></span>
					<input type="text" class="form-control" id="weighment_form_field_2" name="field2" value="Empty">
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
	let newLabels = {};
	const reset_button = document.querySelector('.reset_button');

	reset_button.addEventListener('click', (e) => {
		clearForm(e);
	});

	addMaterialButton.addEventListener("click", (e) => {
		handleAddItemClick(e);
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
		handleWeighmentFormSubmit(e, pressedButton);
	})

	let allParties = [];
	const input = document.getElementById("weighment_form_party_name");
	const {
		updateSuggstionList
	} = setupAutocomplete(input, allParties, fuzzySearch);

	let vehicleNumbers = [];
	const vehicleInput = document.getElementById("weighment_form_vehicle_no");
	const {
		updateSuggstionList: updateVehicleSuggestionList
	} = setupAutocomplete(vehicleInput, vehicleNumbers, fuzzySearch);

	let materials = [];
	const materialInput = document.getElementById("weighment_form_material_1");
	const {
		updateSuggstionList: updateMaterialSuggestionList
	} = setupAutocomplete(materialInput, materials, fuzzySearch);
</script>