<script setup>
import { inject, onMounted, ref } from 'vue';
import { useUserStore } from '@/stores/user.js';

const userStore = useUserStore();
const axios = inject('axios');
const socket = inject('socket');

const dishes = ref(null);

const declareReady = () => {
	axios.put('declareReady/' + userStore.user.id)
		.then(() => {
			socket.emit('ready_dish', {});
		});
	
};

const loadDishes = () => {
	axios.get('dishes/' + userStore.user.id)
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

socket.on('ready_dish', () => {
	loadDishes();
});
</script>

<template>
    <h1>My Dishes</h1>
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
                <button type="button" class="btn btn-primary" @click="declareReady(dish.id)">Ready!</button>
            </tr>
		</tbody>
	</table>
    <div v-else>You have no dishes at the moment.</div>
</template>