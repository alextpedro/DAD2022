<script setup>
import { useRouter } from 'vue-router';
import { inject, onMounted, ref } from 'vue';

const router = useRouter();
const axios = inject('axios');
const serverBaseUrl = inject('serverBaseUrl');
const apiPort = inject('apiPort');

const orders = ref([]);

const loadOrders = () => {
	axios.get('orders')
		.then((response) => {
			orders.value = response.data.data;
		})
		.catch((error) => {
			console.log(error);
		});
};

onMounted(() => {
	loadOrders();
});
</script>

<template>
    <h1>Active Orders</h1>
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
