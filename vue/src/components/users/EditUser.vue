<script setup>
import { useRouter } from 'vue-router';
import { inject, watch, ref } from 'vue';
import { useUserStore } from '@/stores/user.js';

const router = useRouter();
const axios = inject('axios');
const serverBaseUrl = inject('serverBaseUrl');

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

const loadUser = (id) => {
	// if (editUser) {
	// 	uploadedFileUrl.value = editUser.photo_url;
	// 	inputName.value = editUser.name;
	// 	inputType.value = editUser.type;
	// 	inputPassword.value = editUser.password;
	// 	inputEmail.value = editUser.email;
	// 	//inputNif.value = editUser.nif;
	// }
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
	// axios.put('/users/{user}', id)
	// 	.then((response) => {
	// 		// user.value = response.data.data;
	// 	})
	// 	.catch((err) => {
	// 		console.log(err.response.data);
	// 	});
};

const deleteUser = () => {
	console.log();
	axios.delete('/users/delete/' + props.id).then(() => {
		console.log('SUCCESS!!');
		router.push({ name: 'listusers' });
	}).catch(() => {
		console.log('FAILURE!!');
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
