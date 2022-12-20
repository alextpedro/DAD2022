import { defineStore } from 'pinia';
import { ref } from 'vue';

export const useOrderStore = defineStore('order', () => {
	const order = ref(null);
	const ticketNumber = ref(1);

	const getNextTicketN = () => {
		if (ticketNumber.value === 99) {
			ticketNumber.value = 1;
		}
		else {
			ticketNumber.value++;
		}

		return ticketNumber.value;
	};

	return { order,  getNextTicketN};
});