import { defineStore } from 'pinia';
import { inject, ref } from 'vue';

export const useOrderStore = defineStore('order', () => {
	const axios = inject('axios');
	const order = ref(null);
	const ticketNumber = ref(1);

	const getNextTicketN = () => {
		ticketNumber.value += 1;
		if (ticketNumber.value === 99) {
			ticketNumber.value = 1;
		}

		return ticketNumber.value;
	};

	const initTickets = async () => {
		await axios.get('currentTickets')
			.then((response) => {
				ticketNumber.value = response.data;
			});
	};

	return { order, getNextTicketN, initTickets };
});