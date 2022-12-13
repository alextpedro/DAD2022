<script setup>
import { useOrderStore } from '@/stores/orderStore.order.js';
import { inject } from 'vue';

const orderStore = useOrderStore();

const serverBaseUrl = inject('serverBaseUrl');
const apiPort = inject('apiPort');

const removeItemFromOrder = (item) => {
	orderStore.orderStore.order.splice(item,1);
};
</script>

<template>
	<table class="table">
		<thead>
			<tr>
				<th>Photo</th>
				<th>Name</th>
				<th>Type</th>
				<th>Price</th>
				<th>Quantity</th>
			</tr>
		</thead>
		<tbody>
			<tr v-for="item in orderStore.order" :key="item.id">
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
						{{ item.price }}€
					</span>
				</td>
				<td>
					<input type="number" value="1" />
				</td>
				<td>
					<button type="button" class="btn btn-danger" @click="removeItemFromOrder(item)">
						<i class="bi bi-trash"></i>
					</button>
				</td>
			</tr>
		</tbody>
	</table>
	<div class="btn-group float-end" role="group">
		<button class="btn btn-danger">
			<router-link class="nav-link" :to="{ name: 'Menu' }">
				Cancel
			</router-link>
		</button>
		<button class="btn btn-success">Complete Order</button>
	</div>
</template>
