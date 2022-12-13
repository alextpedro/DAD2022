<script setup>
import { useRouter } from 'vue-router';
import { inject, onMounted, ref } from 'vue';

const router = useRouter();
const axios = inject('axios');
const serverBaseUrl = inject('serverBaseUrl');
const apiPort = inject('apiPort');

const items = ref([]);

const selectedItems = ref([]);

const submitOrder = () => {
	console.log(selectedItems);

	console.log('TODO - Functionality not implemented.');
	router.push({
		name: 'Order',
		params: {

		}
	});
};

const loadItems = () => {
	axios.get('products')
		.then((response) => {
			items.value = response.data.data;
		})
		.catch((error) => {
			console.log(error);
		});
};

onMounted(() => {
	loadItems();
});
</script>

<template>
	<table class="table">
		<thead>
			<tr>
				<th>Photo</th>
				<th>Name</th>
				<th>Type</th>
				<th>Description</th>
				<th>Price</th>
				<th>Order?</th>
			</tr>
		</thead>
		<tbody>
			<tr v-for="item in items" :key="item.id">
				<td>
					<img :src="serverBaseUrl + apiPort + '/storage/products/' + item.photo_url" width="64" height="64" />
				</td>
				<td>
					<span>{{ item.name }}</span>
				</td>
				<td>
					<span>
						{{ item.type }}
					</span>
				</td>
				<td>
					<span>
						{{ item.description }}
					</span>
				</td>
				<td>
					<span>
						{{ item.price }}€
					</span>
				</td>
				<td>
					<input type="checkbox" :value="item" v-model="selectedItems" />
				</td>
			</tr>
		</tbody>
	</table>

	<div class="btn-group float-end" role="group">
		<button type="button" class="btn btn-danger">
			<router-link class="nav-link" :to="{ name: 'Home' }">
				Cancel
			</router-link>
		</button>
		<button type="button" class="btn btn-success" @click="submitOrder">Proceed to Checkout</button>
	</div>

	<!--For managers-->
	<div class="btn-group float-start" role="group">
		<button type="button" class="btn btn-info">
			<router-link class="nav-link" :to="{ name: 'EditItem' }">
				New Item
			</router-link>
		</button>
	</div>

</template>
  
<style scoped>
button {
	margin-left: 3px;
	margin-right: 3px;
}
</style>
