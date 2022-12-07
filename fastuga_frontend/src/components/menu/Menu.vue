<script setup>
import { useRouter } from 'vue-router';
import { inject, onMounted, ref } from 'vue';
// A menu has items 
// const props = defineProps({
//     items: {
//         type: Array,
//         default: () => [],
//     }
// })
const router = useRouter();
const axios = inject('axios');

const items = ref([]);

const submitOrder = () => {
	console.log('TODO - Functionality not implemented.');
	router.push('/order');
	// Bundle all selected menu items
	// Wait for payment?
	// Send order (and hot dishes to chefs?)
};

const loadItems = () => {
	axios.get('products')
		.then((response) => {
			items.value = response.data;
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
					<img :src="'http://127.0.0.1:8000/' + item.photo_url" />
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
					<input type="checkbox" value="Add to Order" />
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

</template>
  
<style scoped>
button {
	margin-left: 3px;
	margin-right: 3px;
}
</style>
