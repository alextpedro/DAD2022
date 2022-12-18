<script setup>
import { useOrderStore } from '@/stores/order.js';
import { useUserStore } from '@/stores/user.js';
import { inject } from 'vue';

const orderStore = useOrderStore();
const userStore = useUserStore();
const axios = inject('axios');
const serverBaseUrl = inject('serverBaseUrl');
const apiPort = inject('apiPort');

const removeItemFromOrder = (item) => {
	orderStore.order.splice(item,1);
};

const checkout = () => {
	axios.post('https://dad-202223-payments-api.vercel.app/api/payments',
		{
			'type': 'visa',
			'reference': '4283456893323321',
			'value': 34.01
		})
		.then(() => {
			createOrder();
		})
		.catch(() => {
			console.log('Payment failure');
		});
};

const createOrder = () => {
	// const date = new Date();
	// const formattedDate = date.getFullYear() + '-' + date.getMonth() + '-' + date.getDay() + ' ' + date.getHours() + '-' + date.getMinutes() + '-' + date.getSeconds();

	const newOrder = {
		'customer_id': userStore.userId,
		'total_price': '1',
		'total_paid': '1',
		'total_paid_with_points': '1',
		'points_gained': '1',
		'points_used_to_pay': '1',
		'payment_type': 'visa',
		'payment_reference': '4283456893323321',
	};
	axios.post(serverBaseUrl + apiPort + '/api/orders', newOrder)
		.then(() => {
			console.log('Order created successfully');
		}).catch(() => {
			console.log('Order failure');
		});
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
		<button class="btn btn-success" @click="checkout">Complete Order</button>
	</div>
</template>
