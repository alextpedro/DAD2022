<script setup>
import { inject, onMounted, ref } from 'vue';
import { useUserStore } from '@/stores/user.js';

const socket = inject('socket');
const axios = inject('axios');
const userStore = useUserStore();

const dishes = ref(null);

const loadDishes = () => {
	//ask server for order items that aren't ready
	axios.get('all_dishes/' + userStore.user.id)
		.then((response) => {
			if (Object.keys(response.data).length !== 0 ) {
				dishes.value = response.data;
			}
		})
		.catch((error) => {
			console.log(error);
		});
};

onMounted(() => {
	loadDishes();
});

socket.on('updateDishes', () => {
	loadDishes();
});
</script>

<template>
    <h1>Unclaimed Dishes</h1>
	<table class="table" v-if="dishes">
		<thead>
			<th>
                ID
			</th>
            <th>
                Status
			</th>
            <th>
                Notes
			</th>
		</thead>
		<tbody>
            <tr v-for="dish in dishes" :key="dish.id">
                <td>
					<span>{{ dish.order_id + '-' + dish.order_local_number }}</span>
				</td>
                <td>
					<span>{{ dish.status }}</span>
				</td>
                <td>
					<span>{{ dish.notes }}</span>
				</td>
            </tr>
		</tbody>
	</table>
    <div v-else>You have never worked here.</div>
</template>