<script setup>
import { useRouter } from 'vue-router';
import { inject, watch, ref } from 'vue';
import { useUserStore } from '@/stores/user.js';

const router = useRouter();
const axios = inject('axios');
const serverBaseUrl = inject('serverBaseUrl');
const socket = inject('socket');
const toast = inject('toast');

const userStore = useUserStore();

const props = defineProps({
	id: {
		type: Number,
		default: null
	}
});

const newUser = () => {
	return {
		id: null,
		name: '',
		type: '',
		email: '',
		password: '',
		photo_url: null
	};
};

const user = ref(newUser());
const errors = ref(null);

let uploadedFile = null;
const uploadedFileUrl = ref();

let boolFileUploaded = ref(false);


const loadUser = (id) => {
	axios.get('users/' + id)
		.then((response) => {
			user.value = response.data.data;
		})
		.catch((error) => {
			console.log(error);
		});
};

const handleFileUpload = (event) => {
	boolFileUploaded.value = true;
	uploadedFile = event.target.files[0];
	uploadedFileUrl.value = URL.createObjectURL(event.target.files[0]);
};

const saveUser = (id) => {
	axios.put('users/' + props.id, user.value)
		.then(() => {
			socket.emit('updateUser', user.value);
			if (user.value.id == userStore.user.id) {
				userStore.user = user.value; 
			}
			toast.success('User #' + user.value.id + ' was updated successfully.');
			router.back();
		})
		.catch((error) => {
			if (error.response.status == 422) {
				toast.error('User #' + props.id + ' was not updated due to validation errors!');
				errors.value = error.response.data.errors;
			} else {
				toast.error('User #' + props.id + ' was not updated due to unknown server error!');
			}
		});
};

watch(
	() => props.id,
	(newValue) => {
		loadUser(newValue);
	},
	{immediate: true}  
);
</script>


<template>
	<form class="row g-3 needs-validation" novalidate @submit.prevent="save" enctype="multipart/form-data">
		<div class="form-group">
			<img v-if="boolFileUploaded" :src="uploadedFileUrl" width="150" height="150" />
			<img v-else-if="user" :src="serverBaseUrl + '/storage/fotos/' + user.photo_url"
				width="150" height="150" />
			<img v-else src="https://via.placeholder.com/150" />
			<input type="file" id="inputImg" accept="image/*" @change="handleFileUpload($event)" />
		</div>

		<div class="mb-3">
			<label for="inputName" class="form-label">Full Name</label>
			<input type="text" class="form-control" id="inputName" placeholder="Name" v-model="user.name" required>
			<field-error-message fieldName="name"></field-error-message>
		</div>

		<div class="mb-3" v-if="userStore.user?.type === 'EM'">
			<label for="inputType" class="form-label">Type</label>
			<select type="dropdown" class="form-control" id="inputType" v-model="user.type" required>
				<option value="C">Customer</option>
				<option value="EC">Employee Chef</option>
				<option value="ED">Employee Delivery</option>
				<option value="EM">Employee Manager</option>
			</select>
			<field-error-message fieldName="type"></field-error-message>
		</div>

		<div class="mb-3">
			<label for="inputEmail" class="form-label">Email</label>
			<input type="text" class="form-control" id="inputName" placeholder="Email" v-model="user.email" required>
			<field-error-message fieldName="email"></field-error-message>
		</div>

		<div class="mb-3">
			<label for="inputPassword" class="form-label">Password</label>
			<input type="text" class="form-control" id="inputPassword" placeholder="*********" v-model="user.password"
				required>
			<field-error-message fieldName="password"></field-error-message>
		</div>

		<div class="mb-3">
			<label for="inputNif" class="form-label">NIF</label>
			<input type="text" class="form-control" id="inputPassword" placeholder="123456789" v-model="user.nif"
				required>
			<field-error-message fieldName="nif"></field-error-message>
		</div>

		<div class="btn-group float-end" role="group">
			<button type="button" class="btn btn-danger">
				<router-link class="nav-link" :to="{ name: 'ListUsers' }">
					Cancel
				</router-link>
			</button>
			<button type="button" class="btn btn-success" @click="saveUser">Save</button>
		</div>
	</form>
</template>
