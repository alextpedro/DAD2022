<script setup>

const saveItem = () => {
	console.log('TODO - Functionality not implemented.');
};
</script>

<template>
	<form class="row g-3 needs-validation" novalidate @submit.prevent="save">
		<div class="form-group">
			<img src="https://via.placeholder.com/150" />
			<input type="file" accept="image/png, image/jpeg" />
		</div>

		<div class="mb-3">
			<label for="inputName" class="form-label">Name</label>
			<input type="text" class="form-control" id="inputName" placeholder="Item Name" required>
			<field-error-message fieldName="name"></field-error-message>
		</div>

		<div class="mb-3">
			<label for="inputType" class="form-label">Type</label>
			<select type="dropdown" class="form-control" id="inputType" required>
				<option value="hotDish">Hot Dish</option>
				<option value="coldDish">Cold Dish</option>
				<option value="drink">Drink</option>
				<option value="dessert">Dessert</option>
			</select>
			<field-error-message fieldName="type"></field-error-message>

			<label for="inputPrice" class="form-label">Price</label>
			<input type="number" id="inputPrice" class="form-control" required min="0" />
			<field-error-message fieldName="price"></field-error-message>
		</div>

		<div class="mb-3">
			<label for="inputDescription" class="form-label">Description</label>
			<textarea class="form-control" id="inputDescription" placeholder="Item Description" required></textarea>
			<field-error-message fieldName="name"></field-error-message>
		</div>

		<div class="btn-group float-end" role="group">
			<button type="button" class="btn btn-danger">
				<router-link class="nav-link" :to="{ name: 'Home' }">
					Cancel
				</router-link>
			</button>
			<button type="button" class="btn btn-success" @click="saveItem">Save</button>
		</div>
	</form>
</template>
