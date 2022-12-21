<script setup>
import { inject, onMounted, ref } from 'vue';
import { useUserStore } from '@/stores/user.js';

const axios = inject('axios');
const socket = inject('socket');

const userStore = useUserStore();

const orders = ref(null);

const loadOrders = () => {
	if (userStore.user) 
	{
		axios.get('orders/' + userStore.user?.id)
			.then((response) => {
				if (Object.keys(response.data).length !== 0 ) {
					orders.value = response.data;
				}
			})
			.catch((error) => {
				console.log(error);
			});
	}
};

onMounted(() => {
	loadOrders();
});

socket.on('updateOrders', () => {
	loadOrders();
});
</script>

<template>
    <h1>My Orders</h1>
	<table class="table" v-if="orders">
		<thead>
			<tr>
				<th>Ticket #</th>
				<th>Status</th>
				<th>Price</th>
				<th>Paid</th>
				<th>Paid w/ Points</th>
				<th>Points Gained</th>
				<th>Points Used</th>
				<th>Payment Type</th>
				<th>Date</th>
				<th>Delivered By</th>
			</tr>
		</thead>
		<tbody>
			<tr v-for="order in orders" :key="order.id">
				<td>
					<span>{{ order.ticket_number }}</span>
				</td>
				<td>
					<span>{{ order.status }}</span>
				</td>
				<td>
					<span>
						{{ order.total_price }}
					</span>
				</td>
				<td>
					<span>
						{{ order.total_paid }}
					</span>
				</td>
                <td>
					<span>
						{{ order.total_paid_with_points }}
					</span>
				</td>
                <td>
					<span>
						{{ order.points_gained }}
					</span>
				</td>
                <td>
					<span>
						{{ order.points_used_to_pay }}
					</span>
				</td>
                <td>
					<span>
						{{ order.payment_type }}
					</span>
				</td>
                <td>
					<span>
						{{ order.date }}
					</span>
				</td>
                <td>
					<span>
						{{ order.delivered_by }}
					</span>
				</td>
			</tr>
		</tbody>
	</table>
    <div v-else>No ready orders at the moment.</div>
</template>
  
<style scoped>
button {
	margin-left: 3px;
	margin-right: 3px;
}
</style>
