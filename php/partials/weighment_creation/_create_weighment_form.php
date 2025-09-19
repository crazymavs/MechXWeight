<?php

?>
<form action="" id="weightment_form">
	<div class=" row">
		<div class="col-md-6">
			<div class="input-group mb-3">
				<span class="input-group-text"><strong>Weighment Type</strong></span>
				<select name="weighment_type" class="form-select">
					<option selected="0">Choose...</option>
					<option value="1">First</option>
					<option value="2">Second</option>
					<option value="3">Single</option>
					<option value="4">Multipart</option>
					<option value="5">Preloaded</option>
				</select>
			</div>
			<div class="input-group mb-3">
				<span class="input-group-text"><strong>Material</strong></span>
				<input type="text" class="form-control" name="material" value="Steel">
			</div>
			<div class="input-group mb-3">
				<span class="input-group-text"><strong>Party Name</strong></span>
				<input type="text" class="form-control" name="party_name" value="Mechotronix">
			</div>
			<div class="input-group mb-3">
				<span class="input-group-text"><strong>Charges</strong></span>
				<input type="text" class="form-control" name="charges" value="100">
				<span class="input-group-text"><strong>₹</strong></span>
			</div>
			<div class="input-group mb-3">
				<span class="input-group-text"><strong>Vehicle_no No.</strong></span>
				<input type="text" class="form-control" name="vehicle_no" value="0978687">
			</div>
		</div>
		<div class="col-md-6">
			<div class="input-group mb-3">
				<span class="input-group-text"><strong>Ticket No.</strong></span>
				<input type="text" class="form-control" name="ticket_no" value="0978687">
			</div>
			<div class="input-group mb-3">
				<span class="input-group-text"><strong>Weight 1</strong></span>
				<input type="text" class="form-control" name="weight_1" value="">
				<span class="input-group-text"><strong>kg</strong></span>
			</div>
			<div class="input-group mb-3">
				<span class="input-group-text"><strong>Weight 2</strong></span>
				<input type="text" class="form-control" name="weight_2" value="">
				<span class="input-group-text"><strong>kg</strong></span>
			</div>
			<div class="input-group mb-3">
				<span class="input-group-text"><strong>Net Weight</strong></span>
				<input type="text" class="form-control" name="net_weight" value="100">
				<span class="input-group-text"><strong>kg</strong></span>
			</div>
		</div>


		<div class="col-md-12 mt-3 text-end">
			<button type="reset" class="btn btn-secondary">Clear</button>
			<button type="submit" class="btn btn-primary">Save</button>
		</div>
	</div>
</form>


<script src="<?= $asset_base ?>/js/baseUrl.js"></script>

<script>
	const weighment_type = document.querySelector('#weighment_type')
	const weightment_form = document.querySelector('#weightment_form')

	weightment_form.addEventListener('submit', (e) => {
		e.preventDefault()

		console.log('this is form submit')
		console.log(apiBase)
		const formData = new FormData(event.target);
		formData.append('actionMethod', 'addfirstweight')
		console.log(formData)
		for (const [name, value] of formData.entries()) {
			console.log(`${name}: ${value}`);
		}
		const data = {};
		for (const [name, value] of formData.entries()) {
			data[name] = value;
		}
		console.log(data)
		fetch(apiBase, {
				method: 'POST',
				headers: {
					"Content-Type": "application/json"
				},
				body: JSON.stringify(data) // Just pass FormData—do NOT set headers
			})
			.then(response => response.json())
			.then(result => {
				console.log('Success:', result);
				// Add any further handling here
				if (result.status) {
					alert("success")
				} else {
					alert('error')
				}
			})
			.catch(error => {
				console.error('Error:', error);
			});
	})
</script>