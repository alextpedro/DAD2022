<template>
	<div>
		<br/>
		<table class="table table-striped">
			<thead class="thead-dark" align="center">
				<tr>
					<th>Photo</th>
					<th>Name</th>
					<th>Type</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				<tr v-for="user in users" :key="user.id">
					<td class="align-middle">
						<img :src="serverBaseUrl + apiPort + '/storage/fotos/' + user.photo_url" width="64" height="64" />
					</td>
					<td class="align-middle">
						<span>{{ user.name }}</span>
					</td>
					<td class="align-middle">
						<span>
							{{ user.email }}
						</span>
					</td>
					<td class="align-middle">
						<span>
							{{ user.type }}
						</span>
					</td>
					<td class="align-middle">
						<button class="btn btn-sm btn-danger" v-on:click.prevent="deleteUser(user.id)">
							Delete
						</button>
						<button class="btn btn-info">
							Edit
						</button>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</template>

<script>
import { useSSRContext } from 'vue';
import { useRouter } from 'vue-router';
import { inject, onMounted, ref } from 'vue';
import * as Vue from 'vue'; 
import axios from 'axios';
import VueAxios from 'vue-axios';

Vue.use(VueAxios, axios);

const router = useRouter();
const serverBaseUrl = inject('serverBaseUrl');
const apiPort = inject('apiPort');

export default {
	data() {
		return {
			page: 'users',
			users: [],
		};
	},
	methods: {
		getUsers: function () {
			axios.get('api/users').then((response) => {
				console.log(response);
				this.users = response.data.data;
			});
		},
		// editUser: function (user) {
		// 	axios.put('api/users/{user}', user)
		// 		.then((response) => {
		// 			this.users = response.data.data;
		// 		})
		// 		.catch((err) => {
		// 			console.log(err.response.data);
		// 		});
		// },
		deleteUser: function (id) {
			axios.delete(`api/users/${id}`).then((response) => {
				this.getUsers();
			});
		},
	},
	mounted() {
		this.getUsers();
	},
	
};
</script>

<style scoped>
img {
	height: 70px;
	width: 70px;
}

header {
	height: 50px;
	background-color: #eee;
	box-shadow: 2px 2px 5px #999;
	text-align: right;
	font-size: 30px;
	padding-right: 10px;
}
</style>
