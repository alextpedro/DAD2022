<script setup>
import { inject, ref } from 'vue';

const axios = inject('axios');

const uploaded_file = ref();
const inputName = ref();
const inputType = ref();
const inputPrice = ref();
const inputDescription = ref();


const handleFileUpload = (event) => {
	uploaded_file.value = URL.createObjectURL(event.target.files[0]);
};

const saveItem = () => {
	console.log('TODO - Functionality not implemented.');

	//Gather all data
	const formData = new FormData();
	formData.append('file', uploaded_file);
	formData.append('name', inputName.value);
	formData.append('type', inputType.value);
	formData.append('price', inputPrice.value);
	formData.append('description', inputDescription.value);
	console.log(formData);

	//Send to API with axios
	axios.post('/products', formData,
		{
			headers: {
				'Content-Type': 'multipart/form-data'
			}
		}).then(function(){
		console.log('SUCCESS!!');
	})
		.catch(function(){
			console.log('FAILURE!!');
		});
};
</script>

<template>
	<form class="row g-3 needs-validation" novalidate @submit.prevent="save" enctype="multipart/form-data">
		<div class="form-group">
			<img v-if="uploaded_file" :src="uploaded_file" width="150" height="150"/>
			<img v-else src="https://via.placeholder.com/150" />
			<input type="file" id="inputImg" accept="image/png, image/jpeg" @change="handleFileUpload($event)" />
		</div>

		<div class="mb-3">
			<label for="inputName" class="form-label">Name</label>
			<input type="text" class="form-control" id="inputName" placeholder="Item Name" v-model="inputName" required>
			<field-error-message fieldName="name"></field-error-message>
		</div>

		<div class="mb-3">
			<label for="inputType" class="form-label">Type</label>
			<select type="dropdown" class="form-control" id="inputType" v-model="inputType" required>
				<option value="hotDish">Hot Dish</option>
				<option value="coldDish">Cold Dish</option>
				<option value="drink">Drink</option>
				<option value="dessert">Dessert</option>
			</select>
			<field-error-message fieldName="type"></field-error-message>

			<label for="inputPrice" class="form-label">Price</label>
			<input type="number" id="inputPrice" class="form-control" v-model="inputPrice" required min="0" />
			<field-error-message fieldName="price"></field-error-message>
		</div>

		<div class="mb-3">
			<label for="inputDescription" class="form-label">Description</label>
			<textarea class="form-control" id="inputDescription" placeholder="Item Description" v-model="inputDescription" required></textarea>
			<field-error-message fieldName="description"></field-error-message>
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
