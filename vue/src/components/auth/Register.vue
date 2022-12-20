<script setup>
import { ref, inject } from 'vue';
import { useRouter } from 'vue-router';
import { useUserStore } from '../../stores/user.js';

const router = useRouter();
const toast = inject('toast');
const axios = inject('axios');

const credentials = ref({
    username: '',
    email: '',
    password: '',
    passwordConfirmation: '',
});

const userStore = useUserStore();

const emit = defineEmits(['register']);

const register = async () => {
	if (await userStore.register(credentials.value)) {
		toast.success('User ' + userStore.user.name + ' has register in the application.');
		emit('register');
		router.back();
	} else {
		credentials.value.password = '';
		toast.error('User credentials are invalid!');
	}
};
</script>

<template>
    <div class="vue-template">
        <form>
            <h3 class="mt-5 mb-3">Register</h3>
            <hr>
            <div class="mb-3">
                <div class="mb-3">
                    <label for="inputUsername" class="form-label">Full Name</label>
                    <input type="text" class="form-control" id="inputUsername" required v-model="credentials.username">
                </div>
            </div>
            <div class="mb-3">
                <div class="mb-3">
                    <label for="inputUserEmail" class="form-label">Email</label>
                    <input type="text" class="form-control" id="inputUserEmail" required v-model="credentials.email">
                </div>
            </div>
            <div class="mb-3">
                <div class="mb-3">
                    <label for="inputPassword" class="form-label">Password</label>
                    <input type="password" class="form-control" id="inputPassword" required v-model="credentials.password">
                </div>
            </div>
            <div class="mb-3">
                <div class="mb-3">
                    <label for="inputPasswordConfirmation" class="form-label">Password Confirmation</label>
                    <input type="password" class="form-control" id="inputPasswordConfirmation" required v-model="credentials.passwordConfirmation">
                </div>
            </div>
            <div class="mb-3 d-flex justify-content-center">
                <button type="button" class="btn btn-primary px-5" @click="register">Register</button>
            </div>
        </form>
    </div>
</template>

<style>

</style>