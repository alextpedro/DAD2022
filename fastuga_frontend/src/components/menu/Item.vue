<script setup>
import { inject, ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import { useProductStore } from '@/stores/product.js';

const axios = inject('axios');
const router = useRouter();
const serverBaseUrl = inject('serverBaseUrl');
const apiPort = inject('apiPort');

const productStore = useProductStore();
const editProduct = productStore.product;

let uploadedFile = null;
const uploadedFileUrl = ref();
const inputName = ref();
const inputType = ref();
const inputPrice = ref();
const inputDescription = ref();

let boolFileUploaded = ref(false);

const loadItem = () => {
	if (editProduct) {
		uploadedFileUrl.value = editProduct.photo_url;
		inputName.value = editProduct.name;
		inputType.value = editProduct.type;
		inputPrice.value = editProduct.price;
		inputDescription.value = editProduct.description;
	}
};

const handleFileUpload = (event) => {
	boolFileUploaded.value = true;
	uploadedFile = event.target.files[0];
	uploadedFileUrl.value = URL.createObjectURL(event.target.files[0]);
};

const saveItem = () => {
	const formData = new FormData();
	formData.append('file', uploadedFile);
	formData.append('name', inputName.value);
	formData.append('type', inputType.value);
	formData.append('price', inputPrice.value);
	formData.append('description', inputDescription.value);

	if(editProduct) {
		formData.append('photo_url', uploadedFileUrl.value);
		formData.append('_method', 'put');
		axios.post('/products/' + editProduct.id, formData, {
			headers: {
				'Content-Type': 'multipart/form-data',
			}})
			.then(() => {
				console.log('SUCCESS!!');
				router.push({name: 'Menu'});
			
			})
			.catch(() => {
				console.log('FAILURE!!');
			});
	} 
	else {
		axios.post('/products', formData, {
			headers: {
				'Content-Type': 'multipart/form-data',
			}})
			.then(() => {
				console.log('SUCCESS!!');
				router.push({name: 'Menu'});
			
			})
			.catch(() => {
				console.log('FAILURE!!');
			});
	}


};

onMounted(() => {
	loadItem();
});
</script>

<template>
	<form class="row g-3 needs-validation" novalidate @submit.prevent="save" enctype="multipart/form-data">
		<div class="form-group">
			<img v-if="boolFileUploaded" :src="uploadedFileUrl" width="150" height="150"/>
			<img v-else-if="editProduct" :src="serverBaseUrl + apiPort + '/storage/products/' + uploadedFileUrl" width="150" height="150"/>
			<img v-else src="https://via.placeholder.com/150" />
			<input type="file" id="inputImg" accept="image/*" @change="handleFileUpload($event)" />
		</div>

		<div class="mb-3">
			<label for="inputName" class="form-label">Name</label>
			<input type="text" class="form-control" id="inputName" placeholder="Item Name" v-model="inputName" required>
			<field-error-message fieldName="name"></field-error-message>
		</div>

		<div class="mb-3">
			<label for="inputType" class="form-label">Type</label>
			<select type="dropdown" class="form-control" id="inputType" v-model="inputType" required>
				<option value="hot dish">Hot Dish</option>
				<option value="cold dish">Cold Dish</option>
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
