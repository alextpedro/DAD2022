<!-- eslint-disable indent -->
<script setup>
import { useRouter } from 'vue-router';
import { inject, onMounted, ref } from 'vue';
import { useUserStore } from '@/stores/user.js';

const router = useRouter();
const axios = inject('axios');
const serverBaseUrl = inject('serverBaseUrl');
const apiPort = inject('apiPort');

const UserStore = useUserStore();
const editUser = UserStore.user;

let uploadedFile = null;
const uploadedFileUrl = ref();
const inputName = ref();
const inputType = ref();
const inputEmail = ref();
const inputPassword = ref();
const inputNif = ref();

let boolFileUploaded = ref(false);

const selectedUsers = ref([]);

const users = ref([]);

const loadUsers = () => {
	if (editUser) {
		uploadedFileUrl.value = editUser.photo_url;
		inputName.value = editUser.name;
		inputType.value = editUser.type;
		inputPassword.value = editUser.password;
		inputEmail.value = editUser.email;
		//inputNif.value = editUser.nif;
	}
};

const handleFileUpload = (event) => {
	boolFileUploaded.value = true;
	uploadedFile = event.target.files[0];
	uploadedFileUrl.value = URL.createObjectURL(event.target.files[0]);
};

const saveUser = (id) => {
	axios.put('api/users/{user}', id)
		.then((response) => {
			users.value = response.data.data;
		})
		.catch((err) => {
			console.log(err.response.data);
		});
};

const deleteUser = () => {
	console.log();
	axios.delete('/users/delete/' + editUser.id).then(() => {
		console.log('SUCCESS!!');
		router.push({ name: 'listusers' });
	}).catch(() => {
		console.log('FAILURE!!');
	});
};

onMounted(() => {
	loadUsers();
});
</script>


<template>
	<form class="row g-3 needs-validation" novalidate @submit.prevent="save" enctype="multipart/form-data">
		<div class="form-group">
			<img v-if="boolFileUploaded" :src="uploadedFileUrl" width="150" height="150" />
			<img v-else-if="editUser" :src="serverBaseUrl + apiPort + '/storage/fotos/' + uploadedFileUrl"
				width="150" height="150" />
			<img v-else src="https://via.placeholder.com/150" />
			<input type="file" id="inputImg" accept="image/*" @change="handleFileUpload($event)" />
		</div>

		<div class="mb-3">
			<label for="inputName" class="form-label">Full Name</label>
			<input type="text" class="form-control" id="inputName" placeholder="Name" v-model="inputName" required>
			<field-error-message fieldName="name"></field-error-message>
		</div>

		<div class="mb-3">
			<label for="inputType" class="form-label">Type</label>
			<select type="dropdown" class="form-control" id="inputType" v-model="inputType" required>
				<option value="C">Customer</option>
				<option value="EC">Employee Chef</option>
				<option value="ED">Employee Delivery</option>
				<option value="EM">Employee Manager</option>
			</select>
			<field-error-message fieldName="type"></field-error-message>
		</div>

		<div class="mb-3">
			<label for="inputEmail" class="form-label">Email</label>
			<input type="text" class="form-control" id="inputName" placeholder="Email" v-model="inputEmail" required>
			<field-error-message fieldName="email"></field-error-message>
		</div>

		<div class="mb-3">
			<label for="inputPassword" class="form-label">Password</label>
			<input type="text" class="form-control" id="inputPassword" placeholder="*********" v-model="inputPassword"
				required>
			<field-error-message fieldName="password"></field-error-message>
		</div>

		<div class="mb-3">
			<label for="inputPassword" class="form-label">NIF</label>
			<input type="text" class="form-control" id="inputPassword" placeholder="123456789" v-model="inputPassword"
				required>
			<field-error-message fieldName="password"></field-error-message>
		</div>

		<div class="btn-group float-end" role="group">
			<button v-if="editProduct" type="button" class="btn btn-info" @click="deleteItem">[MANAGER] Delete</button>
			<button type="button" class="btn btn-danger">
				<router-link class="nav-link" :to="{ name: 'listusers' }">
					Cancel
				</router-link>
			</button>
			<button type="button" class="btn btn-success" @click="saveUser">Save</button>
		</div>
	</form>
</template>
