<script setup>
import { useRouter } from 'vue-router';
import { inject, onMounted, ref } from 'vue';
import { useUserStore } from '@/stores/user.js';

const router = useRouter();
const axios = inject('axios');
const serverBaseUrl = inject('serverBaseUrl');
const apiPort = inject('apiPort');

const UserStore = useUserStore();

const selectedUsers = ref([]);

// const submitUserRemove = () => {
// 	UserStore.user = selectedUsers.value;
// 	router.push('User');
// };

const users = ref([]);

const loadUsers = () => {
	axios.get('users')
		.then((response) => {
			users.value = response.data.data;
		})
		.catch((error) => {
			console.log(error);
		});
};

onMounted(() => {
	loadUsers();
});

</script>

<template>
    <table class="table">
        <thead>
            <tr>
                <th>Photo</th>
                <th>Name</th>
                <th>Email</th>
                <th>Type</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="user in users" :key="user.id">
                <td>
                    <img :src="serverBaseUrl + apiPort + '/storage/fotos/' + user.photo_url" width="64" height="64" />
                </td>
                <td>
                    <span>{{ user.name }}</span>
                </td>
                <td>
                    <span>
                        {{ user.email }}
                    </span>
                </td>
                <td>
                    <span>
                        {{ user.type }}
                    </span>
                </td>
                <td>
                    <button type="button" class="btn btn-danger">
                        Delete
                    </button>
                    <button type="button" class="btn btn-info">
                        Edit
                    </button>
                </td>
            </tr>
        </tbody>
    </table>

    <div class="btn-group float-end" role="group">
        <!-- Botão para CANCELAR -->
        <button type="button" class="btn btn-secondary">
            <router-link class="nav-link" :to="{ name: 'Home' }">
                Cancel
            </router-link>
        </button>
        <!-- Botão para ADICIONAR novo User -->
        <button type="button" class="btn btn-info">
            <router-link class="nav-link" :to="{ name: 'Home' }">
                Add User
            </router-link>
        </button>
    </div>

	


</template>

<style scoped>
button {
    margin-left: 3px;
    margin-right: 3px;
}
</style>
