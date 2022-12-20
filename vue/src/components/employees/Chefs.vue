<script setup>
import { inject } from 'vue';

const socket = inject('socket');

const declareReady = () => {
	socket.emit('ready_dish', {});
};
</script>

<template>
    <button type="button" class="btn btn-success" @click="declareReady">Declare Ready</button>
</template>